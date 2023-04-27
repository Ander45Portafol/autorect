<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/models_queries.php');
//Class with dependeces at he Querie's file
class Models extends ModelQueries
{
    //Atributes to do manipule data
    protected $id = null;
    protected $nombre_modelo = null;
    protected $anio_modelo = null;
    protected $marca = null;
    //Method's set for each atribute
    public function setID($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setModelo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 75)) {
            $this->nombre_modelo = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setAnio($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 5)) {
            $this->anio_modelo = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setMarcas($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->marca = $value;
            return true;
        } else {
            return false;
        }
    }
    //Method's get for each atribute
    public function getID()
    {
        return $this->id;
    }
    public function getNombreModelo()
    {
        return $this->nombre_modelo;
    }
    public function getAnio()
    {
        return $this->anio_modelo;
    }
    public function getMarca()
    {
        return $this->marca;
    }
}