<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/users_queries.php');

class User extends UserQueries{
    protected $id=null;
    protected $nombre_usuario=null;
    protected $clave_usuario=null;
    protected $imagen=null;
    protected $estado_usuario=null;
    protected $empleado=null;
    protected $tipo_usuario=null;
    protected $tema=null;
    protected $idioma=null;

    public function setId($value){
        if(Validator::validateNaturalNumber($value)){
            $this->id=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setUser($value){
        if(Validator::validateAlphanumeric($value,1,50)){
            $this->nombre_usuario=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setPassword($value){
        if(Validator::validatePassword($value)){
            $this->clave_usuario=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setEstadoUser($value){
        if(Validator::validateBoolean($value)){
            $this->estado_usuario=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setEmpleado($value){
        if(Validator::validateNaturalNumber($value)){
            $this->empleado=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setTipo_User($value){
        if(Validator::validateNaturalNumber($value)){
            $this->tipo_usuario=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setTema($value){
        if(Validator::validateNaturalNumber($value)){
            $this->tema=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setIdioma($value){
        if(Validator::validateNaturalNumber($value)){
            $this->idioma=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function getId(){
        return $this->id;
    }
    public function getUser(){
        return $this->nombre_usuario;
    }
    public function getPassword(){
        return $this->clave_usuario;
    }
    public function getEstadoUser(){
        return $this->estado_usuario;
    }
    public function getEmpleado(){
        return $this->empleado;
    }
    public function getTema(){
        return $this->tema;
    }
    public function getIdioma(){
        return $this->idioma;
    }
}