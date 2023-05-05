<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/users_queries.php');

//Class with dependencies at the queries file
class User extends UserQueries
{
    //Atributes to do manipule data
    protected $user_id = null;
    protected $user_name = null;
    protected $user_password = null;
    protected $user_img = null;
    protected $user_status = null;
    protected $user_employee = null;
    protected $user_type = null;
    protected $theme = null;
    protected $lenguage = null;
    protected $route = '../../images/users/';

    //Method's set for each atribute
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->user_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setUserName($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->user_name = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPasswordUser($value)
    {
        if (Validator::validatePassword($value)) {
            $this->user_password = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setImgUser($file)
    {
        if (Validator::validateImageFile($file, 1500, 1500)) {
            $this->user_img = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }
    public function setUserStatus($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->user_status = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEmployee($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->user_employee = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setUserType($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->user_type = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setTheme($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->theme = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setLenguage($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->lenguage = $value;
            return true;
        } else {
            return false;
        }
    }
    //Method's get for each atribute
    public function getId()
    {
        return $this->user_id;
    }
    public function getUserName()
    {
        return $this->user_name;
    }
    public function getPasswordUser()
    {
        return $this->user_password;
    }
    public function getUserImg()
    {
        return $this->user_img;
    }
    public function getUserStatus()
    {
        return $this->user_status;
    }
    public function getEmployee()
    {
        return $this->user_employee;
    }
    public function getTheme()
    {
        return $this->theme;
    }
    public function getLenguage()
    {
        return $this->lenguage;
    }
    //This method getRuta is to capture the url of the users image
    public function getRoute()
    {
        return $this->route;
    }
}