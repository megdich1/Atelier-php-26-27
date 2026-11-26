<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/connexion_bdd.php';
protegerPage();

$nom = '';
$prenom = '';
$age = '';
$formation = '';
$moyenne = '';
$erreurs = [];
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));
    $ageBrut = trim((string) ($_POST['age'] ?? ''));
    $formation = trim((string) ($_POST['formation'] ?? ''));
    $moyenneBrute = trim((string) ($_POST['moyenne'] ?? ''));

    if ($nom === '') {
        $erreurs[] = "Le nom est obligatoire.";
    }
    if ($prenom === '') {
        $erreurs[] = "Le prénom est obligatoire.";
    }
    if ($formation === '') {
        $erreurs[] = "La formation est obligatoire.";
    }

    $ageVal = filter_var($ageBrut, FILTER_VALIDATE_INT);
    if ($ageVal === false || $ageVal < 16 || $ageVal > 100) {
        $erreurs[] = "L'âge doit être un entier compris entre 16 et 100.";
    }

    $moyenneVal = filter_var($moyenneBrute, FILTER_VALIDATE_FLOAT);
    if ($moyenneVal === false || $moyenneVal < 0 || $moyenneVal > 20) {
        $erreurs[] = "La moyenne doit être comprise entre 0 et 20.";
    }

    $age = $ageBrut;
    $moyenne = $moyenneBrute;

    if (empty($erreurs)) {
        $sql = "INSERT INTO etudiants (nom, prenom, age, formation, moyenne)
                VALUES (:nom, :prenom, :age, :formation, :moyenne)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'age' => $ageVal,
            'formation' => $formation,
            'moyenne' => $moyenneVal
        ]);

        $succes = "Étudiant ajouté avec succès.";
        $nom = '';
        $prenom = '';
        $age = '';
        $formation = '';
        $moyenne = '';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
</head>
<body>
    <h1>Ajouter un étudiant</h1>
    <p>
        <a href="etudiants.php">Liste des étudiants</a> |
        <a href="dashboard.php">Tableau de bord</a> |
        <a href="deconnexion.php">Se déconnecter</a>
    </p>

    <?php foreach ($erreurs as $e): ?>
        <p style="color:red;"><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endforeach; ?>

    <?php if ($succes !== ''): ?>
        <p style="color:green;"><?= htmlspecialchars($succes, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="nom">Nom :</label>
        <input id="nom" type="text" name="nom" value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>" required><br><br>

        <label for="prenom">Prénom :</label>
        <input id="prenom" type="text" name="prenom" value="<?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?>" required><br><br>

        <label for="age">Âge :</label>
        <input id="age" type="number" name="age" min="16" max="100" value="<?= htmlspecialchars($age, ENT_QUOTES, 'UTF-8') ?>" required><br><br>

        <label for="formation">Formation :</label>
        <input id="formation" type="text" name="formation" value="<?= htmlspecialchars($formation, ENT_QUOTES, 'UTF-8') ?>" required><br><br>

        <label for="moyenne">Moyenne :</label>
        <input id="moyenne" type="number" name="moyenne" min="0" max="20" step="0.01" value="<?= htmlspecialchars($moyenne, ENT_QUOTES, 'UTF-8') ?>" required><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>