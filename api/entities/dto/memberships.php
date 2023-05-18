<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/membership_queries.php');

//Class with dependencies at the queries file
class Membership extends MembershipQueries
{
    //Atributes to do manipule data
    protected $membership_type_id = null;
    protected $membership_type = null;
    protected $membership_desc = null;
    protected $membership_price = null;
    protected $membership_img = null;

    //Atributes to manage the images
    protected $route = '../../images/memberships/';

    //Setters
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->membership_type_id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMembershipType($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 30)) {
            $this->membership_type = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMembershipDescription($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 100)) {
            $this->membership_desc = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMembershipPrice($value)
    {
        if (Validator::validateMoney($value)) {
            $this->membership_price = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMembershipImg($value)
    {
        if (Validator::validateImageFile($value, 2000, 2000)) {
            $this->membership_img = $value;
            return true;
        } else {
            return false;
        }
    }

    //Getters
    public function getId()
    {
        return $this->membership_type_id;
    }

    public function getMembershipType()
    {
        return $this->membership_type;
    }

    public function getMembershipDescription()
    {
        return $this->membership_desc;
    }

    public function getMembershipPrice()
    {
        return $this->membership_price;
    }

    public function getMembershipImg()
    {
        return $this->membership_img;
    }

    public function getRoute()
    {
        return $this->route;
    }
}
