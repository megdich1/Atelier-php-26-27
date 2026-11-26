<?php

const FICHIER_UTILISATEURS = __DIR__ . '/data/utilisateurs.php';

function estConnecte()
{
    return isset($_SESSION['connecte'])
        && $_SESSION['connecte'] === true;
}

function protegerPage()
{
    if (!estConnecte()) {
        header("Location: login.php");
        exit;
    }
}

function chargerUtilisateurs()
{
    if (!file_exists(FICHIER_UTILISATEURS)) {
        $utilisateurs = ["admin" => password_hash("123456", PASSWORD_DEFAULT)];
        sauvegarderUtilisateurs($utilisateurs);
        return $utilisateurs;
    }
    return require FICHIER_UTILISATEURS;
}

function sauvegarderUtilisateurs($utilisateurs)
{
    $code = "<?php\nreturn " . var_export($utilisateurs, true) . ";\n";
    file_put_contents(FICHIER_UTILISATEURS, $code, LOCK_EX);
}