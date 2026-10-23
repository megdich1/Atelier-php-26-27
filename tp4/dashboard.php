<?php
session_start();
require_once 'fonctions.php';
protegerPage();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Tableau de bord</h1>
    <p>Utilisateur connecté : <?= htmlspecialchars($_SESSION['username']) ?></p>

    <h2>Gestion des étudiants</h2>
    <ul>
        <li><a href="index.php">Liste des étudiants</a></li>
        <li><a href="ajouter.php">Ajouter un étudiant</a></li>
        <li><a href="rechercher.php">Rechercher un étudiant</a></li>
        <li><a href="changer_mdp.php">Modifier mon mot de passe</a></li>
        <li><a href="logout.php">Se déconnecter</a></li>
    </ul>
</body>
</html>