<?php

namespace Model;

use PDO;

class Reparation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getReparation($idReparation) {
        $stmt = $this->db->prepare("SELECT * FROM reparation WHERE id_reparation = :id");
        $stmt->bindParam(':id', $idReparation, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("No se encontró la reparación con el ID proporcionado.");
        }
    }
}
