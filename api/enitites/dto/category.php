<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/category_queries.php');

class Category extends CategoryQueries{
    protected $id=null;
    protected $nombre=null;
    protected $imagen=null;
    protected $descripcion=null;
    protected $ruta=null;

    public function setId($value){
        if ($value) {
            $this->id=$value; 
            return true;
        }else {
            return false;
        }
    }
    public function setNombre($value){
        if ($value) {
            $this->nombre=$value; 
            return true;
        }else {
            return false;
        }
    }
    public function setImagen($value){
        if ($value) {
            $this->imagen=$value; 
            return true;
        }else {
            return false;
        }
    }
    public function setDescripcion($value){
        if ($value) {
            $this->descripcion=$value; 
            return true;
        }else {
            return false;
        }
    }
    //metodos para obtener valores de los atributos
    public function getId(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getImagen(){
        return $this->imagen;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
}