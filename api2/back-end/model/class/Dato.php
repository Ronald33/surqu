<?php
class Dato implements JsonSerializable
{
    private $id;

    private $fecha;

    private $presion;

    private $humedad;

    private $temperatura;

    private $temperaturaInterna;

    /**
     * Default constructor
     */
    public function __construct($id = NULL)
    {
        $this->id = $id;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of presion
     */ 
    public function getPresion()
    {
        return $this->presion;
    }

    /**
     * Set the value of presion
     *
     * @return  self
     */ 
    public function setPresion($presion)
    {
        $this->presion = $presion;

        return $this;
    }

    /**
     * Get the value of humedad
     */ 
    public function getHumedad()
    {
        return $this->humedad;
    }

    /**
     * Set the value of humedad
     *
     * @return  self
     */ 
    public function setHumedad($humedad)
    {
        $this->humedad = $humedad;

        return $this;
    }

    /**
     * Get the value of temperatura
     */ 
    public function getTemperatura()
    {
        return $this->temperatura;
    }

    /**
     * Set the value of temperatura
     *
     * @return  self
     */ 
    public function setTemperatura($temperatura)
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    /**
     * Get the value of temperaturaInterna
     */ 
    public function getTemperaturaInterna()
    {
        return $this->temperaturaInterna;
    }

    /**
     * Set the value of temperaturaInterna
     *
     * @return  self
     */ 
    public function setTemperaturaInterna($temperaturaInterna)
    {
        $this->temperaturaInterna = $temperaturaInterna;

        return $this;
    }
}
