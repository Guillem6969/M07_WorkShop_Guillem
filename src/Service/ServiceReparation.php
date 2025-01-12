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


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Decoders\Base64ImageDecoder;
use Intervention\Image\Typography\FontFactory;

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
        
        try{
            $this->conn = new \mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['pwd'], $dbConfig['dbname']);
            $this->log->info("Connection succesfully");
        }catch(Exception $e){
            echo "ERROR: ". $e->getMessage();
            $this->log->error("Connection failed");
        }
    }




    public function getReparation($role, $idReparation) {
        $sql = "SELECT id_reparation, idWorkshop, nameWorkshop, registerDate, licensePlate, photo
                FROM reparation 
                WHERE id_reparation = ?";
    
        try {
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
    
            // Obtener el resultado de la consulta
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
    
            // Verificar si se encontró el registro
            if (!$data) {
                $this->log->error("No reparation found with ID: " . $idReparation);
                throw new \Exception('Reparation not found with ID: ' . $idReparation);
            }
    
            // Agregar al log el éxito en la obtención de la reparación
            $this->log->info("Get successfully: " . $idReparation);
    
            $photo = $data['photo'];
    
            // Modificar la foto si el rol es 'client'
            if ($role == 'client') {
                $photo = $this->addPixelate($photo);
            }
    
            // Crear el objeto Reparation
            $reparation = new Reparation(
                $data['id_reparation'],
                $data['idWorkshop'],
                $data['nameWorkshop'],
                $data['registerDate'],
                $data['licensePlate'], 
                $photo
            );
    
            $stmt->close();
            return $reparation;
    
        } catch (Exception $e) {
            $this->log->error("Get FAILED for ID: " . $idReparation . ". Error: " . $e->getMessage());
            throw new \Exception('Error retrieving reparation: ' . $e->getMessage());
        }
    }
    




    public function insertReparation ($idWorkshop, $workshopName, $date, $licensePlate, $photo)
    {
        $sql = "INSERT INTO `workshop`.`reparation ` (
            `id_reparation`, 
            `idWorkshop`,
            `nameWorkshop`, 
            `registerDate`, 
            `licensePlate`,
            `photo`
        ) VALUES (?, ?, ?, ?, ?, ?)";

       
        
        try{

            $stmt = $this->conn->prepare($sql);

            // Verificar si la preparación de la consulta fue exitosa
            if (!$stmt) {
                throw new \Exception('Error preparing query: ' . $this->conn->error);
            }

            $idReparation = $this->generateUUID();
            $photo = $this->addWatermark($photo, $licensePlate, $idReparation);

            // Enlazar parámetros (tipos: i = entero, s = string)
            $stmt->bind_param("sissss", $idReparation,$idWorkshop,  $workshopName, $date, $licensePlate, $photo);

            $stmt->execute();
            $this->log->info("Insert succesfully".$idReparation);
        }catch(Exception $e){
            echo "ERROR: ". $e->getMessage();
            $this->log->error("Insert failed");
        }

        $stmt->close();

        }
    
    public function __destruct() {
        $this->conn->close(); // Cerrar la conexión al destruir la instancia
    }



    //Function to pixelate the photo for the client
    function addPixelate($photo): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($photo, Base64ImageDecoder::class);

        $image->pixelate(48);

        return base64_encode($image->encode()); 
    }


    //Function to add a watermark to the photo for the employee
    function addWatermark($photo, $licensePlate, $idReparation): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($photo, Base64ImageDecoder::class);

        $image->text($licensePlate . ' - ' . $idReparation, 20, 50, function (FontFactory $font) {
            $font->size(54);
            $font->color('#000000');
            $font->stroke('#FFFFFF', 9);
        });

        return base64_encode($image->encode());
    }
}
