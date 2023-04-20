<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/valorations_queries.php');
class valorations extends Valorations_queries{
    protected $id_valoracion=null;


    public function setId($value){
        if (Validator::validateNaturalNumber($value)) {
            $this->id_valoracion=$value;
            return true;
        }else {
            return false;
        }
    }
    public function getID(){
        return $this->id_valoracion;
    }
}