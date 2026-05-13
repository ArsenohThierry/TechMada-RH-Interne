CREATE DATABASE IF NOT EXISTS conge;
use conge;


CREATE TABLE IF NOT EXISTS departement(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS employes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('employe', 'admin', 'rh') NOT NULL DEFAULT 'employe',
    id_departement INT,
    date_embauche DATE,
    actif BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_departement) REFERENCES departement(id)
);

CREATE TABLE IF NOT EXISTS type_conge(
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    jours_annuels INT NOT NULL,
    deductible BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS soldes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_employe INT NOT NULL,
    id_type_conge INT NOT NULL,
    annee INT NOT NULL,
    jours_attribuables INT NOT NULL,
    jours_pris INT NOT NULL DEFAULT 0,
    FOREIGN KEY (id_employe) REFERENCES employes(id),
    FOREIGN KEY (id_type_conge) REFERENCES type_conge(id)
);