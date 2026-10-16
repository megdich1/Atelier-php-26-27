<?php 





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
