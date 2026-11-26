<?php
    session_start();

    require "../config/connexion.php";
    require "../auth/auth_check.php";

    check_authorization(['Secrétaire', 'Admin']);

    $message = "";
    $messageColor = 'text-red-500';

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $messageColor = $_SESSION['message_color'] ?? 'text-red-500';
        unset($_SESSION['message']);
        unset($_SESSION['message_color']);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        try{
            $sql = 'INSERT INTO dons (id_donneur, id_centre, date) VALUES (:id_donneur, :id_centre, :date)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_donneur', $_POST['id_donneur']);
            $stmt->bindParam(':id_centre', $_POST['id_centre']);
            $date = !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d');
            $stmt->bindParam(':date', $date);
            if ($stmt->execute()){
                $_SESSION['message'] = 'Donation was registered successfully!';
                $_SESSION['message_color'] = 'text-green-500';
            } else {
                $_SESSION['message'] = 'Something went wrong';
                $_SESSION['message_color'] = 'text-red-500';
            }
            
        } catch(PDOException $e){
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_color'] = 'text-red-500';
        }
        header('Location: ajout.php');
        exit();
    }   
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/animation.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register donation</title>
</head>

<body class="bg-slate-50 flex justify-center items-center mt-auto mb-auto h-[100vh]">
    <a onclick="goBack()" class="absolute left-5 top-2 text-sm hover:underline cursor-pointer"><span class="text-2xl"> &larr;</span> Back</a>
    <a href="../auth/logout.php" class="absolute right-5 top-4 text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500">Logout</a>

    <form method="POST" action="ajout.php" class="border-2 p-5 m-2 w-full sm:w-1/3 bg-white text-center rounded-xl border-red-700">
        <h2 class="mb-6 font-bold text-red-700 text-2xl">Register Donation</h2>
        <select required name="id_donneur" id="id_donneur" class="bg-red-100 border-red-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm">
            <?php
                $sql = "SELECT id_donneur, nom, cin FROM donneurs";
                $stmt = $pdo->query($sql);
                $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo '<option value="">Select Donor</option>';
                foreach($donors as $donor){
                    echo '<option value="'. htmlspecialchars($donor['id_donneur']) . '">' . htmlspecialchars($donor['id_donneur']) . ' - ' . htmlspecialchars($donor['nom']) . ' (' . htmlspecialchars($donor['cin']) . ')</option>';
                }
            ?>
        </select>
        <select required name="id_centre" id="id_centre" class="bg-red-100 border-red-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm">
            <?php
                $sql = "SELECT DISTINCT id_centre, nom_centre, ville FROM centres_collecte";
                $stmt = $pdo->query($sql);
                $centres = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo '<option value="">Center ID</option>';
                foreach($centres as $centre){
                    echo '<option value="'. htmlspecialchars($centre['id_centre']) . '">' . htmlspecialchars($centre['id_centre']) . ' - ' . htmlspecialchars($centre['nom_centre']) . ' (' . htmlspecialchars($centre['ville']) . ')</option>';
                }
            ?>
        </select><br>
        <input type="date" name="date" id="date" class="bg-red-100 border-red-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm">
        <span class="text-[10px] text-gray-600">Note: if you don't choose a date it will get the current date automatically</span>
        <div class="my-2 text-sm <?php echo $messageColor ?>" id='message'><?php echo htmlspecialchars($message); ?></div>

        <input type="submit" value="Register Donation" onclick="messageAppearance()" class="border-2 border-red-600 hover:border-red-800 bg-red-500 hover:bg-red-700 p-2 w-full text-white font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full">
    </form>

    <script>

        function goBack(){
            window.history.back();
        }

        function messageAppearance(){
            const messageElement = document.getElementById("message");
            const message = messageElement.textContent.trim();
            if (message) {
                setTimeout(() => {
                    messageElement.textContent = '';
                }, 5000);
            }
        }
        
        messageAppearance();
    </script>
</body>
</html>