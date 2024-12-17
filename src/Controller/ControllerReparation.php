<?php

namespace Controller;

require '../Service/ServiceReparation.php';

use Service\ServiceReparation;
use Intervention\Image\ImageManagerStatic;

class ControllerReparation {
    private $service;

    public function __construct() {
        $this->service = new ServiceReparation();
    }

    public function getReparation($idReparation) {
        try {
            $data = $this->service->getReparation($idReparation);
            // Devuelvo los datos al View
            return $data; 
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}
