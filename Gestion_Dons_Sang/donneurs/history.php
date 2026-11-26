<?php
    session_start();

    require "../config/connexion.php";
    require "../auth/auth_check.php";

    check_authorization(["Admin", "Secrétaire"]);

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $sql = "SELECT dn.*, d.* FROM donneurs dn LEFT JOIN dons d ON dn.id_donneur = d.id_donneur WHERE dn.id_donneur = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        $donations =  $stmt->fetchAll();
    }
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
    <title>History</title>
</head>
<body class="bg-slate-50 flex justify-end items-center mt-auto mb-auto h-[100vh] flex-col p-4">
    <a onclick="goBack()" class="absolute left-5 top-2 text-sm hover:underline cursor-pointer"><span class="text-2xl"> &larr;</span> Back</a>
    <a href="../auth/logout.php" class="absolute right-5 top-4 text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500">Logout</a>
    
    <div class="border-2 p-5 m-2 w-full bg-white text-center rounded-xl border-red-400 flex h-1/12 gap-10 text-sm sm:overflow-visible overflow-auto">
        <?php
            echo "<p>Donor ID = " . htmlspecialchars($_GET['id'] ?? 'N/A') . "</p>
            <p>Name = " . htmlspecialchars($donations[0]['nom'] ?? 'N/A') . "</p>
            <p>CIN =" . htmlspecialchars($donations[0]['cin'] ?? 'N/A') . "</p>
            <p>Blood type = " . htmlspecialchars($donations[0]['groupe_sanguin']) . htmlspecialchars($donations[0]['rhesus']) . "</p>
            <p>City = " . htmlspecialchars($donations[0]['ville'] ?? 'N/A') . "</p>";
        ?>
    </div>
    <div id="liste" class="border-2 p-5 m-2 w-full bg-white rounded-xl border-red-400 flex max-h-[75vh] flex-grow flex-col text-sm">
        <div class="flex justify-around">
            <p class="w-1/4 text-center">Donation ID</p>
            <p class="w-1/4 text-center">Center ID</p>
            <p class="w-1/4 text-center">Status</p>
            <p class="w-1/4 text-center">date</p>
        </div><br>
        <hr class="mb-4 border-red-500">
        <div class="overflow-y-scroll overflow-x-hidden scrollbar">
            <?php
            foreach ($donations as $donation){
                echo "<div class='flex w-full justify-between mb-4'>
                    <p class='w-1/4 text-center'>" . htmlspecialchars($donation['id_don'] ?? 'N/A') . "</p>
                    <p class='w-1/4 text-center'>" . htmlspecialchars($donation['id_centre'] ?? 'N/A') . "</p>
                    <p class='w-1/4 text-center'>" . htmlspecialchars($donation['status'] ?? 'N/A') . "</p>
                    <p class='w-1/4 text-center'> " . htmlspecialchars($donation['date'] ?? 'N/A') . "</p>
                </div>";
            }
            ?>
        </div>
</body>
</html>