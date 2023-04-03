<?php
require_once('../../helpers/database.php');

class Client_Queries{
    public function readAll(){
        $sql='SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente, estado_cliente FROM clientes';
        return Database::getRows($sql);
    }
}