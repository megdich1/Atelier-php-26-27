<form method="GET">
    <label for="nom">Nom à rechercher :</label>
    <input id="nom" type="text" name="nom">
    <button type="submit">Rechercher</button>
</form>

<?php
require_once 'connexion.php';

if (isset($_GET['nom'])) {
    $nomRecherche = $_GET['nom'];

    $sql = "SELECT id, nom, prenom, age, formation, moyenne
            FROM etudiants
            WHERE nom LIKE :nom
            ORDER BY nom, prenom";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nom' => '%' . $nomRecherche . '%']);
    $etudiants = $stmt->fetchAll();
?>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th><th>Nom</th><th>Prénom</th>
            <th>Âge</th><th>Formation</th><th>Moyenne</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($etudiants as $e): ?>
        <tr>
            <td><?= $e['id'] ?></td>
            <td><?= $e['nom'] ?></td>
            <td><?= $e['prenom'] ?></td>
            <td><?= $e['age'] ?></td>
            <td><?= $e['formation'] ?></td>
            <td><?= $e['moyenne'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php } ?>