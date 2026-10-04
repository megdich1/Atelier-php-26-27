<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="get">
    <label for="a" > number 1 : </label>
    <input type="number" name="a" id="a">
    <label for="b" > number 2 : </label>
    <input type="number" name="b" id="b">
    <button type="submit">calculer</button>  
</form>
<?php
    $a=$_GET['a'];
    $b=$_GET['b'];
    $somme=$a+$b;
    $difference=$a + $b;
    $produit=$a * $b;
    echo "<p>Somme de $a + $b= $somme </p>";
    echo "<p>Difference de $a - $b= $difference </p>";
    echo "<p>Produit de $a + $b= $produit </p>";
    if ($b!=0){
        $quotient=$a / $b;
        $reste=$a % $b ;
        echo "<p>$a / $b = $quotient </p>";
        echo "<p> $a % $b = $reste</p>";
    }
    else{
        echo "div/ impo ";
    }
 ?>
</body>
</html>

