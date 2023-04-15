<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/brand_queries.php');

class Brand extends BrandQueries{
    protected $brand_id = null;
    protected $brand_name = null;
    protected $brand_logo = null;

    public function setID($value){
        if (Validator::validateNaturalNumber($value)) {
            $this->brand_id = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setBrandName($value){
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->brand_name = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setBrandLogo($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->brand_name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getID(){
        return $this->brand_id;
    }

    public function getBrandName()
    {
        return $this->brand_name;
    }

    public function getLogo()
    {
        return $this->brand_logo;
    }
}