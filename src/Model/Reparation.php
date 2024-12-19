<?php namespace App\Model;
class Reparation
{
    private $idReparation;
    private $nameWorkshop;
    private $registerDate;
    private $licensePlate;
    function __construct($idReparation,$nameWorkshop,$registerDate,$licensePlate) {
        $this->idReparation = $idReparation;
        $this->nameWorkshop = $nameWorkshop;
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

    public function getnameWorkshop()
    {
        return $this->nameWorkshop;
    }
    public function setnameWorkshop(
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
