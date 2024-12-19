<?php

namespace App\View;
require_once '../../vendor/autoload.php';
require_once '../Controller/ControllerReparation.php';

use Controller\ControllerReparation;



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
        <button type="submit">Search</button>
    </form>

    
    <?php
    if($_SESSION['role'] === 'employee') { ?>

    <form method="post">

        <label for="id_reparation">Reparation ID:</label>
        <input type="text" id="id_reparation" name="id_reparation" required>

        <label for="nameWorkshop">Workshop's name:</label>
        <input type="text" id="nameWorkshop" name="nameWorkshop" required>

        <label for="registerDate">Date :</label>
        <input type="date" id="registerDate" name="registerDate" required>
        
        <br><label for="licensePlate">Licenseplate :</label>
        <input type="text" id="licensePlate" name="licensePlate" placeholder="1234XXX" required>

        <button type="submit">Send</button>
    </form>
    <?php
    }

    ?>
    <?php
    class ViewReparation{
        function render($reparation){
            if (isset($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php elseif (isset($data)): ?>
                <h3>Reparation Details</h3>
                <p><strong>ID Reparation:</strong> <?= ($reparation->getIdReparation()) ?></p>
                <p><strong>Work Shop:</strong> <?= ($reparation->getnameWorkshop()) ?></p>
                <p><strong>Date:</strong> <?= ($reparation->getRegisterDate()) ?></p>
                <p><strong>License Plate:</strong> <?= ($reparation->getLicensePlate()) ?></p>
            <?php endif; 
        }
    }
    ?>
</body>
</html>

