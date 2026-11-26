<?php
    session_start();
    require "config/connexion.php";
    require "auth/auth_check.php";

    check_authorization(['Médecin', 'Admin', 'Secrétaire']);

    $pages_accessibles = [
        'donneurs/liste.php' => ['Admin', 'Secrétaire'],
        'donneurs/ajout.php' => ['Admin', 'Secrétaire'],
        'dons/validate.php' => ['Médecin', 'Admin'],
        'dons/ajout.php' => ['Secrétaire', 'Admin'],
        'dons/transfusion.php' => ['Admin'],
        'auth/inscrire.php' => ['Admin']
    ];

    function est_page_accessible($page, $role_utilisateur, $pages_accessibles) {
        return isset($pages_accessibles[$page]) && in_array($role_utilisateur, $pages_accessibles[$page]);
    }

    $role_utilisateur = $_SESSION['role'] ?? 'Admin';

    $stats = [];
    try {
        $sql_donneurs = "SELECT COUNT(*) as total FROM donneurs";
        $stmt = $pdo->query($sql_donneurs);
        $stats['total_donneurs'] = $stmt->fetch()['total'];

        $sql_dons_valides = "SELECT COUNT(*) as total FROM dons WHERE status = 'VALIDE' OR status = 'EN STOCK'";
        $stmt = $pdo->query($sql_dons_valides);
        $stats['total_dons_valides'] = $stmt->fetch()['total'];

        $sql_centres = "SELECT COUNT(DISTINCT hopital_recepteur) as total FROM transfusions";
        $stmt = $pdo->query($sql_centres);
        $stats['total_centres'] = $stmt->fetch()['total'];

    } catch (PDOException $e) {
        die("Erreur lors du chargement des statistiques: " . $e->getMessage());
    }

    $stock_par_groupe = [];
    try {
        $sql_stock = "SELECT 
                        groupe_sanguin, 
                        rhesus,
                        COUNT(*) as quantite,
                        CONCAT(groupe_sanguin, rhesus) as groupe_complet
                    FROM dons NATURAL JOIN donneurs
                    WHERE status = 'VALIDE' OR status = 'EN STOCK'
                    GROUP BY groupe_sanguin, rhesus
                    ORDER BY groupe_sanguin, rhesus";

        $stmt = $pdo->query($sql_stock);
        $stock_par_groupe = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Erreur lors du chargement du stock: " . $e->getMessage());
    }

    $alertes_besoins = [];
    try {
        $sql_alertes = "SELECT * FROM besoins WHERE niveau_alerte IN ('URGENT', 'CRITIQUE') ORDER BY niveau_alerte DESC";
        $stmt = $pdo->query($sql_alertes);
        $alertes_besoins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $alertes_besoins = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/animation.css">
    <link rel="stylesheet" href="../src/sidebar.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboard</title>
</head>
<body class="bg-slate-50 flex items-center mt-auto mb-auto h-[100vh] flex-col">
    
    <nav class="sticky top-0 left-0 right-0 bg-white border-b-2 border-red-400 py-3 px-6 shadow-sm hidden md:block w-full">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-red-500 rounded-full"></div>
                <span class="font-bold text-red-600">BloodManager</span>
            </div>

            <div class="flex space-x-6">
                <?php
                    $nav_links = '';
                    $links = [];
                    if (est_page_accessible('donneurs/ajout.php', $role_utilisateur, $pages_accessibles)) {
                        $nav_links .= '<a href="donneurs/ajout.php" class="text-gray-600 hover:text-red-600 transition duration-300">Add Donor</a>';
                        $links[] .= '<a href="donneurs/ajout.php" class="text-gray-600 hover:text-red-600 transition duration-300">Add Donor</a>';
                    }

                    if (est_page_accessible('dons/ajout.php', $role_utilisateur, $pages_accessibles)) {
                        $nav_links .= '<a href="dons/ajout.php" class="text-gray-600 hover:text-red-600 transition duration-300">Add Donation</a>';
                        $links[] .= '<a href="dons/ajout.php" class="text-gray-600 hover:text-red-600 transition duration-300">Add Donation</a>';
                    }

                    if (est_page_accessible('donneurs/liste.php', $role_utilisateur, $pages_accessibles)) {
                        $nav_links .= '<a href="donneurs/liste.php" class="text-gray-600 hover:text-red-600 transition duration-300">Donors List</a>';
                        $links[] .= '<a href="donneurs/liste.php" class="text-gray-600 hover:text-red-600 transition duration-300">Donors List</a>';
                    }

                    if (est_page_accessible('dons/validate.php', $role_utilisateur, $pages_accessibles)) {
                        $nav_links .= '<a href="dons/validate.php" class="text-gray-600 hover:text-red-600 transition duration-300">Validate Donations</a>';
                        $links[] .= '<a href="dons/validate.php" class="text-gray-600 hover:text-red-600 transition duration-300">Validate Donations</a>';
                    }

                    if (est_page_accessible('dons/transfusion.php', $role_utilisateur, $pages_accessibles)) {
                        $nav_links .= '<a href="dons/transfusion.php" class="text-gray-600 hover:text-red-600 transition duration-300">Transfusions</a>';
                        $links[] .= '<a href="dons/transfusion.php" class="text-gray-600 hover:text-red-600 transition duration-300">Transfusions</a>';
                    }

                    if (est_page_accessible('dons/transfusion.php', $role_utilisateur, $pages_accessibles)) {
                        $nav_links .= '<a href="auth/inscrire.php" class="text-gray-600 hover:text-red-600 transition duration-300">Add user</a>';
                        $links[] .= '<a href="auth/inscrire.php" class="text-gray-600 hover:text-red-600 transition duration-300">Add user</a>';
                    }

                    echo $nav_links;
                ?>
            </div>

            <a href="../auth/logout.php" class="text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500">Logout</a>
        </div>
    </nav>
    <nav class="md:hidden block border-b-2 sticky z-10 top-0 left-0 w-full border-b-red-400 bg-slate-50">
        <div class='overflow-auto flex justify-around items-center'>
            <?php
                foreach($links as $link){
                    echo "<span class='text-xs px-6 py-3'>$link</span>";
                }
            ?>
            <a href="../auth/logout.php" class="text-sm cursor-pointer py-1 px-4 text-white font-semibold rounded-lg bg-red-400 hover:bg-red-600 border-2 border-red-200 hover:border-red-400 transition ease-in-out duration-500 h-9">Logout</a>
        </div>
    </nav>
    
    <div class="flex flex-col sm:flex-row w-full mt-[10vh] justify-center sm:justify-normal p-3">
        <div class="border-2 p-5 my-2 sm:m-2 sm:w-1/3 bg-white text-center rounded-xl border-red-700 w-full">
            <?php
                $stmtDonneurs = $pdo->query("SELECT COUNT(*) 'total' FROM donneurs");
                $stmtDonneurs->execute();
                $totalDonors = $stmtDonneurs->fetch(PDO::FETCH_ASSOC);
                echo "<p class='text-2xl font-bold'> " . $totalDonors['total']. " </p>";
            ?>
            <p class="text-sm text-gray-600">Total Donors</p>
        </div>
        <div class="border-2 p-5 my-2 sm:m-2 sm:w-1/3 bg-white text-center rounded-xl border-red-700 w-full">
            <?php
                $stmtDons = $pdo->query("SELECT COUNT(*) 'total' FROM dons WHERE status = 'VALIDE' OR status = 'EN STOCK'");
                $stmtDons->execute();
                $totalValidDons = $stmtDons->fetch(PDO::FETCH_ASSOC);
                echo "<p class='text-2xl font-bold'> " . $totalValidDons['total'] . " </p>";
            ?>
            <p class="text-sm text-gray-600">Valid Donations</p>
        </div>
        <div class="border-2 p-5 my-2 sm:m-2 sm:w-1/3 bg-white text-center rounded-xl border-red-700 w-full">
            <?php
                $stmtHopitals = $pdo->query("SELECT COUNT(DISTINCT hopital_recepteur) 'total' from transfusions");
                $stmtHopitals->execute();
                $totalHopitals = $stmtHopitals->fetch(PDO::FETCH_ASSOC);
                echo "<p class='text-2xl font-bold'> " . $totalHopitals['total'] . " </p>";
            ?>
            <p class="text-sm text-gray-600">Hospital Centers</p>
        </div>
    </div>
    
    <div class="flex flex-col sm:flex-row w-full p-3">
        <div class="border-2 p-5 my-2 sm:m-2 sm:w-1/2 bg-white text-center rounded-xl border-red-700 w-full">
            <h2 class="mb-6 font-bold text-red-700 text-xl">Blood Stock Status</h2>
            <div class="flex justify-around mb-4 text-sm sm:overflow-visible overflow-auto">
                <p class="w-1/4 text-center font-semibold">Blood Type</p>
                <p class="w-1/4 text-center font-semibold">Quantity</p>
                <p class="w-1/4 text-center font-semibold">Status</p>
                <p class="w-1/4 text-center font-semibold">Action</p>
            </div>
            <hr class="mb-4 border-red-400">
            <div class="max-h-[300px] overflow-y-auto">
                <?php 
                    if (empty($stock_par_groupe)){
                        echo '<div class="text-center text-gray-500 py-4">No valid donations in stock at the moment.</div>';
                    } else {
                        foreach($stock_par_groupe as $groupe){
                            echo "
                            <div class='flex w-full justify-between mb-4 sm:overflow-visible overflow-auto'>
                                <p class='w-1/4 text-center font-bold text-red-600'>" . htmlspecialchars($groupe['groupe_complet']) . "</p>
                                <p class='w-1/4 text-center'>". $groupe['quantite'] . " units</p>
                                <p class='w-1/4 text-center'>
                                    <span class='px-2 py-1 rounded-full text-xs " . ($groupe['quantite'] > 5 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') . "'>" . 
                                        ($groupe['quantite'] > 5 ? 'Good' : 'Low') . 
                                    "</span>
                                </p>
                                <div class='w-1/4 text-center'>
                                    <a href='dons/validate.php' class='text-white bg-red-500 border-red-600 hover:bg-red-600 hover:scale-105 transition ease-in-out duration-500 cursor-pointer border-2 rounded-md text-sm font-bold px-3 py-1 inline-block'>Manage</a>
                                </div>
                            </div>
                            ";
                        }
                    }
                ?>
            </div>
        </div>

        <div class="border-2 p-5 my-2 sm:m-2 sm:w-1/2 bg-white text-center rounded-xl border-red-700 w-full">
            <h2 class="mb-6 font-bold text-red-700 text-xl">Urgent Alerts</h2>
            <div class="flex justify-around mb-4 text-sm">
                <p class="w-1/3 text-center font-semibold">Blood Type</p>
                <p class="w-1/3 text-center font-semibold">Alert Level</p>
                <p class="w-1/3 text-center font-semibold">Action</p>
            </div>
            <hr class="mb-4 border-red-400">
            <div class="max-h-[300px] overflow-y-auto">
                <?php 
                    if (empty($alertes_besoins)){
                        echo '<div class="text-center text-green-500 py-4">No urgent alerts at the moment.</div>';
                    } else {
                        foreach($alertes_besoins as $alerte){
                            $alertClass = $alerte['niveau_alerte'] === 'CRITIQUE' ? 'bg-red-100 border-l-4 border-red-500' : 'bg-orange-100 border-l-4 border-orange-500';
                            $alertTextClass = $alerte['niveau_alerte'] === 'CRITIQUE' ? 'bg-red-500 text-white' : 'bg-orange-500 text-white';
                            
                            echo "
                            <div class='flex w-full justify-between mb-4 p-3 rounded-lg $alertClass'>
                                <p class='w-1/3 text-center font-bold'>" . htmlspecialchars($alerte['groupe_sanguin'] . $alerte['rhesus']) . "</p>
                                <p class='w-1/3 text-center'>
                                    <span class='px-2 py-1 rounded-full text-xs font-bold $alertTextClass'>
                                        " . htmlspecialchars($alerte['niveau_alerte']) . "
                                    </span>
                                </p>
                                <div class='w-1/3 text-center'>
                                    <a href='validate.php' class='text-white bg-red-400 border-red-300 hover:bg-red-500 hover:scale-105 transition ease-in-out duration-500 cursor-pointer border-2 rounded-md text-sm font-bold px-3 py-1 inline-block'>View</a>
                                </div>
                            </div>
                            ";
                        }
                    }
                ?>
            </div>
        </div>
    </div>

</body>
</html>