<?php
session_start();
require_once 'fonctions.php';

$erreurs = [];
$succes = false;
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmation = $_POST['confirmation'] ?? '';

    $utilisateurs = chargerUtilisateurs();

    if ($username === '') {
        $erreurs[] = "Le nom d'utilisateur ne doit pas être vide.";
    } elseif (isset($utilisateurs[$username])) {
        $erreurs[] = "Ce nom d'utilisateur existe déjà.";
    }

    
    if (strlen($password) < 6) {
        $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    
    if ($password !== $confirmation) {
        $erreurs[] = "Les deux mots de passe ne sont pas identiques.";
    }

    
    if (empty($erreurs)) {
        $utilisateurs[$username] = password_hash($password, PASSWORD_DEFAULT);
        sauvegarderUtilisateurs($utilisateurs);
        $succes = true;
        $username = "";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Inscription</h1>

    <?php foreach ($erreurs as $erreur): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endforeach; ?>

    <?php if ($succes): ?>
        <p style="color:green;">Inscription réussie ! <a href="login.php">Se connecter</a></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
        <label>Mot de passe :</label>
        <input type="password" name="password">
        <label>Confirmation du mot de passe :</label>
        <input type="password" name="confirmation">
        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
</body>
</html>