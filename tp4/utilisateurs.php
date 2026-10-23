<?php
require_once 'utilisateur.php';

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
