<?php
require_once('../../helpers/database.php');

class OrderQueries{
    //Metodo to fill the table
    public function readAll(){
        $sql='SELECT * FROM vista_pedidos';
        return Database::getRows($sql);
    }

    //Method to search on the table
    public function searchRows($value){
        $sql='SELECT * FROM vista_pedidos WHERE id_pedido LIKE ?';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
}