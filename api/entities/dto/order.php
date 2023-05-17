<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/order_queries.php');

//Class with dependencies at the queries file
class Order extends OrderQueries
{
    //Atributes to manage the database information
    protected $order_id = null;
    protected $order_address = null;
    protected $order_date = null;
    protected $client_id = null;
    protected $order_status_id = null;
    protected $employee_id = null;
    protected $detail_id = null;
    protected $quantity_product=null;

    //Function to set the order ID
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->order_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the order detail ID
    public function setDetailId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->detail_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the order adress
    public function setAdrress($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 200)) {
            $this->order_address = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the order date 
    public function setDate($value)
    {
        if (Validator::validateDate($value)) {
            $this->order_date = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the client 
    public function setClientId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->client_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the order status
    public function setStatusId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->order_status_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the employee
    public function setEmployeeId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->employee_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setQuantityProduct($value){
        if (Validator::validateNaturalNumber($value)) {
            $this->quantity_product = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to get the order ID
    public function getId()
    {
        return $this->detail_id;
    }

    //Function to get the order detail ID
    public function getDetailId()
    {
        return $this->order_id;
    }

    //Function to get the order adress
    public function getAddress()
    {
        return $this->order_address;
    }

    //Function to get the order date
    public function getDate()
    {
        return $this->order_date;
    }

    //Function to get the client 
    public function getClientId()
    {
        return $this->client_id;
    }

    //Function to get the order status
    public function getStatusId()
    {
        return $this->order_status_id;
    }

    //Function to get the employee
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
}