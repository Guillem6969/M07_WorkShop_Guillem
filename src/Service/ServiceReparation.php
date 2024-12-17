<?php

namespace Service;

use mysqli;

use Model\Reparation;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ServiceReparation {
    private $conn;

    public function __construct() {

        $configPath = '../../cfg/db_config.ini';
        
        if (!file_exists($configPath)) {
            throw new \Exception("El archivo de configuración no existe en la ruta: $configPath");
        }

        $dbConfig = parse_ini_file($configPath);

        if ($dbConfig === false) {
            throw new \Exception("No se pudo leer el archivo de configuración en: $configPath");
        }
        
        $this->conn = new \mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['pwd'], $dbConfig['dbname']);

        // Manage connection errors
        if ($this->conn->connect_error) {
            throw new \Exception('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function getReparation($idReparation) {
        $stmt = $this->conn->prepare("SELECT id_reparation, nameWorkshop, registerDate, licensePlate FROM reparation WHERE id_reparation = ?");
    
        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            throw new \Exception('Error preparing query: ' . $this->conn->error);
        }

        // Vincular el parámetro 'idReparation' (tipo 'i' para entero)
        $stmt->bind_param("i", $idReparation);
    
        if (!$stmt->execute()) {
            throw new \Exception('Error executing query: ' . $stmt->error);
        }
    
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception('Reparation not found.');
        }
    
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }
    

    public function __destruct() {
        $this->conn->close(); // Cerrar la conexión al destruir la instancia
    }

    // private function log($action, $message, $level) {
    //     $logger = new Logger('app_workshop');
    //     $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/app_workshop.log', Logger::DEBUG));
    //     $logger->$level("$action: $message");
    // }
}
