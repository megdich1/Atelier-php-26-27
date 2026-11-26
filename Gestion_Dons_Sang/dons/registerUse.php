<?php
    session_start();

    require "../config/connexion.php";
    require "../auth/auth_check.php";

    check_authorization(['Admin']);

    $message = "";
    $messageColor = '';
    $redirect = false;
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hospital'])){

        $resgistrationDate = !empty($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        try{
            $sql = 'INSERT INTO transfusions (id_don, hopital_recepteur, date_transfusion) VALUES (:id_don, :hopital_recepteur, :date_transfusion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':hopital_recepteur', $_GET['hospital']);
            $stmt->bindParam(':date_transfusion', $resgistrationDate);
            $stmt->bindParam(':id_don', $_GET['id']);
            $stmt->execute();

            $sqlUpdate = 'UPDATE dons SET status="UTILISÉ" WHERE id_don = :id';
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':id', $_GET['id']);
            $stmtUpdate->execute();
            $message = "Transfusion registered successfully!";
            $messageColor = 'text-green-500';
            $redirect=true;
        } catch(PDOException $e){
            $messageColor = 'text-red-500';
            $message = 'Error: ' . $e->getMessage();
        }
    }
    
?>

<script>
    function goBack(){
        window.history.back();
    }

    <?php if ($redirect): ?>
        setTimeout(function() {
            window.location.href = 'transfusion.php';
        }, 3000);
    <?php endif; ?>
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/animation.css">
    <link rel="stylesheet" href="../src/sidebar.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Consultation</title>
</head>
<body class="bg-slate-50 flex justify-center items-center mt-auto mb-auto h-[100vh] flex-col p-4">
    <a onclick="goBack()" class="absolute left-5 top-2 text-sm hover:underline cursor-pointer"><span class="text-2xl"> &larr;</span> Back</a>
    <a href="../auth/logout.php" class="absolute right-5 top-4 text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500">Logout</a>

    <form class='border-2 p-5 m-2 w-full sm:w-1/3 bg-white text-center rounded-xl border-red-700 text-sm' method="GET" action="registerUse.php">
        <h2 class='mb-6 font-bold text-red-700 text-2xl'>Consult Donation</h2>
        <input required type="text" name="hospital" id="hospital" class="border-gray-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Hospital Name"><br>
        <input type="date" name="date" id="date" class="border-gray-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" value="<?php echo date_format(new DateTime(),'dd/mm/yyyy') ?>"><br>
        <span class="text-[10px] text-gray-600">Note: if you don't choose a date it will get the current date automatically</span>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
        <div class="my-2 text-sm <?php echo $messageColor ?>" id='message'><?php echo htmlspecialchars($message); ?></div>
        <div class="flex justify-around mt-6 space-x-4">
            <button onclick="goBack()" class='border-2 bg-red-400 border-red-200 hover:bg-red-600 hover:scale-105 text-white p-2 w-1/2 font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full'>
                Cancel
            </button>
            <input type='submit' class='border-2 bg-white text-red-400 hover:text-red-600 hover:border-red-600 border-red-200 hover:scale-105 p-2 w-1/2 font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full' value="Register">
        </div>
    </form>
</body>
</html>