<?php namespace App\Model;
class Reparation
{
    private $idReparation;
    private $nameWorkshop;
    private $registerDate;
    private $licensePlate;
    private $idWorkshop;
    private $photo;

    function __construct($idReparation,$idWorkshop,$nameWorkshop,$registerDate,$licensePlate,$photo) {
        $this->idReparation = $idReparation;
        $this->idWorkshop = $idWorkshop;
        $this->nameWorkshop = $nameWorkshop;
        $this->registerDate = $registerDate;
        $this->licensePlate = $licensePlate;
        $this->photo = $photo;
    }
    /**
     * Get the value of idReparation
     */
    public function getIdReparation()
    {
        return $this->idReparation;
    }

    /**
     * Set the value of idReparation
     */
    public function setIdReparation($idReparation): self
    {
        $this->idReparation = $idReparation;

        return $this;
    }

    /**
     * Get the value of nameWorkshop
     */
    public function getNameWorkshop()
    {
        return $this->nameWorkshop;
    }

    /**
     * Set the value of nameWorkshop
     */
    public function setNameWorkshop($nameWorkshop): self
    {
        $this->nameWorkshop = $nameWorkshop;

        return $this;
    }

    /**
     * Get the value of registerDate
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * Set the value of registerDate
     */
    public function setRegisterDate($registerDate): self
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get the value of licensePlate
     */
    public function getLicensePlate()
    {
        return $this->licensePlate;
    }

    /**
     * Set the value of licensePlate
     */
    public function setLicensePlate($licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    /**
     * Get the value of idWorkshop
     */
    public function getIdWorkshop()
    {
        return $this->idWorkshop;
    }

    /**
     * Set the value of idWorkshop
     */
    public function setIdWorkshop($idWorkshop): self
    {
        $this->idWorkshop = $idWorkshop;

        return $this;
    }

    /**
     * Get the value of photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set the value of photo
     */
    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
