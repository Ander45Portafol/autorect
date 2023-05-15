<?php
//Dependencies
require_once('../../helpers/database.php');

class ConctactQueries
{
    public function readInfo()
    {
        $space = " ";
        $query = "SELECT id_cliente, CONCAT(nombre_cliente, '$space', apellido_cliente) as nombre_completo_cliente
                FROM clientes
                WHERE id_cliente = ?";
        return Database::getRows($query);
    }
}