<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/connexion_bdd.php';
protegerAdmin();

$sql = "SELECT id, username, role, actif, created_at
        FROM utilisateurs
        ORDER BY username";
$stmt = $pdo->query($sql);
$utilisateurs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des utilisateurs</title>
</head>
<body>
    <h1>Gestion des utilisateurs</h1>
    <p>
        <a href="dashboard.php">Retour au tableau de bord</a> |
        <a href="utilisateur-creer.php">Créer un utilisateur</a> |
        <a href="deconnexion.php">Se déconnecter</a>
    </p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Créé le</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $u): ?>
                <tr>
                    <td><?= (int) $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['username'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($u['role'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $u['actif'] ? 'Actif' : 'Inactif' ?></td>
                    <td><?= htmlspecialchars($u['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="utilisateur-role.php?id=<?= (int) $u['id'] ?>">Rôle</a> |
                        <a href="utilisateur-statut.php?id=<?= (int) $u['id'] ?>">Activer / Désactiver</a> |
                        <a href="utilisateur-supprimer.php?id=<?= (int) $u['id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>