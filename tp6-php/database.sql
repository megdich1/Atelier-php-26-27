CREATE DATABASE IF NOT EXISTS gestion_etudiants
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE gestion_etudiants;

CREATE TABLE IF NOT EXISTS etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    formation VARCHAR(150) NOT NULL,
    moyenne DECIMAL(4,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    actif TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO etudiants (nom, prenom, age, formation, moyenne)
VALUES
('Dupont', 'Ahmed', 21, 'Informatique', 14.00),
('Martin', 'Sami', 22, 'Informatique', 11.00),
('Ben Salah', 'Ali', 20, 'Informatique', 16.00);