<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des notes</title>
<style>
.resultat {
border: 2px solid black;
width: 300px;
padding: 15px;
}
</style>
</head>
<body>
<h1>Gestion des notes</h1>

<?php
$notes = [12, 15, 9, 14, 16];

function somme($notes) {
    $s = 0;
    foreach ($notes as $n) {
        $s += $n;
    }
    return $s;
}

function moyenne($notes) {
    return somme($notes) / count($notes);
}

function maximum($notes) {
    $max = $notes[0];
    foreach ($notes as $n) {
        if ($n > $max) {
            $max = $n;
        }
    }
    return $max;
}

function minimum($notes) {
    $min = $notes[0];
    foreach ($notes as $n) {
        if ($n < $min) {
            $min = $n;
        }
    }
    return $min;
}

function compterAdmis($notes) {
    $c = 0;
    foreach ($notes as $n) {
        if ($n >= 10) {
            $c++;
        }
    }
    return $c;
}

echo "<div class='resultat'>";
echo "<h2>Résultats</h2>";
echo "<p>Somme : " . somme($notes) . "</p>";
echo "<p>Moyenne : " . moyenne($notes) . "</p>";
echo "<p>Maximum : " . maximum($notes) . "</p>";
echo "<p>Minimum : " . minimum($notes) . "</p>";
echo "<p>Notes >= 10 : " . compterAdmis($notes) . "</p>";
echo "</div>";
?>
</body>
</html>