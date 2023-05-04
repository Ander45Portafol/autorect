<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/brand_queries.php');

//Class with dependencies at the queries file
class Brand extends BrandQueries
{
    //Atributes to do manipule data
    protected $brand_id = null;
    protected $brand_name = null;
    protected $brand_logo = null;

    //Atributes to manage the images
    protected $route = '../../images/brands/';

    //Function to set the brand ID
    public function setID($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->brand_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the brand name
    public function setBrandName($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->brand_name = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the brand logo
    public function setBrandLogo($file)
    {
        if (Validator::validateImageFile($file, 1500, 1500)) {
            $this->brand_logo = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    //Function to get the brand ID
    public function getID()
    {
        return $this->brand_id;
    }

    //Function to get the brand name
    public function getBrandName()
    {
        return $this->brand_name;
    }

    //Function to get the brand logo
    public function getLogo()
    {
        return $this->brand_logo;
    }

    //Function to get the route to save the images
    public function getRoute()
    {
        return $this->route;
    }
}