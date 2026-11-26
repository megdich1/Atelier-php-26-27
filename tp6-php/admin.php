<?php
require_once __DIR__ . '/auth.php';
protegerAdmin();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
</head>
<body>
    <h1>Espace administrateur</h1>
    <p>Cette page est réservée aux administrateurs.</p>

    <ul>
        <li><a href="utilisateurs.php">Gérer les utilisateurs</a></li>
        <li><a href="etudiants.php">Gérer les étudiants</a></li>
    </ul>

    <p>
        <a href="dashboard.php">Retour au tableau de bord</a> |
        <a href="deconnexion.php">Se déconnecter</a>
    </p>
</body>
</html>