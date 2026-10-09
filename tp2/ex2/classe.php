<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion d'une classe</title>
<style>
table {
border-collapse: collapse;
}
th, td {
border: 1px solid black;
padding: 6px;
}
.carte {
border: 2px solid black;
width: 300px;
padding: 15px;
}
</style>
</head>
<body>
<h1>Gestion d'une classe</h1>

<form method="get">
<label for="nom">Rechercher un nom :</label>
<input type="text" name="nom" id="nom">
<br>
<label for="min">Moyenne minimale :</label>
<input type="number" step="0.01" name="min" id="min">
<br>
<button type="submit">Valider</button>
</form>

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

// 1. Afficher tous les étudiants
function afficherEtudiants($liste) {
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Âge</th><th>Formation</th><th>Moyenne</th></tr>";
    foreach ($liste as $e) {
        echo "<tr>";
        echo "<td>{$e['nom']}</td>";
        echo "<td>{$e['prenom']}</td>";
        echo "<td>{$e['age']}</td>";
        echo "<td>{$e['formation']}</td>";
        echo "<td>{$e['moyenne']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// 2. Calculer la moyenne de la classe
function moyenneClasse($liste) {
    $somme = 0;
    foreach ($liste as $e) {
        $somme += $e["moyenne"];
    }
    return $somme / count($liste);
}

// 3. Compter les admis
function compterAdmis($liste) {
    $c = 0;
    foreach ($liste as $e) {
        if ($e["moyenne"] >= 10) {
            $c++;
        }
    }
    return $c;
}

// 4. Rechercher un étudiant
function rechercherEtudiant($liste, $nom) {
    foreach ($liste as $e) {
        if ($e["nom"] === $nom) {
            return $e;
        }
    }
    return null;
}

// 5. Filtrer selon une moyenne minimale
function filtrerParMoyenne($liste, $min) {
    $resultat = [];
    foreach ($liste as $e) {
        if ($e["moyenne"] >= $min) {
            $resultat[] = $e;
        }
    }
    return $resultat;
}

// ----- Affichage -----

echo "<h2>Liste des étudiants</h2>";
afficherEtudiants($etudiants);

echo "<h2>Informations</h2>";
echo "<div class='carte'>";
echo "<p>Moyenne de la classe : " . round(moyenneClasse($etudiants), 2) . "</p>";
echo "<p>Nombre d'admis : " . compterAdmis($etudiants) . "</p>";
echo "</div>";

// Recherche par nom
if (isset($_GET['nom']) && $_GET['nom'] !== "") {
    $nom = $_GET['nom'];
    $trouve = rechercherEtudiant($etudiants, $nom);

    echo "<h2>Résultat de la recherche</h2>";
    if ($trouve !== null) {
        afficherEtudiants([$trouve]);
    } else {
        echo "<p>Étudiant introuvable.</p>";
    }
}

// Filtre par moyenne minimale
if (isset($_GET['min']) && $_GET['min'] !== "") {
    $min = $_GET['min'];

    echo "<h2>Étudiants avec moyenne >= $min</h2>";
    afficherEtudiants(filtrerParMoyenne($etudiants, $min));
}
?>
</body>
</html>