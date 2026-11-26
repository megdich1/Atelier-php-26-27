<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/connexion_bdd.php';
protegerAdmin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id <= 0) {
    exit("Identifiant invalide.");
}

$sql = "SELECT id, username, role, actif FROM utilisateurs WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$utilisateur = $stmt->fetch();

if (!$utilisateur) {
    exit("Utilisateur introuvable.");
}

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouveauRole = (string) ($_POST['role'] ?? '');

    if (!in_array($nouveauRole, ['admin', 'user'], true)) {
        $erreur = "Rôle invalide.";
    } elseif ((int) $utilisateur['id'] === (int) $_SESSION['user_id'] && $nouveauRole !== 'admin') {
        $erreur = "Vous ne pouvez pas retirer votre propre rôle administrateur.";
    } else {
        if ($utilisateur['role'] === 'admin' && (int) $utilisateur['actif'] === 1 && $nouveauRole === 'user') {
            $sql = "SELECT COUNT(*) FROM utilisateurs WHERE role = 'admin' AND actif = 1";
            $nb = (int) $pdo->query($sql)->fetchColumn();
            if ($nb <= 1) {
                $erreur = "Impossible : il doit rester au moins un administrateur actif.";
            }
        }

        if ($erreur === '') {
            $sql = "UPDATE utilisateurs SET role = :role WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'role' => $nouveauRole,
                'id' => $utilisateur['id']
            ]);
            $utilisateur['role'] = $nouveauRole;
            $succes = "Rôle mis à jour.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le rôle</title>
</head>
<body>
    <h1>Modifier le rôle de <?= htmlspecialchars($utilisateur['username'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p>
        <a href="utilisateurs.php">Retour à la liste</a> |
        <a href="deconnexion.php">Se déconnecter</a>
    </p>

    <?php if ($erreur !== ''): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if ($succes !== ''): ?>
        <p style="color:green;"><?= htmlspecialchars($succes, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="role">Nouveau rôle :</label>
        <select id="role" name="role">
            <option value="user" <?= $utilisateur['role'] === 'user' ? 'selected' : '' ?>>user</option>
            <option value="admin" <?= $utilisateur['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
        </select>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>