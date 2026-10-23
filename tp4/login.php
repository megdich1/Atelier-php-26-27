<?php
session_start();
require_once 'fonctions.php';

if (estConnecte()) {
    header("Location: dashboard.php");
    exit;
}

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $utilisateurs = chargerUtilisateurs();

    if (isset($utilisateurs[$username]) &&
        password_verify($password, $utilisateurs[$username])) {

        session_regenerate_id(true);
        $_SESSION['username'] = $username;
        $_SESSION['connecte'] = true;

        header("Location: dashboard.php");
        exit;
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Connexion</h1>

    <?php if ($erreur !== ""): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username">
        <label>Mot de passe :</label>
        <input type="password" name="password">
        <button type="submit">Se connecter</button>
    </form>

    <p>Pas de compte ? <a href="inscription.php">S'inscrire</a></p>
</body>
</html>