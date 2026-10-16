<?php
if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['age']) && !empty($_POST['formation']))
{
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $formation = $_POST['formation']; 
    
    echo "nom = " . $nom . "<br>";
    echo "Prenom = " . $prenom . "<br>" . "age = " . $age . "<br>" . "formation = " . $formation . "<br>";
}
else {
    echo "Veuillez remplir le formulaire.<br><br>";
}
?>

<form method="POST">     
    <label>Nom :</label>     
    <input type="text" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>"> <br><br>
    
    <label>Prénom :</label>     
    <input type="text" name="prenom"value="<?= htmlspecialchars($prenom ?? '') ?>"> <br><br>
    
    <label>Âge :</label>     
    <input type="number" name="age" value="<?= htmlspecialchars($age ?? '') ?>"> <br><br>
    
    <label>Formation :</label>     
    <input type="text" name="formation"value="<?= htmlspecialchars($formation ?? '') ?>"> <br><br>
    
    <label>Moyenne :</label>     
    <input type="number" name="moyenne"value="<?= htmlspecialchars($moyenne ?? '') ?>"> <br><br>
    
    <button type="submit">Envoyer</button> 
</form>