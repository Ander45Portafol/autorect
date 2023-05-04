<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/models_queries.php');
//Class with dependencies at the queries file
class Model extends ModelQueries
{
    //Atributes to do manipule data
    protected $model_id = null;
    protected $model_name = null;
    protected $model_year = null;
    protected $brand = null;
    //Method's set for each atribute
    public function setID($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->model_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setModelName($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 75)) {
            $this->model_name = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setModelYear($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 5)) {
            $this->model_year = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setModelBrand($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->brand = $value;
            return true;
        } else {
            return false;
        }
    }
    //Method's get for each atribute
    public function getID()
    {
        return $this->model_id;
    }
    public function getModelName()
    {
        return $this->model_name;
    }
    public function getModelYear()
    {
        return $this->model_year;
    }
    public function getModelBrand()
    {
        return $this->brand;
    }
}