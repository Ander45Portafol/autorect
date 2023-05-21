<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/products_queries.php');

//Class with dependencies at the queries file
class Product extends ProductQueries
{
    //Atributes to do manipule data
    protected $product_id;
    protected $valoration_id;
    protected $product_name;
    protected $product_description;
    protected $product_price;
    protected $product_img;
    protected $product_stock;
    protected $product_category;
    protected $product_model;
    protected $product_status;
    protected $comments;
    protected $quantity;
    protected $client_id;
    protected $detail_id;
    protected $route = '../../images/products/';
    protected $product_img_id;
    protected $s_img;

    //Method's set for each atribute
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->product_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdClient($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->client_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setQuantity($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->quantity = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDetailId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->detail_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setValorationId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->valoration_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductName($value)
    {
        if (Validator::validateAlphanumeric($value, 0, 80)) {
            $this->product_name = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setComment($value)
    {
        if (Validator::validateAlphanumeric($value, 0, 80)) {
            $this->comments = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductDescription($value)
    {
        if (Validator::validateAlphanumeric($value, 0, 150)) {
            $this->product_description = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductPrice($value)
    {
        if (Validator::validateMoney($value)) {
            $this->product_price = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductImg($file)
    {
        if (Validator::validateImageFile($file, 1500, 1500)) {
            $this->product_img = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }
    public function setProductStock($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->product_stock = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductCategory($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->product_category = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductModel($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->product_model = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProductStatus($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->product_status = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImgId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->product_img_id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setSImg($file)
    {
        if (Validator::validateImageFile($file, 1500, 1500)) {
            $this->s_img = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    // Metodos get de los atributos
    public function getId()
    {
        return $this->product_id;
    }
    public function getValorationId()
    {
        return $this->valoration_id;
    }
    public function getProductName()
    {
        return $this->product_name;
    }
    public function getProductDescription()
    {
        return $this->product_description;
    }
    public function getProductPrice()
    {
        return $this->product_price;
    }
    public function getProductImg()
    {
        return $this->product_img;
    }
    public function getProductStock()
    {
        return $this->product_stock;
    }
    public function getProductCategory()
    {
        return $this->product_category;
    }
    public function getProductModel()
    {
        return $this->product_model;
    }
    public function getProductStatus()
    {
        return $this->product_status;
    }
    //This method getRuta is to capture the url of the products image
    public function getRoute()
    {
        return $this->route;
    }

    public function getSImg()
    {
        return $this->s_img;
    }

    public function getProductImgId()
    {
        return $this->product_img_id;
    }
}