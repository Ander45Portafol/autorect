<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/employee_queries.php');

class Employee extends EmployeeQueries
{
    protected $employee_id = null;
    protected $employee_name = null;
    protected $employee_lastname = null;
    protected $employee_dui = null;
    protected $employee_mail = null;
    protected $employee_phone = null;
    protected $employee_date = null;
    protected $employee_address = null;
    protected $employee_status = null;
    protected $employee_type = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->employee_id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeeName($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->employee_name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setLastname($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->employee_lastname = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeeDUI($value)
    {
        if (Validator::validateDUI($value)) {
            $this->employee_dui = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeeMail($value)
    {
        if (Validator::validateEmail($value)) {
            $this->employee_mail = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeePhone($value)
    {
        if (Validator::validatePhone($value)) {
            $this->employee_phone = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeeDate($value)
    {
        if (Validator::validateDate($value)) {
            $this->employee_date = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeeAddress($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 250)) {
            $this->employee_address = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeeStatus($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->employee_status = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEmployeeType($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->employee_type = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->employee_id;
    }
    public function getEmployeeName()
    {
        return $this->employee_name;
    }
    public function getEmployeeLastname()
    {
        return $this->employee_lastname;
    }
    public function getEmployeeDUI()
    {
        return $this->employee_dui;
    }
    public function getEmployeeMail()
    {
        return $this->employee_mail;
    }
    public function getEmployeePhone()
    {
        return $this->employee_phone;
    }
    public function getEmployeeDate()
    {
        return $this->employee_date;
    }
    public function getEmployeeAddress()
    {
        return $this->employee_address;
    }
    public function getEmployeeStatus()
    {
        return $this->employee_status;
    }

    public function getEmployeeType()
    {
        return $this->employee_type;
    }
}