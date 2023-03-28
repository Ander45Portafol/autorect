<?php
require_once('../../helpers/database.php');

class CategoryQueries{
    //Metodo para realizar una insercion
    public function createRow(){
        $sql='INSERT INTO categorias(nombre_categoria, descripcion_categoria) VALUES(?,?)';
        $params=array(this->nombre, this->descripcion);
        return Database::executeRow($sql,$params);
    }
}