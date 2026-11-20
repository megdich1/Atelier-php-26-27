<?php
require 'connexion.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === null) {
    die("Identifiant invalide.");
}

$sql = "DELETE FROM etudiants WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

header('Location: liste.php');
exit;