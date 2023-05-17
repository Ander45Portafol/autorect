<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class to control all queries at the database

class ClientQueries
{
    //Validation for user username (clients) method
    public function checkUser($alias)
    {
        //select with parameters to compare (usuario_cliente)
        $query = "SELECT id_cliente, estado_cliente
                  FROM clientes 
                  WHERE usuario_cliente = ?";
        //setting paramethers with the information that was colected
        $params = array($alias);
        //passign the information to the database
        $data = Database::getRow($query, $params);
        //comparing information to do something
        if ($data) {
            //returning information true
            $this->client_id = $data['id_cliente'];
            $this->status=$data['estado_cliente'];
            $this->user_name = $alias;
            return true;
        } else {
            //returning information false
            return false;
        }
    }

    //Validation for user password (clients) method
    public function checkPassword($password)
    {
        //select with parameters to compare (id_cliente)
        $query = "SELECT clave_cliente 
                  FROM clientes 
                  WHERE id_cliente = ?";
        //setting paramethers with the information that was colected
        $params = array($this->client_id);
        //passign the information to the database
        $data = Database::getRow($query, $params);
        //comparing information to do something
        if ($password == $data['clave_cliente']) {
            //returning information true
            return true;
        } else {
            //returning information false
            return false;
        }
    }

    //Method to change the user's password
    public function changePassword()
    {
        //sentence to make an update in the field that stores the client password passing paramethers (id_cliente)
        $query = 'UPDATE clientes 
                  SET clave_cliente = ? 
                  WHERE id_cliente = ?';
        //setting paramethers with the information that was colected
        $params = array($this->password, $this->client_id);
        //returning information that was colected
        return Database::executeRow($query, $params);
    }

    //Method to let the client change information in their profile
    public function editProfile()
    {
        //sentence to make an update in the fields that stores the client information passing paramethers (id_cliente)
        $query = 'UPDATE clientes
                  SET nombre_cliente = ?, apellido_cliente = ?, dui_cliente = ?, correo_cliente = ?, telefono_cliente = ?, direccion_cliente = ?
                  WHERE id_cliente = ?';
        //setting paramethers with the information that was colected
        $params = array($this->client_name, $this->client_lastname, $this->client_dui, $this->client_mail, $this->client_phone, $this->client_address, $this->client_id);
        //returning information that was colected
        return Database::executeRow($query, $params);
    }

    //Method to change the status of the client user
    public function changeStatus()
    {
        //sentence to make an update in the field that stores the client status passing paramethers (id_cliente)
        $query = 'UPDATE clientes
                  SET estado_cliente = ?
                  WHERE id_cliente = ?';
         //setting paramethers with the information that was colected
        $params = array($this->status, $this->client_id);
        //returning information that was colected
        return Database::executeRow($query, $params);
    }

    //This function is show all datas of the clients is used to show data in the table
    public function readAll()
    {
        $query = "SELECT id_cliente,nombre_cliente, apellido_cliente, usuario_cliente, dui_cliente,estado_cliente,telefono_cliente 
                  FROM clientes";
        return Database::getRows($query);
    }

    //This function is to catch one data with the identicator
    public function readOne()
    {
        $query = "SELECT * 
                  FROM clientes 
                  WHERE id_cliente = ?";
        $params = array($this->client_id);
        return Database::getRow($query, $params);
    }
    //This function is to search the clients data with parameters
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
    public function FalseClient()
    {
        $query = "UPDATE clientes 
                  SET estado_cliente = false 
                  WHERE id_cliente = ?";
        $params = array($this->client_id);
        return Database::executeRow($query, $params);
    }
    public function TrueClient()
    {
        $query = "UPDATE clientes 
                  SET estado_cliente = true 
                  WHERE id_cliente = ?";
        $params = array($this->client_id);
        return Database::executeRow($query, $params);
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
    public function createRow()
    {
        $status_client='true';
        $sql = 'INSERT INTO clientes(nombre_cliente,apellido_cliente,correo_cliente,usuario_cliente,estado_cliente,telefono_cliente,clave_cliente)
                VALUES(?, ?, ?, ?, ?,?,?)';
        $params = array($this->client_name, $this->client_lastname, $this->client_mail, $this->client_name,$status_client,$this->client_phone, $this->password);
        return Database::executeRow($sql, $params);
    }
}