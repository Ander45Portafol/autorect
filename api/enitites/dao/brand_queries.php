<?php
require_once('../../helpers/database.php');

class BrandQueries
{

    public function readAll()
    {
        $query = "SELECT *
                  FROM marcas
                  ORDER BY id_marca";
        return Database::getRows($query);
    }

    public function readOne()
    {
        $query = "SELECT *
                  FROM marcas
                  WHERE id_marca = ?";
        $params = array($this->brand_id);
        return Database::getRow($query, $params);
    }

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

    public function createRow()
    {
        $query = "INSERT INTO marcas
                  (nombre_marca, logo_marca)
                  VALUES(?,?)";
        $params = array($this->brand_name, $this->brand_logo);
        return Database::executeRow($query, $params);
    }

    public function updateRow($current_image)
    {

        ($this->brand_logo) ? Validator::deleteFile($this->getRoute(), $current_image) : $this->brand_logo = $current_image;

        $query = "UPDATE marcas
                  SET nombre_marca = ?, logo_marca = ?
                  WHERE id_marca = ?";
        $params = array($this->brand_name, $this->brand_logo, $this->brand_id);
        return Database::executeRow($query, $params);
    }

    public function deleteRow()
    {
        $query = "DELETE 
                  FROM marcas
                  WHERE id_marca = ?";
        $params = array($this->brand_id);
        return Database::executeRow($query, $params);
    }
}