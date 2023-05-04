<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/clients_queries.php');
//Class with dependencies at the queries file
class Client extends ClientQueries
{
    //Atributes to do manipule data
    protected $client_id = null;

    //Method's set for each atribute
    public function setCLientId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->client_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Method's get for each atribute
    public function getID()
    {
        return $this->client_id;
    }
}