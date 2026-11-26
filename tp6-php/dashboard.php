<?php
require_once __DIR__ . '/auth.php';
protegerPage();

$utilisateur = utilisateurCourant();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Tableau de bord</h1>
    <p>Bienvenue, <?= htmlspecialchars($utilisateur['username'], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Rôle : <?= htmlspecialchars($utilisateur['role'], ENT_QUOTES, 'UTF-8') ?></p>

    <ul>
        <li><a href="etudiants.php">Gestion des étudiants</a></li>
        <?php if (estAdmin()): ?>
            <li><a href="admin.php">Administration</a></li>
            <li><a href="utilisateurs.php">Gestion des utilisateurs</a></li>
        <?php endif; ?>
        <li><a href="deconnexion.php">Se déconnecter</a></li>
    </ul>
</body>
</html>