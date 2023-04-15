<?php
require_once('../../helpers/database.php');

class BrandQueries{
    
    public function readAll(){
        $query = 'SELECT *
                  FROM marcas
                  ORDER BY id_marca';
        return Database::getRows($query);
    }
}