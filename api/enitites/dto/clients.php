<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/clients_queries.php');
//Class with dependeces at he Querie's file
class Client extends Client_Queries
{
    //Atributes to do manipule data
    protected $idCliente = null;

    //Method's set for each atribute
    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idCliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Method's get for each atribute
    public function getID()
    {
        return $this->idCliente;
    }
}
