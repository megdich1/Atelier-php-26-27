<?php
    session_start();
    require '../config/connexion.php';
    if (isset($_SESSION['logged_in']) && $_SESSION["logged_in"] === true){
        header('Location: ../dashboard.php');
        exit;
    }
    $message = "";

    if (isset($_SESSION['error_message'])) {
        $message = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $username = $_POST['username'] ?? "";
        $password = $_POST['password'] ?? "";

        $sql = "select nom_utilisateur, password, role from utilisateurs where nom_utilisateur = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user){
            if (password_verify($password, $user['password'])){
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                header('Location: ../dashboard.php');
                exit;
            } else{
                $message = "username or password are incorrect!";
            }   
        } else{
            $message = "username or password are incorrect!";
        }
        
        if (!empty($message)){
            $_SESSION['error_message'] = $message;
            header('Location: login.php');
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/animation.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>
<body class="bg-slate-50 flex justify-center items-center mt-auto mb-auto h-[100vh]">
    <form method="POST" action="login.php" class="border-2 p-5 m-2 w-full sm:w-1/3 bg-white text-center rounded-xl border-red-700">
        <h2 class="mb-6 font-bold text-red-700 text-2xl">Login to your account</h2>
        <input required type="text" name="username" id="username" class="border-gray-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Username"><br>
        <input required type="password" name="password" id="password" class="border-gray-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Password"><br>
        <div class="text-red-500 mt-2 text-sm min-h-6" id='message'><?php echo htmlspecialchars($message); ?></div>

        <input type="submit" value="Connecter" onclick="messageAppearance()" class="border-2 border-red-600 hover:border-red-800 bg-red-500 hover:bg-red-700 p-2 w-full text-white font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full">
        <!-- <div class="flex justify-center items-center my-2 text-gray-500 gap-2">
            <hr class="border-[1px] flex-grow">
            <span class="text-sm">OU</span>
            <hr class="border-[1px] flex-grow">
        </div>
        <input type="button" value="S'inscrire" onclick="window.location.href='inscrire.php';" class="border-2 border-gray-300 hover:bg-gray-300 p-2 w-full text-gray-600 font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full" > -->
    </form>
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
        
        messageAppearance();
    </script>
</body>
</html>
