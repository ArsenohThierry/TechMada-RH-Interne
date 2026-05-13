-- ============================================================
--  TechMada RH — Base SQLite3 complète
--  Tables : departements, types_conge, employes, soldes, conges
-- ============================================================

PRAGMA foreign_keys = ON;
PRAGMA journal_mode = WAL;

-- ------------------------------------------------------------
-- 1. DEPARTEMENTS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS departements (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    nom         TEXT    NOT NULL UNIQUE,
    description TEXT
);

-- ------------------------------------------------------------
-- 2. TYPES_CONGE
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS types_conge (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle       TEXT    NOT NULL UNIQUE,
    jours_annuels INTEGER NOT NULL CHECK(jours_annuels > 0),
    deductible    INTEGER NOT NULL DEFAULT 1 CHECK(deductible IN (0,1))
);

-- ------------------------------------------------------------
-- 3. EMPLOYES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS employes (
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    nom              TEXT    NOT NULL,
    prenom           TEXT    NOT NULL,
    email            TEXT    NOT NULL UNIQUE,
    password         TEXT    NOT NULL,               -- password_hash()
    role             TEXT    NOT NULL DEFAULT 'employe'
                             CHECK(role IN ('employe','rh','admin')),
    departement_id   INTEGER REFERENCES departements(id) ON DELETE SET NULL,
    date_embauche    TEXT    NOT NULL,               -- format YYYY-MM-DD
    actif            INTEGER NOT NULL DEFAULT 1 CHECK(actif IN (0,1))
);

-- ------------------------------------------------------------
-- 4. SOLDES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS soldes (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id     INTEGER NOT NULL REFERENCES employes(id)    ON DELETE CASCADE,
    type_conge_id  INTEGER NOT NULL REFERENCES types_conge(id) ON DELETE CASCADE,
    annee          INTEGER NOT NULL,
    jours_attribues INTEGER NOT NULL CHECK(jours_attribues >= 0),
    jours_pris      INTEGER NOT NULL DEFAULT 0 CHECK(jours_pris >= 0),
    -- restant = jours_attribues - jours_pris (jamais stocké, toujours calculé)
    UNIQUE(employe_id, type_conge_id, annee),
    CHECK(jours_pris <= jours_attribues)
);

-- ------------------------------------------------------------
-- 5. CONGES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS conges (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id     INTEGER NOT NULL REFERENCES employes(id)    ON DELETE CASCADE,
    type_conge_id  INTEGER NOT NULL REFERENCES types_conge(id) ON DELETE RESTRICT,
    date_debut     TEXT    NOT NULL,                 -- YYYY-MM-DD
    date_fin       TEXT    NOT NULL,                 -- YYYY-MM-DD
    nb_jours       INTEGER NOT NULL CHECK(nb_jours > 0),
    motif          TEXT,
    statut         TEXT    NOT NULL DEFAULT 'en_attente'
                           CHECK(statut IN ('en_attente','approuvee','refusee','annulee')),
    commentaire_rh TEXT,
    created_at     TEXT    NOT NULL DEFAULT (DATE('now')),
    traite_par     INTEGER REFERENCES employes(id) ON DELETE SET NULL,
    CHECK(date_debut <= date_fin)
);

-- ------------------------------------------------------------
-- INDEX UTILES
-- ------------------------------------------------------------
CREATE INDEX IF NOT EXISTS idx_conges_employe  ON conges(employe_id);
CREATE INDEX IF NOT EXISTS idx_conges_statut   ON conges(statut);
CREATE INDEX IF NOT EXISTS idx_soldes_employe  ON soldes(employe_id, annee);

-- ------------------------------------------------------------
-- VUE : solde restant par employé (calculé à la volée)
-- ------------------------------------------------------------
CREATE VIEW IF NOT EXISTS v_soldes_restants AS
SELECT
    e.id            AS employe_id,
    e.nom || ' ' || e.prenom AS employe,
    d.nom           AS departement,
    tc.libelle      AS type_conge,
    s.annee,
    s.jours_attribues,
    s.jours_pris,
    (s.jours_attribues - s.jours_pris) AS jours_restants
FROM soldes s
JOIN employes    e  ON e.id  = s.employe_id
JOIN types_conge tc ON tc.id = s.type_conge_id
LEFT JOIN departements d ON d.id = e.departement_id;

-- ------------------------------------------------------------
-- VUE : demandes en attente avec détails (espace RH)
-- ------------------------------------------------------------
CREATE VIEW IF NOT EXISTS v_demandes_en_attente AS
SELECT
    c.id,
    e.nom || ' ' || e.prenom AS employe,
    d.nom           AS departement,
    tc.libelle      AS type_conge,
    c.date_debut,
    c.date_fin,
    c.nb_jours,
    c.motif,
    c.created_at,
    (s.jours_attribues - s.jours_pris) AS solde_actuel
FROM conges c
JOIN employes    e  ON e.id  = c.employe_id
JOIN types_conge tc ON tc.id = c.type_conge_id
LEFT JOIN departements d ON d.id = e.departement_id
LEFT JOIN soldes s ON (
    s.employe_id    = c.employe_id AND
    s.type_conge_id = c.type_conge_id AND
    s.annee         = CAST(strftime('%Y', c.date_debut) AS INTEGER)
)
WHERE c.statut = 'en_attente';

-- ============================================================
--  SEED — données initiales
-- ============================================================

-- Départements
INSERT INTO departements (nom, description) VALUES
    ('Développement',  'Équipe technique et ingénierie'),
    ('Ressources Humaines', 'Administration du personnel'),
    ('Direction',      'Direction générale');

-- Types de congé
INSERT INTO types_conge (libelle, jours_annuels, deductible) VALUES
    ('Congé annuel',     30, 1),
    ('Congé maladie',    15, 1),
    ('Congé sans solde', 10, 0);

-- Employés  (passwords = password_hash simulé ici en texte lisible)
-- Admin
INSERT INTO employes (nom, prenom, email, password, role, departement_id, date_embauche) VALUES
    ('Rakoto',    'Admin',   'admin@techmada.mg',
     '$2y$10$hashed_admin_password',  'admin',   3, '2020-01-01');

-- Responsables RH
INSERT INTO employes (nom, prenom, email, password, role, departement_id, date_embauche) VALUES
    ('Rabe',      'Hery',    'hery.rabe@techmada.mg',
     '$2y$10$hashed_rh_password',     'rh',      2, '2021-03-15');

-- Employés
INSERT INTO employes (nom, prenom, email, password, role, departement_id, date_embauche) VALUES
    ('Randria',   'Alice',   'alice.randria@techmada.mg',
     '$2y$10$hashed_alice_password',  'employe', 1, '2022-06-01'),
    ('Ramaroson', 'Bob',     'bob.ramaroson@techmada.mg',
     '$2y$10$hashed_bob_password',    'employe', 1, '2021-09-10');

-- Soldes 2026
-- Alice : 30 annuel (10 pris), 15 maladie (0 pris)
INSERT INTO soldes (employe_id, type_conge_id, annee, jours_attribues, jours_pris) VALUES
    (3, 1, 2026, 30, 10),
    (3, 2, 2026, 15,  0),
    (3, 3, 2026, 10,  0);

-- Bob : 30 annuel (28 pris), 15 maladie (15 pris — épuisé)
INSERT INTO soldes (employe_id, type_conge_id, annee, jours_attribues, jours_pris) VALUES
    (4, 1, 2026, 30, 28),
    (4, 2, 2026, 15, 15),
    (4, 3, 2026, 10,  0);


-- Demandes de congé
INSERT INTO conges (employe_id, type_conge_id, date_debut, date_fin, nb_jours, motif, statut, traite_par, created_at) VALUES
    -- Alice : annuel approuvé (10j)
    (3, 1, '2026-03-01', '2026-03-10', 10, 'Vacances famille',   'approuvee', 2, '2026-02-20'),
    -- Bob : annuel approuvé (28j)
    (4, 1, '2026-01-15', '2026-02-11', 28, 'Congé annuel',       'approuvee', 2, '2026-01-10'),
    -- Alice : annuel en attente (10j)
    (3, 1, '2026-06-20', '2026-06-29', 10, 'Voyage',             'en_attente', NULL, '2026-06-01'),
    -- Bob : maladie refusée (solde épuisé)
    (4, 2, '2026-04-01', '2026-04-05',  5, 'Grippe',             'refusee', 2, '2026-03-31'),
    -- Alice : sans solde annulée
    (3, 3, '2026-05-10', '2026-05-12',  3, 'Affaire personnelle','annulee', NULL, '2026-05-01');

-- Commentaire RH sur le refus de Bob
UPDATE conges SET commentaire_rh = 'Solde maladie insuffisant (0 jours restants)' WHERE id = 4;