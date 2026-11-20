<?php
session_start();
require_once 'fonctions.php';
protegerPage();

$username = $_SESSION['username'];
$erreurs = [];
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ancien = $_POST['ancien'] ?? '';
    $nouveau = $_POST['nouveau'] ?? '';
    $confirmation = $_POST['confirmation'] ?? '';

    $utilisateurs = chargerUtilisateurs();

    if (!isset($utilisateurs[$username]) ||
        !password_verify($ancien, $utilisateurs[$username])) {
        $erreurs[] = "L'ancien mot de passe est incorrect.";
    }
    if (strlen($nouveau) < 6) {
        $erreurs[] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
    }
    if ($nouveau !== $confirmation) {
        $erreurs[] = "Les deux mots de passe ne sont pas identiques.";
    }

    if (empty($erreurs)) {
        $utilisateurs[$username] = password_hash($nouveau, PASSWORD_DEFAULT);
        sauvegarderUtilisateurs($utilisateurs);
        $succes = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier mon mot de passe</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Modifier mon mot de passe</h1>
    <p>Utilisateur connecté : <?= htmlspecialchars($username) ?></p>

    <?php foreach ($erreurs as $erreur): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endforeach; ?>

    <?php if ($succes): ?>
        <p style="color:green;">Mot de passe modifié avec succès.</p>
    <?php endif; ?>

    <form method="POST">
        <label>Ancien mot de passe :</label>
        <input type="password" name="ancien">
        <label>Nouveau mot de passe :</label>
        <input type="password" name="nouveau">
        <label>Confirmation :</label>
        <input type="password" name="confirmation">
        <button type="submit">Modifier</button>
    </form>

    <p><a href="dashboard.php">← Retour au tableau de bord</a></p>
</body>
</html>
