<?php
//Dependencies
require_once('../../helpers/database.php');

class BrandQueries
{

    //Function to fill the table
    public function readAll()
    {
        $query = "SELECT *
                  FROM marcas
                  ORDER BY id_marca";
        return Database::getRows($query);
    }

    //Funtion to read 1 brand with its id
    public function readOne()
    {
        $query = "SELECT *
                  FROM marcas
                  WHERE id_marca = ?";
        $params = array($this->brand_id);
        return Database::getRow($query, $params);
    }

    //Function to search brands
    public function searchRow($value)
    {
        $query = "SELECT *
                  FROM marcas
                  WHERE nombre_marca
                  ILIKE ?
                  ORDER BY id_marca";
        $params = array("%$value%");
        return Database::getRows($query, $params);
    }

    //Function to create a brand
    public function createRow()
    {
        $query = "INSERT INTO marcas
                  (nombre_marca, logo_marca)
                  VALUES(?,?)";
        $params = array($this->brand_name, $this->brand_logo);
        return Database::executeRow($query, $params);
    }

    //Function to update a brand
    public function updateRow($current_image)
    {

        ($this->brand_logo) ? Validator::deleteFile($this->getRoute(), $current_image) : $this->brand_logo = $current_image;

        $query = "UPDATE marcas
                  SET nombre_marca = ?, logo_marca = ?
                  WHERE id_marca = ?";
        $params = array($this->brand_name, $this->brand_logo, $this->brand_id);
        return Database::executeRow($query, $params);
    }

    //Function to delete a brand
    public function deleteRow()
    {
        $query = "DELETE 
                  FROM marcas
                  WHERE id_marca = ?";
        $params = array($this->brand_id);
        return Database::executeRow($query, $params);
    }
}