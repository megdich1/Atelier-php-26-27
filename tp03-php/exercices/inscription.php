<?php 





$error = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($_POST['nom'])) {     
        $error[] = "Le nom est obligatoire."; 
    } 
    if (empty($_POST['prenom'])) {     
        $error[] = "Le prénom est obligatoire."; 
    } 
    if (empty($_POST['age'])) {     
        $error[] = "L'âge est obligatoire."; 
    } 
    if (empty($_POST['formation'])) {     
        $error[] = "La formation est obligatoire."; 
    } 
    if (empty($_POST['moyenne'])) {     
        $error[] = "La moyenne est obligatoire."; 
    } 

    if($_POST['age']<16 || $_POST['age'] >40){
        $error[]="age must be >=16 or <=40";
    }
      if($_POST['moyenne']<0 || $_POST['moyenne'] >20){
        $error[]="moyenne must be enter 0 et 20";
    }

    if (count($error) === 0) { 
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $age = htmlspecialchars($_POST['age']);
        $formation = htmlspecialchars($_POST['formation']);
        $moyenne = htmlspecialchars($_POST['moyenne']);
              

        echo "Nom : " . $nom . "<br>";
        echo "Prénom : " . $prenom . "<br>";
        echo "Âge : " . $age . "<br>";
        echo "Formation : " . $formation . "<br>";
        echo "Moyenne : " . $moyenne . "/20". "<br>";
        echo "Resultat : " . resultat($moyenne) . "<br><br>";
    } else {     
        foreach ($error as $e) {         
            echo "<p>$e</p>";
        } 
    } 
}
function resultat($moyenne)
{
return $moyenne >= 10 ? "Admis" : "Ajourné";
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
