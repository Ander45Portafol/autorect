<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/order_queries.php');

class Order extends OrderQueries
{
    protected $order_id = null;
    protected $order_address = null;
    protected $order_date = null;
    protected $client_id = null;
    protected $order_status_id = null;
    protected $employee_id = null;
    protected $detail_id = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->order_id = $value;
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
    public function setAdrress($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 200)) {
            $this->order_address = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDate($value)
    {
        if (Validator::validateDate($value)) {
            $this->order_date = $value;
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
    public function setStatusId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->order_status_id = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEmployeeId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->employee_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //metodos para obtener valores de los atributos
    public function getId()
    {
        return $this->detail_id;
    }
    public function getDetailId()
    {
        return $this->order_id;
    }
    public function getAddress()
    {
        return $this->order_address;
    }
    public function getDate()
    {
        return $this->order_date;
    }
    public function getClientId()
    {
        return $this->client_id;
    }
    public function getStatusId()
    {
        return $this->order_status_id;
    }
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
}