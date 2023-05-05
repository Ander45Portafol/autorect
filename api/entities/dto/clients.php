<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/clients_queries.php');
//Class with dependencies at the queries file
class Client extends ClientQueries
{
    //Atributes to manipulate data
    protected $client_id = null;
    protected $client_name = null;
    protected $client_lastname = null;
    protected $client_dui = null;
    protected $client_mail = null;
    protected $client_phone = null;
    protected $client_address = null;
    protected $user_name = null;
    protected $password = null;
    protected $user_img = null;
    protected $status = null;
    protected $membership_code = null;
    protected $membership_type = null;

    //SETTERS
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

    public function setName($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->client_name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setLastname($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->client_lastname = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClientDui($value)
    {
        if (Validator::validateDUI($value, 1, 15)) {
            $this->client_dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClientMail($value)
    {
        if (Validator::validateEmail($value, 1, 150)) {
            $this->client_mail = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClientPhone($value)
    {
        if (Validator::validatePhone($value, 1, 9)) {
            $this->client_phone = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClientAddress($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 250)) {
            $this->client_address = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsername($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->user_name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPassword($value)
    {
        if (Validator::validatePassword($value)) {
            $this->user_name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImg($file)
    {
        if (Validator::validateImageFile($file, 1500, 1500)) {
            $this->user_img = $file;
            return true;
        } else {
            return false;
        }
    }

    public function setStatus($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->status = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMembershipCode($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 10)) {
            $this->membership_code = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMembershipType($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->membership_type = $value;
            return true;
        } else {
            return false;
        }
    }

    //GETTERS
    //Method's get for each atribute
    public function getID()
    {
        return $this->client_id;
    }

    public function getName()
    {
        return $this->client_name;
    }

    public function getLastname()
    {
        return $this->client_lastname;
    }

    public function getDUI()
    {
        return $this->client_dui;
    }

    public function getMail()
    {
        return $this->client_mail;
    }

    public function getPhone()
    {
        return $this->client_phone;
    }

    public function getAddress()
    {
        return $this->client_address;
    }

    public function getUsername()
    {
        return $this->user_name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getImg()
    {
        return $this->user_img;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMembershipCode()
    {
        return $this->membership_code;
    }

    public function getMembershipType()
    {
        return $this->membership_type;
    }
}