<?php

namespace App\Service;

use mysqli;

require '../Model/Reparation.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Model\Reparation;
use Exception;
use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;
use Ramsey\Uuid\Nonstandard\Uuid;

class ServiceReparation {
    private $conn;

    private Logger $log;

    function generateUUID()
    {
        return Uuid::uuid4();
    }
    public function __construct() {

        $this->log = new Logger('log');
        try{
            $this->log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/app_reparation.log', Level::Info));
        } catch (Exception $e){
            echo "ERROR: ". $e->getMessage();
        }

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
            $this->log->error("Connection failed");
            throw new \Exception('Connection failed: ' . $this->conn->connect_error);
        }
        $this->log->info("Connection succesfully");

        
    }

    public function getReparation($role, $idReparation) {

        $sql = "SELECT id_reparation, idWorkshop, nameWorkshop, registerDate, licensePlate, photo
                FROM reparation 
                WHERE id_reparation = ?";

        $stmt = $this->conn->prepare($sql);
    
        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            throw new \Exception('Error preparing query: ' . $this->conn->error);
        }

        // Vincular el parámetro 'idReparation' (tipo 'i' para entero)
        $stmt->bind_param("i", $idReparation);
    
        if (!$stmt->execute()) {
            $this->log->error("GET failed");
            throw new \Exception('Error executing query: ' . $stmt->error);
        }
        $this->log->info("Get succesfully".$idReparation);

    
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new \Exception('Reparation not found.');
        }
    
        $data = $result->fetch_assoc();
        $reparation = new Reparation($data['id_reparation'],$data['idWorkshop'],$data['nameWorkshop'],$data['registerDate'],$data['licensePlate'], $data['photo'],);
        $stmt->close();
        return $reparation;
    }

    public function insertReparation ($idWorkshop, $workshopName, $date, $licensePlate, $photo){
        $sql = "INSERT INTO `workshop`.`reparation` (
            `id_reparation`, 
            `idWorkshop`,
            `nameWorkshop`, 
            `registerDate`, 
            `licensePlate`,
            `photo`
        ) VALUES (?, ?, ?, ?, ?, ?)";


    $stmt = $this->conn->prepare($sql);
    
    // Verificar si la preparación de la consulta fue exitosa
    if (!$stmt) {
        throw new \Exception('Error preparing query: ' . $this->conn->error);
    }

    $idReparation = $this->generateUUID();
    // Enlazar parámetros (tipos: i = entero, s = string)
    $stmt->bind_param("sissss", $idReparation,$idWorkshop,  $workshopName, $date, $licensePlate, $photo);

    if (!$stmt->execute()) {
        $this->log->error("Insert failed".$idReparation);
        throw new \Exception('Error executing query: ' . $stmt->error);
    }
    $this->log->info("Insert succesfully".$idReparation);

    $stmt->close();
    }
    
    public function __destruct() {
        $this->conn->close(); // Cerrar la conexión al destruir la instancia
    }

}
