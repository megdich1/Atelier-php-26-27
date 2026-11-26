<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estConnecte(): bool
{
    return isset($_SESSION['connecte']) && $_SESSION['connecte'] === true;
}

function utilisateurCourant(): ?array
{
    if (!estConnecte()) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? '',
        'role' => $_SESSION['role'] ?? 'user'
    ];
}

function estAdmin(): bool
{
    return estConnecte() && ($_SESSION['role'] ?? '') === 'admin';
}

function protegerPage(): void
{
    if (!estConnecte()) {
        header("Location: connexion.php");
        exit;
    }
}

function protegerAdmin(): void
{
    protegerPage();
    if (!estAdmin()) {
        header("Location: dashboard.php");
        exit;
    }
}