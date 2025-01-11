<?php

namespace Controller;

require '../Service/ServiceReparation.php';
require '../View/ViewReparation.php';

use App\Service\ServiceReparation;
use Intervention\Image\ImageManagerStatic;
use App\View\ViewReparation;

if (isset($_POST['getReparation'])){
    $controller = new ControllerReparation();
    $controller->getReparation();
}
 
if (isset($_POST['insertReparation'])){
    $controller = new ControllerReparation();
    $controller->insertReparation();
}

class ControllerReparation {
    private $service;

    public function __construct() {
        $this->service = new ServiceReparation();
    }


    
    public function getReparation(): void {

            $idReparation = $_POST['id_reparation'];
            $role = $_SESSION['role'];
            $reparation = $this->service->getReparation($role,$idReparation);

            // Devuelvo los datos al View
            $view = new ViewReparation();
            $view->render($reparation);
    
    }

    public function insertReparation(){

        $imgTmpName = $_FILES['photo']['tmp_name'];
        $imageToBase64 = base64_encode(file_get_contents($imgTmpName));

        $this->service->insertReparation(
            $_POST['idWorkshop'],
            $_POST['nameWorkshop'],
            $_POST['registerDate'],
            $_POST['licensePlate'],
            $imageToBase64
        );
        ?>
        <p style=" 
                max-width: 400px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);"
        >
        <strong>¡ Insert succesfully !</strong>
        </p>
        <?php
    }
    
}
