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

        $this->service->insertReparation(
            $_POST['idWorkshop'],
            $_POST['nameWorkshop'],
            $_POST['registerDate'],
            $_POST['licensePlate'],
            $_POST['photo'],
        );

    }
    
}
