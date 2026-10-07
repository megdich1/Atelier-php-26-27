<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carte d'identité numérique</title>
<style>
.carte {
border: 2px solid black;
width: 300px;
padding: 15px;
}
</style>
</head>
<body>
<h1>Carte d'identité numérique</h1>

<form method="get">
<label for="nom">Nom :</label>
<input type="text" name="nom" id="nom">
<br>
<label for="prenom">Prénom :</label>
<input type="text" name="prenom" id="prenom">
<br>
<label for="date">Date de naissance :</label>
<input type="date" name="date" id="date">
<br>
<label for="ville">Ville :</label>
<input type="text" name="ville" id="ville">
<br>
<label for="job">Profession :</label>
<input type="text" name="job" id="job">
<br>
<button type="submit">Valider</button>
</form>

<?php
if (isset($_GET['nom'])) {
$nom = $_GET['nom'];
$prenom = $_GET['prenom'];
$date = $_GET['date'];
$ville = $_GET['ville'];
$job = $_GET['job'];

echo "<div class='carte'>";
echo "<h2>Carte d'identité</h2>";
echo "<p>Nom : $nom</p>";
echo "<p>Prénom : $prenom</p>";
echo "<p>Date de naissance : $date</p>";
echo "<p>Ville : $ville</p>";
echo "<p>Profession : $job</p>";
echo "</div>";
}
?>
</body>
</html>