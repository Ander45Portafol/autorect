<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/employee_queries.php');

////Class with dependencies at the queries file
class Employee extends EmployeeQueries
{
    //Atributes to manage the database information
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

    //Function to set the ID of the employee
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->employee_id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the first names of the employee
    public function setEmployeeName($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->employee_name = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the last names of the employee
    public function setLastname($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->employee_lastname = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the DUI of the employee
    public function setEmployeeDUI($value)
    {
        if (Validator::validateDUI($value)) {
            $this->employee_dui = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the email of the employee
    public function setEmployeeMail($value)
    {
        if (Validator::validateEmail($value)) {
            $this->employee_mail = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the phone number of the employee
    public function setEmployeePhone($value)
    {
        if (Validator::validatePhone($value)) {
            $this->employee_phone = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the birth date of the employee
    public function setEmployeeDate($value)
    {
        if (Validator::validateDate($value)) {
            $this->employee_date = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the address of the employee
    public function setEmployeeAddress($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 250)) {
            $this->employee_address = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the employee status
    public function setEmployeeStatus($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->employee_status = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to set the type of employee
    public function setEmployeeType($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->employee_type = $value;
            return true;
        } else {
            return false;
        }
    }

    //Function to get the ID of the employee
    public function getId()
    {
        return $this->employee_id;
    }

    //Function to get the first names of the employee
    public function getEmployeeName()
    {
        return $this->employee_name;
    }

    ////Function to get the last names of the employee
    public function getEmployeeLastname()
    {
        return $this->employee_lastname;
    }

    ////Function to get the DUI of the employee
    public function getEmployeeDUI()
    {
        return $this->employee_dui;
    }

    //Function to get the email of the employee
    public function getEmployeeMail()
    {
        return $this->employee_mail;
    }

    //Function to get the phone number of the employee
    public function getEmployeePhone()
    {
        return $this->employee_phone;
    }

    //Function to get the birth date of the employee
    public function getEmployeeDate()
    {
        return $this->employee_date;
    }

    //Function to get the address of the employee
    public function getEmployeeAddress()
    {
        return $this->employee_address;
    }

    //Function to get the employee status
    public function getEmployeeStatus()
    {
        return $this->employee_status;
    }

    //Function to get the type of employee
    public function getEmployeeType()
    {
        return $this->employee_type;
    }
}