<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class create to controller all queries at the database

class Client_Queries
{
    //This function is show all datas of the clients is used to show data in the table
    public function readAll()
    {
        $sql = 'SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente FROM clientes WHERE estado_cliente=true';
        return Database::getRows($sql);
    }
    //This function is to catch one data, whit the identicator
    public function readOne()
    {
        $sql = 'SELECT * FROM clientes WHERE id_cliente=?';
        $params = array($this->idCliente);
        return Database::getRow($sql, $params);
    }
    //This function is to search the clients data, with parameters
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente, estado_cliente FROM clientes WHERE dui_cliente ILIKE ? AND estado_cliente=true ORDER BY id_cliente';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    //This function is to delete the client data
    public function deleteRow()
    {
        $sql = 'UPDATE clientes SET estado_cliente=false WHERE id_cliente=?';
        $params = array($this->idCliente);
        return Database::executeRow($sql, $params);
    }
}
