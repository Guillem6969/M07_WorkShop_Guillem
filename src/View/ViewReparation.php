<?php

namespace App\View;

// require_once '../../vendor/autoload.php';
// require_once '../Controller/ControllerReparation.php';

use App\Model\Reparation;


// Log in to save user role
session_start();

if (isset($_GET['role'])) {
    $_SESSION['role'] = $_GET['role']; // Save the rol in the session
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparation Details</title>
    <link rel="stylesheet" href="../../css/ViewReparation.css">
</head>
<body>


    <h2>Welcome, <?=($_SESSION['role'])?></h2>

    
    <form method="post" action="../Controller/ControllerReparation.php">
        <label for="id_reparation">Enter Reparation ID:</label>
        <input type="text" id="id_reparation" name="id_reparation" required>
        <input type="submit" name="getReparation"></input>
    </form>

    <?php
    if($_SESSION['role'] === 'employee') { ?>

    <form method="post" action="../Controller/ControllerReparation.php">

        <label for="idWorkshop">Workshop ID:</label>
        <input type="text" id="idWorkshop" name="idWorkshop" required>

        <br><label for="licensePlate">Licenseplate :</label>
        <input type="text" id="licensePlate" name="licensePlate" placeholder="1234XXX" required>
        
        <label for="nameWorkshop">Workshop's name:</label>
        <input type="text" id="nameWorkshop" name="nameWorkshop" required>

        <label for="registerDate">Date :</label>
        <input type="text" id="registerDate" name="registerDate" placeholder="2024-12-12" required>
        
        <br><label for="photo">Photo :</label>
        <input type="file" id="photo" name="photo" placeholder="BROWSE" required>


        <input type="submit" name="insertReparation"></inpùt>
    </form>
    <?php
    }
    ?>
</body>
</html>

<?php
    class ViewReparation{
        function render($reparation){
            if ($reparation != null): ?>
                
                <h3>Reparation Details</h3>
                <p><strong>ID Reparation:</strong> <?= ($reparation->getIdReparation()) ?></p>
                <p><strong>ID Workshop:</strong> <?= ($reparation->getIdWorkshop()) ?></p>
                <p><strong>Work Shop:</strong> <?= ($reparation->getNameWorkshop()) ?></p>
                <p><strong>Date:</strong> <?= ($reparation->getRegisterDate()) ?></p>
                <p><strong>License Plate:</strong> <?= ($reparation->getLicensePlate()) ?></p>
                <p><strong>Photo:</strong> <?= ($reparation->getPhoto()) ?></p>

            <?php endif; 
        }
    }
?>