<?php

namespace Service;

use Model\Reparation;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ServiceReparation {
    private $conn;

    public function __construct() {
        $dbConfig = parse_ini_file('../../cfg/db_config.ini');
        $this->conn = new \mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['dbname']);

        // Manejar errores de conexión
        if ($this->conn->connect_error) {
            throw new \Exception('Connection failed: ' . $this->conn->connect_error);
        }
    }

    public function getReparation($idReparation) {
        $stmt = $this->conn->prepare("SELECT id_reparation, nameWorkshop, registerDate, licensePlate FROM reparation WHERE id_reparation = ?");

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
