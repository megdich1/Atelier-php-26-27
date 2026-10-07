<?php
$notes = [12, 15, 9, 14, 16];

function somme($notes)
{
$total = 0;
foreach ($notes as $note) {
$total += $note;
}
return $total;
}

function moyenne($notes)
{
return somme($notes) / count($notes);
}

function maximum($notes)
{
$max = $notes[0];
foreach ($notes as $note) {
if ($note > $max) {
$max = $note;
}
}
return $max;
}

function minimum($notes)
{
$min = $notes[0];
foreach ($notes as $note) {
if ($note < $min) {
$min = $note;
}
}
return $min;
}

function compterAdmis($notes)
{
$compteur = 0;
foreach ($notes as $note) {
if ($note >= 10) {
$compteur++;
}
}
return $compteur;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des notes</title>
</head>
<body>
<h1>Gestion des notes</h1>

<?php
echo "<p>Somme : " . somme($notes) . "</p>";
echo "<p>Moyenne : " . moyenne($notes) . "</p>";
echo "<p>Maximum : " . maximum($notes) . "</p>";
echo "<p>Minimum : " . minimum($notes) . "</p>";
echo "<p>Notes >= 10 : " . compterAdmis($notes) . "</p>";
?>
</body>
</html>