<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="get">
        <label for="note1">note1:</label>
        <input type="number" id="note1"  name="note1">
        <br> 
        <label for="note2">note2:</label>
        <input type="number" id="note2"  name="note2">
        <br>
        <label for="note3">note3:</label>
        <input type="number" id="note3"  name="note3">
        <br>
        <button type="submit">calculer</button>
    </form>
    <?php 
    $note1=$_GET['note1'];
    $note2=$_GET['note2'];
    $note3=$_GET['note3'];
    $moy=($note1+$note2+$note3)/3;
    echo "<p>La moy est {$moy}</p>";
    if ($moy<10){
        echo "insuffisant";
    }elseif ($moy>=10 && $moy<12){
        echo "passable";
    }elseif ($moy>=12 && $moy<14){
        echo "assez bien";
    }elseif ($moy>=14 && $moy<16){
        echo "bien";
    }else {
        echo "tres bien";
    }
     ?>
</body>
</html>