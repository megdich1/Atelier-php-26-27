<?php
function afficherBonjour($nom)
{
echo "<p>Bonjour " . $nom . "</p>";
}

function additionner($a, $b)
{
return $a + $b;
}

function calculerMoyenne($note1, $note2, $note3)
{
return ($note1 + $note2 + $note3) / 3;
}

function determinerResultat($moyenne)
{
if ($moyenne >= 10) {
return "Admis";
}
return "Ajourné";
}

function appreciation($moyenne)
{
if ($moyenne < 10) {
return "Insuffisant";
} elseif ($moyenne < 12) {
return "Passable";
} elseif ($moyenne < 14) {
return "Assez bien";
} elseif ($moyenne < 16) {
return "Bien";
}
return "Très bien";
}

function afficherEtudiant($etudiant)
{
echo "<p>Nom : {$etudiant['nom']}</p>";
echo "<p>Prénom : {$etudiant['prenom']}</p>";
echo "<p>Âge : {$etudiant['age']}</p>";
echo "<p>Moyenne : {$etudiant['moyenne']}</p>";
echo "<p>Résultat : " . determinerResultat($etudiant['moyenne']) . "</p>";
echo "<p>Appréciation : " . appreciation($etudiant['moyenne']) . "</p>";
}

function calculerMoyenneClasse($etudiants)
{
$somme = 0;
foreach ($etudiants as $etudiant) {
$somme += $etudiant["moyenne"];
}
return $somme / count($etudiants);
}

function rechercherEtudiant($etudiants, $nom)
{
foreach ($etudiants as $etudiant) {
if ($etudiant["nom"] === $nom) {
return $etudiant;
}
}
return null;
}

function obtenirAdmis($etudiants)
{
$admis = [];
foreach ($etudiants as $etudiant) {
if ($etudiant["moyenne"] >= 10) {
$admis[] = $etudiant;
}
}
return $admis;
}

function filtrerParMoyenne($etudiants, $moyenneMinimale)
{
$resultat = [];
foreach ($etudiants as $etudiant) {
if ($etudiant["moyenne"] >= $moyenneMinimale) {
$resultat[] = $etudiant;
}
}
return $resultat;
}

function afficherTableauEtudiants($etudiants)
{
echo "<table border='1'>";
echo "<tr><th>Nom</th><th>Prénom</th><th>Âge</th><th>Moyenne</th><th>Résultat</th><th>Appréciation</th></tr>";
foreach ($etudiants as $etudiant) {
echo "<tr>";
echo "<td>{$etudiant['nom']}</td>";
echo "<td>{$etudiant['prenom']}</td>";
echo "<td>{$etudiant['age']}</td>";
echo "<td>{$etudiant['moyenne']}</td>";
echo "<td>" . determinerResultat($etudiant['moyenne']) . "</td>";
echo "<td>" . appreciation($etudiant['moyenne']) . "</td>";
echo "</tr>";
}
echo "</table>";
}

function trouverMeilleurEtudiant($etudiants)
{
$meilleur = $etudiants[0];
foreach ($etudiants as $etudiant) {
if ($etudiant["moyenne"] > $meilleur["moyenne"]) {
$meilleur = $etudiant;
}
}
return $meilleur;
}

function meilleureMoyenne($etudiants)
{
$max = $etudiants[0]["moyenne"];
foreach ($etudiants as $etudiant) {
if ($etudiant["moyenne"] > $max) {
$max = $etudiant["moyenne"];
}
}
return $max;
}

function plusFaibleMoyenne($etudiants)
{
$min = $etudiants[0]["moyenne"];
foreach ($etudiants as $etudiant) {
if ($etudiant["moyenne"] < $min) {
$min = $etudiant["moyenne"];
}
}
return $min;
}

function compterMoyenneMinimale($etudiants, $minimum)
{
return count(filtrerParMoyenne($etudiants, $minimum));
}

function pourcentageAdmis($etudiants)
{
return (count(obtenirAdmis($etudiants)) / count($etudiants)) * 100;
}