<?php
require 'connexion.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === null) {
    die("Identifiant invalide.");
}

$sql = "SELECT id, nom, prenom, age, formation, moyenne
        FROM etudiants
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$etudiant) {
    die("Aucun étudiant trouvé avec cet identifiant.");
}
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$age = $_POST['age'];
$formation = $_POST['formation'];
$moyenne  = $_POST['moyenne'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE etudiants
        SET nom = :nom,prenom = :prenom,age = :age,formation = :formation,moyenne = :moyenne
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom'       => $nom,
            'prenom'    => $prenom,
            'age'       => (int) $age,
            'formation' => $formation,
            'moyenne'   => (float) $moyenne,
            'id'        => $id
        ]);

        header('Location: liste.php');
        exit;}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un étudiant</title>
</head>
<body>
    <h1>Modifier l'étudiant n° <?= (int) $etudiant['id'] ?></h1>

   
    <form method="POST">
        <p>
            <label for="nom">Nom :</label>
            <input id="nom" type="text" name="nom"
                   value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
        </p>
        <p>
            <label for="prenom">Prénom :</label>
            <input id="prenom" type="text" name="prenom"
                   value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
        </p>
        <p>
            <label for="age">Âge :</label>
            <input id="age" type="number" name="age" min="16" max="100"
                   value="<?= htmlspecialchars($etudiant['age']) ?>" required>
        </p>
        <p>
            <label for="formation">Formation :</label>
            <input id="formation" type="text" name="formation"
                   value="<?= htmlspecialchars($etudiant['formation']) ?>" required>
        </p>
        <p>
            <label for="moyenne">Moyenne :</label>
            <input id="moyenne" type="number" name="moyenne" min="0" max="20" step="0.01"
                   value="<?= htmlspecialchars($etudiant['moyenne']) ?>" required>
        </p>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>