<?php
    session_start();
    require "../config/connexion.php";
    require "../auth/auth_check.php";

    check_authorization(["Admin", "Secrétaire"]);

    $sql = "SELECT * FROM donneurs";
    if (!empty($_POST['rhesus']) || !empty($_POST['groupe_sanguin']) || !empty($_POST['ville'])){
        $sql .= ' WHERE ';
        $condition = [];
        if ($_POST['rhesus']){
            $condition[count($condition)] =  'rhesus = :rhesus';
        }
        if ($_POST['groupe_sanguin']){
            $condition[count($condition)] = 'groupe_sanguin = :groupe_sanguin';
        }
        if ($_POST['ville']){
            $condition[count($condition)] = 'ville = :ville';
        }

        $conditionString = join(' AND ', $condition);
        $sql .= $conditionString;
        
        $stmt = $pdo->prepare($sql);
        $length = count($condition);
        for ($i = 0; $i < $length; $i++){
            $explodedCondition = explode(" ", $condition[$i]);
            $stmt->bindParam($explodedCondition[2], $_POST[$explodedCondition[0]]);
        }
        $stmt->execute();
    }else{
        $stmt = $pdo->query($sql);
    }
    $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prevent warning message mta3 el form
    header("Location:",  "liste.php");
?>

<script>
    function goBack(){
        window.history.back();
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/animation.css">
    <link rel="stylesheet" href="../src/sidebar.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Liste des donneurs</title>
</head>
<body class="bg-slate-50 flex justify-end items-center mt-auto mb-auto h-[100vh] flex-col p-4">
    <a onclick="goBack()" class="absolute left-5 top-2 text-sm hover:underline cursor-pointer"><span class="text-2xl"> &larr;</span> Back</a>
    <a href="../auth/logout.php" class="absolute right-5 top-4 text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500">Logout</a>

    <form method="POST" class="border-2 p-5 m-2 w-full bg-white text-center rounded-xl border-red-400 flex h-1/12 justify-between sm:overflow-visible overflow-auto">
        <div class="flex">
            <select name="groupe_sanguin" id="groupe_sanguin" class="bg-red-100 border-red-200 border-2 px-3 placeholder:text-sm my-2 py-2 rounded-full text-sm mx-1">
                <option value="">Blood type</option>
                <?php
                        $grpSang = ["A", "B", "AB", "O"];
                        $rhesus = ['-', '+'];
                        
                        for($i = 0; $i < 4; $i++){
                            echo "<option value='" . htmlspecialchars($grpSang[$i]) . "'>" . htmlspecialchars($grpSang[$i]) ."</option>";
                        }
                    ?>
            </select>
            <select name="rhesus" id="rhesus" class="bg-red-100 border-red-200 border-2 px-3 placeholder:text-sm my-2 py-2 rounded-full text-sm mx-1">
                <option value="">Rhesus</option>
                <?php                
                    for($i = 0; $i < 2; $i++){
                        echo "<option value='" . htmlspecialchars($rhesus[$i]) . "'>" . htmlspecialchars($rhesus[$i]) ."</option>";
                    }
                ?>
            </select>
            <select name="ville" id="ville" class="bg-red-100 border-red-200 border-2 px-3 placeholder:text-sm my-2 py-2 rounded-full text-sm mx-1">
                <option value="">City</option>
                <?php
                    $villeStmt = $pdo->query("SELECT DISTINCT ville FROM centres_collecte");
                    $villes = $villeStmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($villes as $ville){
                        echo "<option value='" . htmlspecialchars($ville['ville']) . "'>" . htmlspecialchars($ville['ville']) . "</option>";
                    }
                ?>
            </select>
        </div>
        <input type="submit" value="Search" class="bg-red-100 border-red-200 hover:bg-red-300 hover:border-red-400 hover:text-white transition ease-in-out duration-500 cursor-pointer border-2 px-3 placeholder:text-sm my-2 py-2 rounded-full text-sm font-bold text-gray-700">
    </form>
    <div id="liste" class="border-2 p-5 m-2 w-full bg-white rounded-xl border-red-400 flex max-h-[70vh] flex-grow flex-col text-sm sm:overflow-visible overflow-auto">
        <div class="flex justify-around gap-10 sm:overflow-visible overflow-auto">
            <p class="w-1/6 text-center">ID</p>
            <p class="w-1/6 text-center">Name</p>
            <p class="w-1/6 text-center">CIN</p>
            <p class="w-1/6 text-center">Blood Type</p>
            <p class="w-1/6 text-center">City</p>
            <p class="w-1/6 text-center">History</p>
        </div><br>
        <hr class="mb-4 border-red-500">
        <div class="overflow-y-scroll overflow-x-hidden scrollbar">
            <?php
                foreach ($donors as $donor){
                    echo "<div class='flex w-full justify-between mb-4 gap-10 sm:overflow-visible overflow-auto'>
                        <p class='w-1/6 text-center'>". htmlspecialchars($donor['id_donneur'] ?? 'N/A') ."</p>
                        <p class='w-1/6 text-center'>" . htmlspecialchars($donor['nom'] ?? 'N/A') . "</p>
                        <p class='w-1/6 text-center'>" . htmlspecialchars($donor['cin'] ?? 'N/A') ." </p>
                        <p class='w-1/6 text-center'>" . htmlspecialchars($donor['groupe_sanguin'] ?? 'N/A') . htmlspecialchars($donor['rhesus']) . "</p>
                        <p class='w-1/6 text-center'>" . htmlspecialchars($donor['ville'] ?? 'N/A') . "</p>
                        
                        <div class='w-1/6 text-center'>
                            <a href='history.php?id={$donor['id_donneur']}' class='text-white bg-red-500 border-red-600 hover:bg-red-600 hover:scale-105 transition ease-in-out duration-500 cursor-pointer border-2 rounded-md text-sm font-bold px-3 py-1 inline-block'>Details</a>
                        </div>
                    </div>";
                }
            ?>
        </div>
    </div>
</body>
</html>