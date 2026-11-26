<?php
require_once __DIR__ . '/auth.php';

if (estConnecte()) {
    header("Location: dashboard.php");
} else {
    header("Location: connexion.php");
}
exit;