<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Premier tableau PHP</title>
</head>
<body>
<h1>Tableaux PHP</h1>

<?php
$etudiants = ["Ahmed", "Sami", "Nour", "Amine"];

echo "<h2>Activité 1</h2>";
echo "<p>" . $etudiants[0] . "</p>";
echo "<p>" . $etudiants[2] . "</p>";

echo "<h2>Activité 2 : for</h2>";
for ($i = 0; $i < count($etudiants); $i++) {
echo "<p>$etudiants[$i]</p>";
}

echo "<h2>Activité 3 : foreach</h2>";
foreach ($etudiants as $etudiant) {
echo "<p>$etudiant</p>";
}
?>
</body>
</html>