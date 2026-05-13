<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace RH — TechMada</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: sans-serif;
            font-size: 14px;
            background: #f4f4f4;
            color: #222;
        }

        /* HEADER */
        header {
            background: #1a1a2e;
            color: #fff;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header span { font-size: 13px; opacity: .7; }
        header a { color: #aaa; font-size: 13px; text-decoration: none; }
        header a:hover { color: #fff; }

        main { max-width: 1100px; margin: 30px auto; padding: 0 16px; }

        /* FLASH */
        .flash-success { background: #d1e7dd; color: #0f5132; padding: 10px 14px; margin-bottom: 16px; border-radius: 4px; }
        .flash-error   { background: #f8d7da; color: #842029; padding: 10px 14px; margin-bottom: 16px; border-radius: 4px; }

        /* FILTRES */
        .filtres {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .filtres label { font-size: 13px; color: #555; }
        .filtres select, .filtres input {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 13px;
            background: #fff;
        }
        .filtres button {
            padding: 6px 14px;
            background: #1a1a2e;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .filtres button:hover { background: #2e2e50; }
        .filtres a {
            font-size: 13px;
            color: #888;
            text-decoration: none;
            padding: 6px 0;
        }
        .filtres a:hover { color: #222; }

        /* TABLEAU */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th {
            background: #eee;
            text-align: left;
            padding: 10px 12px;
            font-size: 13px;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        /* BADGES */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge.en_attente { background: #fff3cd; color: #856404; }
        .badge.approuvee  { background: #d1e7dd; color: #0f5132; }
        .badge.refusee    { background: #f8d7da; color: #842029; }
        .badge.annulee    { background: #e2e3e5; color: #555; }

        /* ACTIONS */
        .actions { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }

        .btn-approuver {
            background: #198754;
            color: #fff;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-approuver:hover { background: #146c43; }

        .btn-refuser {
            background: none;
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-refuser:hover { background: #f8d7da; }

        /* MODAL REFUS */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: #fff;
            padding: 24px;
            border-radius: 6px;
            width: 420px;
            max-width: 95%;
        }
        .modal h3 { margin-bottom: 14px; font-size: 15px; }
        .modal textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 13px;
            resize: vertical;
            min-height: 80px;
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 14px;
        }
        .modal-actions button[type=button] {
            background: none;
            border: 1px solid #ccc;
            padding: 6px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .modal-actions button[type=submit] {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }
        .modal-actions button[type=submit]:hover { background: #b02a37; }

        .empty { text-align: center; padding: 30px; color: #888; }

        /* COMPTEURS */
        .stats {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 12px 20px;
            text-align: center;
            min-width: 110px;
        }
        .stat-card .nb  { font-size: 22px; font-weight: bold; }
        .stat-card .lbl { font-size: 12px; color: #888; margin-top: 2px; }
        .nb.att  { color: #856404; }
        .nb.app  { color: #0f5132; }
        .nb.ref  { color: #842029; }
    </style>
</head>
<body>

<header>
    <strong>TechMada RH — Espace Responsable</strong>
    <span>Connecté : <?= esc(session('employe_nom')) ?></span>
    <a href="/logout">Déconnexion</a>
</header>

<main>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- COMPTEURS -->
    <div class="stats">
        <div class="stat-card">
            <div class="nb att"><?= $nb_en_attente ?></div>
            <div class="lbl">En attente</div>
        </div>
        <div class="stat-card">
            <div class="nb app"><?= $nb_approuvees ?></div>
            <div class="lbl">Approuvées</div>
        </div>
        <div class="stat-card">
            <div class="nb ref"><?= $nb_refusees ?></div>
            <div class="lbl">Refusées</div>
        </div>
        <div class="stat-card">
            <div class="nb" style="color:#222"><?= $nb_total ?></div>
            <div class="lbl">Total</div>
        </div>
    </div>

    <!-- FILTRES -->
    <div class="filtres">
        <label>Statut</label>
        <select id="filter-statut">
            <option value="">Tous</option>
            <option value="en_attente">En attente</option>
            <option value="approuvee">Approuvée</option>
            <option value="refusee">Refusée</option>
            <option value="annulee">Annulée</option>
        </select>

        <label>Département</label>
        <select id="filter-dept">
            <option value="">Tous</option>
            <?php foreach ($departements as $dep): ?>
                <option value="<?= $dep['id'] ?>">
                    <?= esc($dep['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- TABLEAU -->
    <table>
        <thead>
            <tr>
                <th>Employé</th>
                <th>Département</th>
                <th>Type</th>
                <th>Du</th>
                <th>Au</th>
                <th>Jours</th>
                <th>Motif</th>
                <th>Soumis le</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($conges)): ?>
                <tr><td colspan="10" class="empty">Aucune demande trouvée.</td></tr>
            <?php else: ?>
                <?php foreach ($conges as $c): ?>
                <tr>
                <td><?= esc($c['employe_nom']) . ' ' . esc($c['employe_prenom']) ?></td>
                <td><?= esc($c['departement'] ?? '—') ?></td>
                <td><?= esc($c['type_conge_libelle']) ?></td>
                <td><?= esc($c['date_debut']) ?></td>
                <td><?= esc($c['date_fin']) ?></td>
                <td><?= esc($c['nb_jours']) ?></td>
                <td><?= esc($c['motif'] ?? '—') ?></td>
                <td><?= esc($c['created_at']) ?></td>
                <td><span class="badge <?= esc($c['statut']) ?>"><?= esc($c['statut']) ?></span></td>
                <td>
                    <?php if ($c['statut'] === 'en_attente'): ?>
                        <div class="actions">

                            <!-- Approuver -->
                            <form method="POST" action="/rh/conges/approuver/<?= $c['id'] ?>">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                <button class="btn-approuver"
                                        onclick="return confirm('Approuver cette demande ?')">
                                    Approuver
                                </button>
                            </form>

                            <!-- Refuser (ouvre modal) -->
                            <button class="btn-refuser"
                                    onclick="ouvrirModal(<?= $c['id'] ?>)">
                                Refuser
                            </button>

                        </div>
                    <?php elseif ($c['statut'] === 'approuvee'): ?>
                        <!-- Annuler une approbation (remboursement solde) -->
                        <form method="POST" action="/rh/conges/annuler/<?= $c['id'] ?>">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                            <button class="btn-refuser"
                                    onclick="return confirm('Annuler cette approbation ? Le solde sera remboursé.')">
                                Annuler
                            </button>
                        </form>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</main>

<!-- MODAL REFUS -->
<div class="modal-overlay" id="modal-overlay">
    <div class="modal">
        <h3>Refuser la demande</h3>
        <form method="POST" id="form-refus" action="">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
            <label for="commentaire_rh" style="font-size:13px; display:block; margin-bottom:6px;">
                Commentaire (optionnel)
            </label>
            <textarea name="commentaire_rh" id="commentaire_rh"
                      placeholder="Ex : Solde insuffisant, période chargée..."></textarea>
            <div class="modal-actions">
                <button type="button" onclick="fermerModal()">Annuler</button>
                <button type="submit">Confirmer le refus</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Données complètes de toutes les demandes
    const tousLesConges = <?= json_encode($conges) ?>;

    // Éléments du DOM
    const filterStatut = document.getElementById('filter-statut');
    const filterDept = document.getElementById('filter-dept');
    const tableBody = document.querySelector('table tbody');

    // Fonction pour filtrer et afficher les données
    function appliquerFiltres() {
        const statutSelectionne = filterStatut.value;
        const deptSelectionne = filterDept.value;

        // Filtrer les données
        const donneesFiltrees = tousLesConges.filter(c => {
            const matchStatut = !statutSelectionne || c.statut === statutSelectionne;
            const matchDept = !deptSelectionne || (c.departement_id && c.departement_id == deptSelectionne);
            return matchStatut && matchDept;
        });

        // Mettre à jour le tableau
        afficherTableau(donneesFiltrees);

        // Recalculer et afficher les compteurs
        mettreAJourCompteurs(donneesFiltrees);
    }

    // Fonction pour afficher le tableau
    function afficherTableau(donnees) {
        tableBody.innerHTML = '';

        if (donnees.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="10" class="empty">Aucune demande trouvée.</td></tr>';
            return;
        }

        donnees.forEach(c => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${escapeHtml(c.employe_nom + ' ' + c.employe_prenom)}</td>
                <td>${escapeHtml(c.departement ?? '—')}</td>
                <td>${escapeHtml(c.type_conge_libelle)}</td>
                <td>${escapeHtml(c.date_debut)}</td>
                <td>${escapeHtml(c.date_fin)}</td>
                <td>${escapeHtml(c.nb_jours)}</td>
                <td>${escapeHtml(c.motif ?? '—')}</td>
                <td>${escapeHtml(c.created_at)}</td>
                <td><span class="badge ${escapeHtml(c.statut)}">${escapeHtml(c.statut)}</span></td>
                <td>${genererActions(c)}</td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // Fonction pour générer les actions
    function genererActions(c) {
        if (c.statut === 'en_attente') {
            return `
                <div class="actions">
                    <form method="POST" action="/rh/conges/approuver/${c.id}">
                        <input type="hidden" name="${csrfTokenName()}" value="${csrfTokenHash()}">
                        <button class="btn-approuver" onclick="return confirm('Approuver cette demande ?')">
                            Approuver
                        </button>
                    </form>
                    <button class="btn-refuser" onclick="ouvrirModal(${c.id})">
                        Refuser
                    </button>
                </div>
            `;
        } else if (c.statut === 'approuvee') {
            return `
                <form method="POST" action="/rh/conges/annuler/${c.id}">
                    <input type="hidden" name="${csrfTokenName()}" value="${csrfTokenHash()}">
                    <button class="btn-refuser" onclick="return confirm('Annuler cette approbation ? Le solde sera remboursé.')">
                        Annuler
                    </button>
                </form>
            `;
        }
        return '—';
    }

    // Fonction pour mettre à jour les compteurs
    function mettreAJourCompteurs(donnees) {
        const nbAttente = donnees.filter(c => c.statut === 'en_attente').length;
        const nbApprouvees = donnees.filter(c => c.statut === 'approuvee').length;
        const nbRefusees = donnees.filter(c => c.statut === 'refusee').length;
        const nbTotal = donnees.length;

        document.querySelector('.stat-card:nth-child(1) .nb').textContent = nbAttente;
        document.querySelector('.stat-card:nth-child(2) .nb').textContent = nbApprouvees;
        document.querySelector('.stat-card:nth-child(3) .nb').textContent = nbRefusees;
        document.querySelector('.stat-card:nth-child(4) .nb').textContent = nbTotal;
    }

    // Fonction utilitaire pour échapper l'HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Fonction pour obtenir le nom du token CSRF (si disponible)
    function csrfTokenName() {
        // À adapter selon votre configuration CodeIgniter
        return '<?= csrf_token() ?>';
    }

    // Fonction pour obtenir le hash du token CSRF (si disponible)
    function csrfTokenHash() {
        // À adapter selon votre configuration CodeIgniter
        return '<?= csrf_hash() ?>';
    }

    // Event listeners
    filterStatut.addEventListener('change', appliquerFiltres);
    filterDept.addEventListener('change', appliquerFiltres);

    // Initialiser le tableau au chargement
    appliquerFiltres();

    // Modal
    function ouvrirModal(congeId) {
        document.getElementById('form-refus').action = '/rh/conges/refuser/' + congeId;
        document.getElementById('modal-overlay').classList.add('open');
    }

    function fermerModal() {
        document.getElementById('modal-overlay').classList.remove('open');
        document.getElementById('commentaire_rh').value = '';
    }

    document.getElementById('modal-overlay').addEventListener('click', function(e) {
        if (e.target === this) fermerModal();
    });
</script>

</body>
</html>