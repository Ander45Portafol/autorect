<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class create to controller all queries at the database

class ClientQueries
{
    //This function is show all datas of the clients is used to show data in the table
    public function readAll()
    {
        $query = "SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente 
                  FROM clientes 
                  WHERE estado_cliente = true";
        return Database::getRows($query);
    }

    //This function is to catch one data, whit the identicator
    public function readOne()
    {
        $query = "SELECT * 
                  FROM clientes 
                  WHERE id_cliente = ?";
        $params = array($this->client_id);
        return Database::getRow($query, $params);
    }
    //This function is to search the clients data, with parameters
    public function searchRows($value)
    {
        $query = "SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,telefono_cliente, estado_cliente 
                  FROM clientes 
                  WHERE dui_cliente 
                  ILIKE ? 
                  OR nombre_cliente 
                  ILIKE ? 
                  AND estado_cliente = true 
                  ORDER BY id_cliente";
        $params = array("%$value%", "%$value%");
        return Database::getRows($query, $params);
    }
    //This function is to delete the client data
    public function deleteRow()
    {
        $query = "UPDATE clientes 
                  SET estado_cliente = false 
                  WHERE id_cliente = ?";
        $params = array($this->client_id);
        return Database::executeRow($query, $params);
    }
}