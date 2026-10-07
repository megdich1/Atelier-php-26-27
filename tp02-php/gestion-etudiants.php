<?php
require_once "fonctions.php";

$etudiants = [
["nom" => "Khediri",   "prenom" => "Ahmed",   "age" => 20, "moyenne" => 14.5],
["nom" => "Ali",       "prenom" => "Sami",    "age" => 21, "moyenne" => 11.5],
["nom" => "Ben Salah", "prenom" => "Nour",    "age" => 19, "moyenne" => 16],
["nom" => "Trabelsi",  "prenom" => "Amine",   "age" => 22, "moyenne" => 8.5],
["nom" => "Gharbi",    "prenom" => "Yassine", "age" => 20, "moyenne" => 12.75],
["nom" => "Mansour",   "prenom" => "Sarra",   "age" => 21, "moyenne" => 9.5]
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des étudiants</title>
</head>
<body>
<h1>Gestion des étudiants</h1>

<h2>Liste des étudiants</h2>
<?php
afficherTableauEtudiants($etudiants);
?>

<h2>Statistiques</h2>
<?php
echo "<p>Nombre d'étudiants : " . count($etudiants) . "</p>";
echo "<p>Moyenne de la classe : " . round(calculerMoyenneClasse($etudiants), 2) . "</p>";
echo "<p>Nombre d'admis : " . count(obtenirAdmis($etudiants)) . "</p>";

$meilleur = trouverMeilleurEtudiant($etudiants);
echo "<p>Meilleur étudiant : {$meilleur['prenom']} {$meilleur['nom']} ({$meilleur['moyenne']})</p>";
?>

<h2>Recherche par nom</h2>
<form method="get">
<label for="nom">Nom :</label>
<input type="text" id="nom" name="nom">
<button type="submit">Rechercher</button>
</form>

<?php
if (isset($_GET['nom'])) {
$nom = $_GET['nom'];
$etudiant = rechercherEtudiant($etudiants, $nom);
if ($etudiant !== null) {
afficherEtudiant($etudiant);
} else {
echo "<p>Étudiant introuvable.</p>";
}
}
?>

<h2>Filtrer par moyenne minimale</h2>
<form method="get">
<label for="min">Moyenne minimale :</label>
<input type="number" step="any" id="min" name="min">
<button type="submit">Filtrer</button>
</form>

<?php
if (isset($_GET['min'])) {
$min = $_GET['min'];
$filtres = filtrerParMoyenne($etudiants, $min);
if (count($filtres) > 0) {
afficherTableauEtudiants($filtres);
} else {
echo "<p>Aucun étudiant.</p>";
}
}
?>
</body>
</html>