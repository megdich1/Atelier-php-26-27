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
    $nouvelEtat = filter_var($_POST['actif'] ?? null, FILTER_VALIDATE_INT);

    if ($nouvelEtat === false || !in_array($nouvelEtat, [0, 1], true)) {
        $erreur = "Valeur invalide.";
    } elseif ((int) $utilisateur['id'] === (int) $_SESSION['user_id'] && $nouvelEtat === 0) {
        $erreur = "Vous ne pouvez pas désactiver votre propre compte.";
    } else {
        if ($utilisateur['role'] === 'admin' && (int) $utilisateur['actif'] === 1 && $nouvelEtat === 0) {
            $sql = "SELECT COUNT(*) FROM utilisateurs WHERE role = 'admin' AND actif = 1";
            $nb = (int) $pdo->query($sql)->fetchColumn();
            if ($nb <= 1) {
                $erreur = "Impossible : il doit rester au moins un administrateur actif.";
            }
        }

        if ($erreur === '') {
            $sql = "UPDATE utilisateurs SET actif = :actif WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'actif' => $nouvelEtat,
                'id' => $utilisateur['id']
            ]);
            $utilisateur['actif'] = $nouvelEtat;
            $succes = "Statut mis à jour.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activer / Désactiver</title>
</head>
<body>
    <h1>Statut de <?= htmlspecialchars($utilisateur['username'], ENT_QUOTES, 'UTF-8') ?></h1>
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

    <p>Statut actuel : <?= $utilisateur['actif'] ? 'Actif' : 'Inactif' ?></p>

    <form method="POST">
        <?php if ($utilisateur['actif']): ?>
            <input type="hidden" name="actif" value="0">
            <button type="submit">Désactiver</button>
        <?php else: ?>
            <input type="hidden" name="actif" value="1">
            <button type="submit">Activer</button>
        <?php endif; ?>
    </form>
</body>
</html>