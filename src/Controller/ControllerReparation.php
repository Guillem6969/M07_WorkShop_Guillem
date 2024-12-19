<?php

namespace Controller;

require_once '../Service/ServiceReparation.php';
require_once '../View/ViewReparation.php';

use Service\ServiceReparation;
use Intervention\Image\ImageManagerStatic;
use App\View\ViewReparation;

class ControllerReparation {
    private $service;

    public function __construct() {
        $this->service = new ServiceReparation();
    }

    
    public function getReparation($idReparation): void {

        

            $role = $_SESSION['role'];
            $reparation = $this->service->getReparation($role,$idReparation);

            // Devuelvo los datos al View
            $view = new ViewReparation();
            $view->render($reparation);
    
    }
    
}
