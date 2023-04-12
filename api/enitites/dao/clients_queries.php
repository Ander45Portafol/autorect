<?php
require_once('../../helpers/database.php');

class Client_Queries{
    public function readAll(){
        $sql='SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente, estado_cliente FROM clientes';
        return Database::getRows($sql);
    }
    public function searchRows($value){
        $sql='SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente, estado_cliente FROM clientes WHERE dui_cliente ILIKE ? ORDER BY id_cliente';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
}