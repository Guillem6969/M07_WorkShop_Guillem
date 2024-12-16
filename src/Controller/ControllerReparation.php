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
            
            // $data['license_plate'] = substr($data['license_plate'], 0, 4) . '***';
            // $data['photo'] = $this->maskPhoto($data['photo']);
            
            

            $this->renderView('ViewReparation', $data);
        } catch (\Exception $e) {
            $this->renderView('Error', ['message' => $e->getMessage()]);
        }
    }

    // private function maskPhoto($photoPath) {
    //     // Usa Intervention para enmascarar la foto.
    //     $img = ImageManagerStatic::make($photoPath);
    //     $img->pixelate(10);
    //     $maskedPhotoPath = str_replace('.jpg', '_masked.jpg', $photoPath);
    //     $img->save($maskedPhotoPath);
    //     return $maskedPhotoPath;
    // }

    private function renderView($view, $data) {
        include __DIR__ . "/../View/{$view}.php";
    }
}
