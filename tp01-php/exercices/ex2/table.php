<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <form method="get">
    <label for="a">Number :</label>
    <input type="number" id="a" name="a">
    <button type="submit">show:</button>
   </form> 
   <?php 
   $a=$_GET['a'];
   echo "<table border='1'>";
   for ($i = 1; $i <= 10; $i++) {
       $resultat = $a * $i;
       echo "<tr><td>{$a} x {$i}</td><td>{$resultat}</td></tr>";
   }
   echo "</table>";
   ?>


</body>
</html>