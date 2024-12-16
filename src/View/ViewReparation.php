<?php
require_once '../../vendor/autoload.php';
require '../Controller/ControllerReparation.php';
use Controller\ControllerReparation;



// Iniciar sesión para guardar el rol del usuario
session_start();

if (isset($_GET['role'])) {
    $_SESSION['role'] = $_GET['role']; // Guardamos el rol en la sesión
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparation Details</title>
</head>
<body>


    <h2>Welcome, <?=($_SESSION['role'])?></h2>

    
    <form method="post">
        <label for="id_reparation">Enter Reparation ID:</label>
        <input type="text" id="id_reparation" name="id_reparation" required>
        <button type="submit">Search</button>
    </form>

    <?php
    // Comprobar si se ha enviado un ID de reparación
    if (isset($_POST['id_reparation'])) {
    $idReparation = $_POST['id_reparation'];

    // Usar el controlador para obtener los datos de reparación
    $controller = new ControllerReparation();
        try {
            $data = $controller->getReparation($idReparation); // Obtener datos
        }catch (Exception $e) {
        $error = $e->getMessage();
        }
    }

    ?>

    <?php if (isset($error)): ?>
        <!-- Mostrar error si no se encuentra el ID o hubo problemas -->
        <p style="color: red;"><?= ($error) ?></p>
    <?php elseif (isset($data)): ?>
        <!-- Mostrar datos de la reparación -->
        <h3>Reparation Details</h3>
        <p><strong>ID Reparación:</strong> <?= ($data['id_reparation']) ?></p>
        <p><strong>Taller:</strong> <?= ($data['nameWorkshop']) ?></p>
        <p><strong>Fecha:</strong> <?= ($data['registerDate']) ?></p>
        <p><strong>Placa:</strong> <?= ($data['licensePlate']) ?></p>
        <p><strong>Foto:</strong></p>
        <!-- Mostrar foto -->
    <?php endif; ?>
</body>
</html>

