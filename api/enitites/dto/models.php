<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/models_queries.php');      

class Models extends ModelQueries{
    protected $id = null;
    protected $model_name = null;
    protected $model_year = null;
    protected $brand_id = null;

    public function setId($value){
        if(Validator::validateNaturalNumber($value)){
            $this->id = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setModelName($value){
        if(Validator::validateString($value, 1, 250)){
            $this->model_name = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setModelYear($value){
        if(Validator::validateString($value, 1, 4)){
            $this->model_year = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setBrand_Id($value){
        if(Validator::validateNaturalNumber($value)){
            $this->brand_id = $value;
            return true;
        }else{
            return false;
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getModelName(){
        return $this->model_name;
    }

    public function getModelYear(){
        return $this->model_year;
    }

    public function getBrand_Id(){
        return $this->brand_id;
    }
}