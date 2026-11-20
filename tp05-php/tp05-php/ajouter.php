<form method="POST">
 <label for="nom">Nom :</label>
 <input id="nom" type="text" name="nom" required>
 <label for="prenom">Prénom :</label>
 <input id="prenom" type="text" name="prenom" required>
 <label for="age">Âge :</label>
 <input id="age" type="number" name="age" min="16" max="100" required>
 <label for="formation">Formation :</label>
 <input id="formation" type="text" name="formation" required>
 <label for="moyenne">Moyenne :</label>
 <input id="moyenne" type="number" name="moyenne"
 min="0" max="20" step="0.01" required>
 <button type="submit">Ajouter</button>
</form>
<?php
require_once  'connexion.php';
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$age=$_POST['age'];
$formation=$_POST['formation'];
$moyenne=$_POST['moyenne'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$sql = "INSERT INTO etudiants
 (nom, prenom, age, formation, moyenne)
 VALUES
 (:nom, :prenom, :age, :formation, :moyenne)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
 'nom' => $nom,
 'prenom' => $prenom,
 'age' => $age,
 'formation' => $formation,
 'moyenne' => $moyenne
 ]);
 header('Location: liste.php');
 exit;
 };
