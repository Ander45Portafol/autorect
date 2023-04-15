<?php
require_once('../../helpers/database.php');

class BrandQueries
{

    public function readAll()
    {
        $query = 'SELECT *
                  FROM marcas
                  ORDER BY id_marca';
        return Database::getRows($query);
    }

    public function readOne()
    {
        $query = 'SELECT *
                  FROM marcas
                  WHERE id_marca = ?';
        $params = array($this->brand_id);
        return Database::getRow($query, $params);
    }

    public function deleteRow()
    {
        $query = 'DELETE 
                  FROM marcas
                  WHERE id_marca = ?';
        $params = array($this->brand_id);
        return Database::executeRow($query, $params);
    }
}