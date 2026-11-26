<?php 
    session_start();

    require "../config/connexion.php";
    require "../auth/auth_check.php";

    check_authorization(['Admin', 'Secrétaire']);

    $message = "";
    $messageColor = "text-red-500";

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $check = "SELECT cin FROM donneurs where cin = :cin";
        $checkStmt = $pdo->prepare($check);
        $checkStmt->bindParam(":cin", $_POST['cin']);
        $checkStmt->execute();

        $exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

        $reqVille = "SELECT ville from centres_collecte where id_centre = :id_centre";
        $villeStmt = $pdo->prepare($reqVille);
        $villeStmt->bindParam(":id_centre", $_POST['id_centre']);
        $villeStmt->execute();
        $ville = $villeStmt->fetch(PDO::FETCH_ASSOC);
        if (!$ville){
            $_SESSION['message'] = "Error: City doesnt exist";
            $_SESSION['messageType'] = "error";
        } else{

            if (!$exists){
                $sql = "INSERT INTO donneurs (nom, cin, groupe_sanguin, rhesus, ville) VALUES (:nom, :cin, :groupe_sanguin, :rhesus, :ville)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":nom", $_POST['name']);
                $stmt->bindParam(":cin", $_POST['cin']);
                $stmt->bindParam(":groupe_sanguin", $_POST['groupe_sanguin']);
                $stmt->bindParam(":rhesus", $_POST['rhesus']);
                $stmt->bindParam(":ville", $ville['ville']);


                if ($stmt->execute()){
                    $_SESSION['message'] = "Donor was added successfully!";
                    $messageColor = "text-green-500";
                } else {
                    $_SESSION['message'] = "Error: adding donor!";
                }
            } else {
                $_SESSION['message'] = "Error: Donor already exists!";
            }
        }
        header('Location: ajout.php');
        exit(); // ken naamlouch yet3adda ykamel yaamel unset mel session donc menech chenraw el message
    }

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
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
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Ajouter donneur</title>
    
    <div class="hidden text-green-500 text-red-500"></div>
</head>
<body class="bg-slate-50 flex justify-center items-center mt-auto mb-auto h-[100vh]">
    <a onclick="goBack()" class="absolute left-5 top-2 text-sm hover:underline cursor-pointer"><span class="text-2xl"> &larr;</span> Back</a>
    <a href="../auth/logout.php" class="absolute right-5 top-4 text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500">Logout</a>
    
    <form action="ajout.php" method="POST" class="border-2 p-5 m-2 w-full sm:w-1/3 bg-white text-center rounded-xl border-red-400">
        <h1 class="mb-6 font-bold text-red-600 text-xl">Add Blood Donor</h1>
        <input required type="text" name="cin" id="cin" class="border-red-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Enter the cin number"><br>
        <input required type="text" name="name" id="name" class="border-red-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Donor name">
        <input required type="text" name="id_centre" id="id_centre" class="border-red-200 border-2 px-3 w-full placeholder:text-sm my-2 py-2 rounded-full text-sm" placeholder="Center ID">
        <select required name="groupe_sanguin" id="groupe_sanguin" class="bg-red-100 border-red-200 border-2 px-3 w-2/5 placeholder:text-sm my-2 py-2 rounded-full text-sm">
            <option value="">Blood type</option>
            <?php
                    $grpSang = ["A", "B", "AB", "O"];
                    $rhesus = ['-', '+'];
                    
                    for($i = 0; $i < 4; $i++){
                        echo "<option value='" . $grpSang[$i] . "'>" . $grpSang[$i] ."</option>";
                    }
                ?>
        </select>
        <select required name="rhesus" id="rhesus" class="bg-red-100 border-red-200 border-2 px-3 w-2/5 placeholder:text-sm my-2 py-2 rounded-full text-sm">
            <option value="">Rhesus</option>
            <?php                
                for($i = 0; $i < 2; $i++){
                    echo "<option value='" . htmlspecialchars($rhesus[$i]) . "'>" . htmlspecialchars($rhesus[$i]) ."</option>";
                }
            ?>
        </select><br>
        
        <div id="message" class="mt-2 text-sm <?php echo $messageColor ?>"> <?php echo htmlspecialchars($message) ?> </div>
        
        <input type="submit" value="Add Donor" class="border-2 bg-red-500 border-red-200 hover:bg-red-600 text-white p-2 w-1/2 font-bold transition ease-in-out duration-500 hover:cursor-pointer rounded-full">
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