<?php
require_once('../../helpers/database.php');

class Client_Queries{
    public function readAll(){
        $sql='SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente FROM clientes WHERE estado_cliente=true';
        return Database::getRows($sql);
    }
    public function readOne(){
        $sql='SELECT * FROM clientes WHERE id_cliente=?';
        $params=array($this->idCliente);
        return Database::getRow($sql,$params);
    }
    public function searchRows($value){
        $sql='SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente, estado_cliente FROM clientes WHERE dui_cliente ILIKE ? ORDER BY id_cliente';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
    public function deleteRow(){
        $sql ='UPDATE clientes SET estado_cliente=false WHERE id_cliente=?';
        $params=array($this->idCliente);
        return Database::executeRow($sql,$params);
    }
}