<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/valorations_queries.php');
//Class with dependeces at he Querie's file
class valorations extends Valorations_queries
{
    //Atributes to do manipule data
    protected $id_valoracion = null;

    //Method's set for each atribute
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_valoracion = $value;
            return true;
        } else {
            return false;
        }
    }
    
    //Method's get for each atribute
    public function getID()
    {
        return $this->id_valoracion;
    }
}
