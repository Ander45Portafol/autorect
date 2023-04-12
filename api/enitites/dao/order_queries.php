<?php
require_once('../../helpers/database.php');

class OrderQueries{
    //Metodo para cargar la tabla
    public function readAll(){
        $sql='SELECT * FROM vista_pedidos';
        return Database::getRows($sql);
    }
}