<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/clients_queries.php');
class Client extends Client_Queries{
    protected $idCliente=null;


    public function setIdCliente($value){
        if (Validator::validateNaturalNumber($value)) {
            $this->idCliente=$value;
            return true;
        }else {
            return false;
        }
    }
    public function getID(){
        return $this->idCliente;
    }
}