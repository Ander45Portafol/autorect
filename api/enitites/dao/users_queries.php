<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class create to controller all queries at the database
class UserQueries
{
    //This function is to verificated if the user is correct in the login process
    public function checkUser($alias)
    {
        $query = "SELECT id_usuario 
                  FROM usuarios 
                  WHERE nombre_usuario = ?";
        $params = array($alias);
        $data = Database::getRow($query, $params);
        if ($data) {
            $this->user_id = $data['id_usuario'];
            $this->user_name = $alias;
            return true;
        } else {
            return false;
        }
    }

    //This function is to verificated if the password is correct in the login process
    public function checkPassword($password)
    {
        $query = "SELECT clave_usuario 
                  FROM usuarios 
                  WHERE id_usuario = ?";
        $params = array($this->user_id);
        $data = Database::getRow($query, $params);
        if ($password == $data['clave_usuario']) {
            return true;
        } else {
            return false;
        }
    }

    //This function is show all datas of the users is used to show data in the table
    public function readAll()
    {
        $query = "SELECT * 
                  FROM usuarios 
                  ORDER BY id_usuario";
        return Database::getRows($query);
    }

    //This function is to catch one data, whit the identicator
    public function readOne()
    {
        $query = "SELECT id_usuario, nombre_usuario, imagen_usuario, clave_usuario, estado_usuario, id_empleado, id_tipo_usuario 
                  FROM usuarios 
                  WHERE id_usuario = ?";
        $params = array($this->user_id);
        return Database::getRow($query, $params);
    }

    //This function is to show the employees data, and could choose, any employee
    public function readEmployees()
    {
        $query = "SELECT id_empleado, nombre_empleado 
                  FROM empleados";
        return Database::getRows($query);
    }

    //This function is to show the types of users data, and could choose, any type of users
    public function readType_Users()
    {
        $query = "SELECT id_tipo_usuario,tipo_usuario 
                  FROM tipos_usuarios";
        return Database::getRows($query);
    }

    //This function is to search the users data, with parameters
    public function searchRows($value)
    {
        $query = "SELECT id_usuario, nombre_usuario, clave_usuario, estado_usuario, id_empleado, id_tipo_usuario 
                  FROM usuarios 
                  WHERE nombre_usuario 
                  ILIKE ? 
                  ORDER BY id_usuario";
        $params = array("%$value%");
        return Database::getRows($query, $params);
    }

    //This function is to create a new user with de respective data
    public function createRow()
    {
        $query = "INSERT INTO usuarios
                  (nombre_usuario,clave_usuario,imagen_usuario,estado_usuario,id_empleado,id_tipo_usuario,id_tema,id_idioma) 
                  VALUES(?,?,?,?,?,?,?,?)";
        $params = array($this->user_name, $this->user_password, $this->user_img, $this->user_status, $this->user_employee, $this->user_type, $this->theme = 1, $this->lenguage = 2);
        return Database::executeRow($query, $params);
    }

    //This function is to update the users data
    public function updateRow($current_image)
    {
        ($this->user_img) ? Validator::deleteFile($this->getRoute(), $current_image) : $this->user_img = $current_image;

        $query = "UPDATE usuarios 
                  SET nombre_usuario = ?, clave_usuario = ?, imagen_usuario = ?, estado_usuario = ?, id_empleado = ?, id_tipo_usuario = ? 
                  WHERE id_usuario = ?";
        $params = array($this->user_name, $this->user_password, $this->user_img, $this->user_status, $this->user_employee, $this->user_type, $this->user_id);
        return Database::executeRow($query, $params);
    }

    //This function is to delete the user data
    public function deleteRow()
    {
        $query = "DELETE 
                  FROM usuarios 
                  WHERE id_usuario = ?";
        $params = array($this->user_id);
        return Database::executeRow($query, $params);
    }

}