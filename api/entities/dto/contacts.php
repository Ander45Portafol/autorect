<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/contact_queries.php');

class Contact extends ContactQueries
{
    //Attributes to manage the database
    protected $contact_id = null;
    protected $contacting_email = null;
    protected $message = null;
    protected $client_id = null;

    //Setters
    public function setContactId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->contact_id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setContactingEmail($value){
        if (Validator::validateEmail($value)) {
            $this->contacting_email = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMessage($value){
        if (Validator::validateAlphanumeric($value, 1, 500)) {
            $this->message = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClientId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->client_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Getters
    public function getContactId()
    {
        return $this->contact_id;
    }

    public function getContactingEmail()
    {
        return $this->contacting_email;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getClientId()
    {
        return $this->client_id;
    }
}