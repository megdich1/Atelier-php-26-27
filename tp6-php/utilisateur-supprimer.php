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
    if ((int) $utilisateur['id'] === (int) $_SESSION['user_id']) {
        $erreur = "Vous ne pouvez pas supprimer votre propre compte.";
    } elseif ($utilisateur['role'] === 'admin' && (int) $utilisateur['actif'] === 1) {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE role = 'admin' AND actif = 1";
        $nb = (int) $pdo->query($sql)->fetchColumn();
        if ($nb <= 1) {
            $erreur = "Impossible : il doit rester au moins un administrateur actif.";
        }
    }

    if ($erreur === '') {
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $utilisateur['id']]);
        $succes = "Utilisateur supprimé.";
        $utilisateur = null;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un utilisateur</title>
</head>
<body>
    <h1>Supprimer un utilisateur</h1>
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

    <?php if ($utilisateur !== null): ?>
        <p>Confirmer la suppression de <strong><?= htmlspecialchars($utilisateur['username'], ENT_QUOTES, 'UTF-8') ?></strong> ?</p>
        <form method="POST">
            <button type="submit">Supprimer définitivement</button>
        </form>
    <?php endif; ?>
</body>
</html>