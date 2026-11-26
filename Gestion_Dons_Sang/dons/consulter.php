<?php
    session_start();

    require "../config/connexion.php";
    require "../auth/auth_check.php";

    check_authorization(['Médecin', 'Admin']);

    $message = "";
    $messageColor = '';
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $sql = "SELECT dn.*, d.* FROM donneurs dn NATURAL JOIN dons d WHERE d.id_don = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        $donation =  $stmt->fetch();

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            $id_don = $_GET['id'];
            
            $insert_sql = 'INSERT INTO tests_don (id_don, est_conforme) VALUES (:id_don, :est_conforme)';
            $insert_stmt = $pdo->prepare($insert_sql);
            $insert_stmt->bindParam(':id_don', $id_don);
            
            if ($action === 'accept') {
                $est_conforme = 1;
                $messageColor = 'text-green-500';
                $insert_stmt->bindParam(':est_conforme', $est_conforme);
                $update_sql = "UPDATE dons SET status = 'VALIDE' WHERE id_don = :id";
                $message = "Donation accepted and added to stock successfully!";
            } elseif ($action === 'reject') {
                $est_conforme = 0;
                $messageColor = 'text-red-500';
                $insert_stmt->bindParam(':est_conforme', $est_conforme);
                $update_sql = "UPDATE dons SET status = 'REJETÉ' WHERE id_don = :id";
                $message = "Donation rejected successfully!";
            }
            
            
            $insert_stmt->execute();
            
            if (isset($update_sql)) {
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->bindParam(':id', $id_don);
                if ($update_stmt->execute()) {
                    // Refresh donation data
                    $stmt->execute();
                    $donation = $stmt->fetch();
                    $redirect=true;
                }
            }
        }
    }

    $statusColor = ($donation['status'] == 'EN STOCK') ? 'text-green-500' : (($donation['status'] == 'REJETÉ') ? 'text-red-500' : 'text-yellow-500');
    
?>

<script>
    function goBack(){
        window.history.back();
    }

    function confirmAction(action) {
        if (action === 'accept') {
            return confirm('Are you sure you want to accept this donation and add it to stock?');
        } else if (action === 'reject') {
            return confirm('Are you sure you want to reject this donation?');
        }
        return true;
    }

    <?php if ($redirect): ?>
        setTimeout(function() {
            window.location.href = 'validate.php';
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

    <form class='border-2 p-5 m-2 w-1/3 bg-white text-center rounded-xl border-red-700 text-sm' method="GET">
        <?php
            echo "<h2 class='mb-6 font-bold text-red-700 text-2xl'>Consult Donation</h2>
            <div class='flex justify-around'>
                <p><span class='font-semibold'>Don ID</span><br> " . htmlspecialchars($donation['id_don'] ?? 'N/A') . "</p>
                <p><span class='font-semibold'>Blood Type</span><br> " . htmlspecialchars($donation['groupe_sanguin']) . htmlspecialchars($donation['rhesus']) . "</p>
            </div><br>
            <p><span class='font-semibold'>Donor Name</span><br> " . htmlspecialchars($donation['nom'] ?? 'N/A') . "</p><br>
            <p><span class='font-semibold'>CIN</span><br> " . htmlspecialchars($donation['cin'] ?? 'N/A') . "</p><br>
            <p class='font-bold $statusColor'><span class='font-semibold text-black'>Status</span><br> " . htmlspecialchars($donation['status'] ?? 'N/A') . "</p>
            <div id='message' class='mt-2 text-sm $messageColor'>" . htmlspecialchars($message) . "</div>";

        ?>
        
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
        
        <div class="flex justify-around mt-6 space-x-4">
            <button type='submit' name='action' value='reject' onclick="return confirmAction('reject')" class='border-2 bg-red-400 border-red-200 hover:bg-red-600 hover:scale-105 text-white p-2 w-1/2 font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full'>
                Reject
            </button>
            <button type='submit' name='action' value='accept' onclick="return confirmAction('accept')" class='border-2 bg-white text-red-400 hover:text-red-600 hover:border-red-600 border-red-200 hover:scale-105 p-2 w-1/2 font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full'>
                Accept
            </button>
        </div>
    </form>
</body>
</html>