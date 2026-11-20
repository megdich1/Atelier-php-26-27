<?php
require_once  'connexion.php';
$sql = "SELECT id, nom, prenom, age, formation, moyenne
 FROM etudiants
 ORDER BY id";
$stmt = $pdo->query($sql);
$etudiants = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
 <meta charset="UTF-8">
 <title>Liste des étudiants</title>
</head>
<body>
 <h1>Liste des étudiants</h1>
 <table border="1" cellpadding="8">
 <thead>
 <tr>
 <th>ID</th>
 <th>Nom</th>
 <th>Prénom</th>
 <th>Âge</th>
 <th>Formation</th>
 <th>Moyenne</th>
 <th colspan="2">Actions</th>
 </tr>
 </thead>
 <tbody>
 <?php foreach ($etudiants as $etudiant): ?>
 <tr>
 <td><?= (int) $etudiant['id'] ?></td>
 <td><?= htmlspecialchars($etudiant['nom']) ?></td>
 <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
 <td><?= (int) $etudiant['age'] ?></td>
 <td><?= htmlspecialchars($etudiant['formation']) ?></td>
 <td><?= htmlspecialchars((string) $etudiant['moyenne']) ?></td>
 <td><a href="modifier.php?id=<?= (int) $etudiant['id'] ?>">Modifier</a></td>
 <td><a href="supprimer.php?id=<?= (int) $etudiant['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet étudiant ?');">Supprimer</a></td>

 </tr>
 <?php endforeach; ?>
 </tbody>
 </table>
 <a href="ajouter.php">Ajouter un étudiant</a>
</body>
</html>