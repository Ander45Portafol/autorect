<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/order_queries.php');

class Order extends OrderQueries{
    protected $id=null;
    protected $direccion=null;
    protected $fecha=null;
    protected $id_cliente=null;
    protected $id_estado_pedido=null;
    protected $id_empleado=null;
    protected $id_Detalle=null;

    public function setId($value){
        if(Validator::validateNaturalNumber($value)){
            $this->id=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setIdDetalle($value){
        if(Validator::validateNaturalNumber($value)){
            $this->id_Detalle=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setDireccion($value){
        if(Validator::validateAlphanumeric($value,1,200)){
            $this->direccion=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setFecha($value){
        if (Validator::validateDate($value)) {
            $this->fecha=$value; 
            return true;
        }else {
            return false;
        }
    }
    public function setId_Cliente($value){
        if(Validator::validateNaturalNumber($value)){
            $this->id_cliente=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setId_Estado($value){
        if(Validator::validateNaturalNumber($value)){
            $this->id_estado_pedido=$value;
            return true;
        }
        else{
            return false;
        }
    }
    public function setId_Empleado($value){
        if(Validator::validateNaturalNumber($value)){
            $this->id_empleado=$value;
            return true;
        }
        else{
            return false;
        }
    }

    //metodos para obtener valores de los atributos
    public function getId(){
        return $this->id_Detalle;
    }
    public function getIdDetalle(){
        return $this->id;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getIdCliente(){
        return $this->id_cliente;
    }
    public function getIdEstado(){
        return $this->id_estado_pedido;
    }
    public function getIdEmpleado(){
        return $this->id_empleado;
    }
}