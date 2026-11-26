<?php 
    session_start();
    require '../config/connexion.php';
    require './auth_check.php';
    
    check_authorization(['Admin']); 

    $message = "";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['role']) || empty($_POST['id_centre'])) {
            $message = "All fields are required";
        }else{
            try {
                $check = "SELECT DISTINCT id_centre FROM centres_collecte WHERE id_centre = :id_centre";
                $stmt2 = $pdo->prepare($check);
                $stmt2->bindValue(':id_centre', $_POST['id_centre'], PDO::PARAM_INT);
                $stmt2->execute();
                $centreID = $stmt2->fetch(PDO::FETCH_ASSOC);

                $userExistance = "SELECT nom_utilisateur FROM utilisateurs WHERE nom_utilisateur = :nom_utilisateur";
                $stmt3 = $pdo->prepare($userExistance);
                $stmt3->bindValue(':nom_utilisateur', $_POST['username']);
                $stmt3->execute();
                $exists = $stmt3->fetch(PDO::FETCH_ASSOC);
                if ($centreID) {
                    if ($exists) {
                        $message = "Registration failed. Please try again.";

                        error_log("Attempted registration with existing username: $username"); // Avoid brute force attack
                    } else {
                        $sql = "INSERT INTO utilisateurs (nom_utilisateur, password, id_centre, role) VALUES (:username, :password, :id_centre, :role)";
                        $stmt = $pdo->prepare($sql);

                        $username = $_POST['username'];
                        $role = $_POST['role'];
                        $idCentreVal = (int)$centreID['id_centre'];

                        $stmt->bindParam(':username', $username);
                        $stmt->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
                        $stmt->bindValue(':id_centre', $idCentreVal, PDO::PARAM_INT);
                        $stmt->bindParam(':role', $role);

                        if ($stmt->execute()) {
                            header('Location: login.php');
                            exit;
                        } else {
                            $message = "Error creating user account";
                        }
                    }
                } else {
                    $message = "Center with this ID doesn't exist";
                }
            } catch (PDOException $e) {
                die('Error: ' . $e->getMessage());
            }
        }
        if (!empty($message)) {
            $_SESSION['error_message'] = $message;
            header('Location: inscrire.php');
            exit;
        }
    }

    if (isset($_SESSION['error_message'])){
        $message = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }
?>

<script>
    function messageAppearance(){
        const messageElement = document.getElementById("message");
        const message = messageElement.textContent.trim();
        if (message) {
            setTimeout(() => {
                messageElement.textContent = '';
            }, 5000);
        }
    }
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/animation.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sign up</title>
</head>
<body class="bg-slate-50 flex justify-center items-center mt-auto mb-auto h-[100vh]">
    <a onclick="goBack()" class="absolute left-5 top-2 text-sm hover:underline cursor-pointer"><span class="text-2xl"> &larr;</span> Back</a>
    <a href="logout.php" class="absolute right-5 top-4 text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500">Logout</a>

    <form method="POST" action="inscrire.php" class="border-2 p-5 m-2 w-full sm:w-1/3 bg-white text-center rounded-xl border-red-700">
        <h2 class="mb-6 font-bold text-red-700 text-2xl">Add User</h2>

        <input required type="text" name="username" id="username" class="border-gray-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Username"><br>
        
        <input required type="password" name="password" id="password" class="border-gray-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Password"><br>

        <div class="flex justify-around">
            <select required name="role" id="role" class="bg-red-100 border-red-200 border-2 px-3 w-2/5 placeholder:text-sm my-2 py-2 rounded-full text-sm">
                <option value="">Select your role</option>
                <?php 
                    $roles = array('Admin', 'Médecin', 'Secrétaire'); 
                    foreach ($roles as $role) {
                        echo '<option value="' . htmlspecialchars($role) . '">' . htmlspecialchars($role) . '</option>';
                    }
                ?>
            </select>

            <input required type="number" name="id_centre" placeholder="Center code" class="border-gray-200 border-2 px-3 w-1/2 placeholder:text-sm my-2 py-2 rounded-full text-sm">
        </div>

        <div class="text-red-500 mt-2 text-sm min-h-6" id='message'><?php echo htmlspecialchars($message); ?></div>

        <input type="submit" value="S'inscrire" onclick="messageAppearance()" class="border-2 border-red-600 hover:border-red-800 bg-red-500 hover:bg-red-700 p-2 w-full text-white font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full">

        <!-- <div class="flex justify-center items-center my-2 text-gray-500 gap-2">
            <hr class="border-[1px] flex-grow">
            <span class="text-sm">OU</span>
            <hr class="border-[1px] flex-grow">
        </div>

        <input type="button" value="Connecter" onclick="window.location.href='login.php';" class="border-2 border-gray-300 hover:bg-gray-300 p-2 w-full text-gray-600 font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full"> -->
    </form>
    <script>
        function goBack(){
            window.history.back()
        }
        messageAppearance();
    </script>
</body>
</html>
