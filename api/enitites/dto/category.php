<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/category_queries.php');

//Class with dependeces at he Querie's file
class Category extends CategoryQueries
{
    //Atributes to do manipule data
    protected $id = null;
    protected $nombre = null;
    protected $imagen = null;
    protected $descripcion = null;

    //Method's set for each atribute
    public function setId($value)
    {
        if ($value) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setNombre($value)
    {
        if ($value) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setImagen($value)
    {
        if ($value) {
            $this->imagen = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDescripcion($value)
    {
        if ($value) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }
    //Method's get for each atribute
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
