<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistiques de la classe</title>
<style>
.carte {
border: 2px solid black;
width: 300px;
padding: 15px;
}
</style>
</head>
<body>
<h1>Statistiques de la classe</h1>

<?php
$etudiants = [
    ["nom" => "Khediri",   "prenom" => "Ahmed",   "age" => 20, "formation" => "Informatique", "moyenne" => 14.5],
    ["nom" => "Ali",       "prenom" => "Sami",    "age" => 21, "formation" => "Informatique", "moyenne" => 11.5],
    ["nom" => "Ben Salah", "prenom" => "Nour",    "age" => 19, "formation" => "Informatique", "moyenne" => 16],
    ["nom" => "Trabelsi",  "prenom" => "Amine",   "age" => 22, "formation" => "Informatique", "moyenne" => 8.5],
    ["nom" => "Mansour",   "prenom" => "Yasmine", "age" => 20, "formation" => "Informatique", "moyenne" => 13],
    ["nom" => "Gharbi",    "prenom" => "Omar",    "age" => 21, "formation" => "Informatique", "moyenne" => 9.75],
    ["nom" => "Jlassi",    "prenom" => "Salma",   "age" => 19, "formation" => "Informatique", "moyenne" => 17.25],
    ["nom" => "Hamdi",     "prenom" => "Karim",   "age" => 23, "formation" => "Informatique", "moyenne" => 10],
    ["nom" => "Bouazizi",  "prenom" => "Lina",    "age" => 20, "formation" => "Informatique", "moyenne" => 14],
    ["nom" => "Sassi",     "prenom" => "Walid",   "age" => 22, "formation" => "Informatique", "moyenne" => 7],
];

function meilleureMoyenne($liste) {
    $max = $liste[0]["moyenne"];
    foreach ($liste as $e) {
        if ($e["moyenne"] > $max) {
            $max = $e["moyenne"];
        }
    }
    return $max;
}

function plusFaibleMoyenne($liste) {
    $min = $liste[0]["moyenne"];
    foreach ($liste as $e) {
        if ($e["moyenne"] < $min) {
            $min = $e["moyenne"];
        }
    }
    return $min;
}

function compterMoyenneSup14($liste) {
    $c = 0;
    foreach ($liste as $e) {
        if ($e["moyenne"] >= 14) {
            $c++;
        }
    }
    return $c;
}

function compterAdmis($liste) {
    $c = 0;
    foreach ($liste as $e) {
        if ($e["moyenne"] >= 10) {
            $c++;
        }
    }
    return $c;
}

function pourcentageAdmis($liste) {
    return compterAdmis($liste) * 100 / count($liste);
}

echo "<div class='carte'>";
echo "<h2>Statistiques</h2>";
echo "<p>Nombre d'étudiants : " . count($etudiants) . "</p>";
echo "<p>Meilleure moyenne : " . meilleureMoyenne($etudiants) . "</p>";
echo "<p>Plus faible moyenne : " . plusFaibleMoyenne($etudiants) . "</p>";
echo "<p>Moyenne >= 14 : " . compterMoyenneSup14($etudiants) . " étudiant(s)</p>";
echo "<p>Pourcentage d'admis : " . pourcentageAdmis($etudiants) . " %</p>";
echo "</div>";
?>
</body>
</html>