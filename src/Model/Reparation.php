<?php

namespace Model;

use PDO;

class Reparation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

}
