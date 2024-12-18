<?php namespace App\Model;
class Reparation
{
    private $idReparation;
    private $nameWorkshop;
    private $registerDate;
    private $licensePlate;
    function __construct($idReparation,$idWorkshop,$registerDate,$licensePlate) {
        $this->idReparation = $idReparation;
        $this->nameWorkshop = $idWorkshop;
        $this->registerDate = $registerDate;
        $this->licensePlate = $licensePlate;
    }
    public function getIdReparation()
    {
        return $this->idReparation;
    }

    public function setIdReparation(
        $idReparation
    ): void {$this->idReparation = $idReparation;}

    public function getIdWorkshop()
    {
        return $this->nameWorkshop;
    }
    public function setIdWorkshop(
        $idWorkshop
    ): void {
        $this->nameWorkshop = $idWorkshop;
    }
    public function getRegisterDate()
    {
        return $this->registerDate;
    }
    public function setRegisterDate(
        $registerDate
    ): void {
        $this->registerDate = $registerDate;
    }
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }
    public function setLicensePlate(
        $licensePlate
    ): void {
        $this->licensePlate = $licensePlate;
    }
}
