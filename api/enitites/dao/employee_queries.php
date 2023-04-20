<?Php
require_once('../../helpers/database.php');

class EmployeeQueries
{

    public function readAll()
    {
        $query = 'SELECT *
                  FROM empleados
                  ORDER BY id_empleado';
        return Database::getRows($query);
    }

    public function readOne()
    {
        $query = 'SELECT * 
                  FROM empleados 
                  WHERE id_empleado=?';
        $params = array($this->employee_id);
        return Database::getRow($query, $params);
    }

    public function readTypes()
    {
        $query = 'SELECT * 
                  FROM tipos_empleados';
        return Database::getRows($query);
    }

    public function searchRows($value)
    {
        $sql = 'SELECT * 
                FROM empleados 
                WHERE nombre_empleado LIKE ? OR apellido_empleado LIKE ? OR correo_empleado LIKE ?, OR dui_empleado LIKE ?  
                ORDER BY id_empleado';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $query = 'INSERT INTO empleados (nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, nacimiento_empleado, direccion_empleado, estado_empleado, id_tipo_empleado) 
                  VALUES (?,?,?,?,?,?,?,?,?)';
        $params = array($this->employee_name, $this->employee_lastname, $this->employee_dui, $this->employee_mail, $this->employee_phone, $this->employee_date, $this->employee_address, $this->employee_status, $this->employee_type);
        return Database::executeRow($query, $params);
    }

    public function updateRow()
    {
        $query = 'UPDATE empleados 
                  SET nombre_empleado = ?, apellido_empleado = ?, dui_empleado = ?, correo_empleado = ?, telefono_empleado = ?, nacimiento_empleado = ?, direccion_empleado = ?, estado_empleado = ?, id_tipo_empleado = ?';
        $params = array($this->employee_name, $this->employee_lastname, $this->employee_dui, $this->employee_mail, $this->employee_phone, $this->employee_date, $this->employee_address, $this->employee_status, $this->employee_type, $this->employee_id);
        return Database::executeRow($query, $params);
    }

    public function deleteRow()
    {
        $query = 'DELETE 
                  FROM empleados 
                  WHERE id_empleado= ?';
        $params = array($this->employee_id);
        return Database::executeRow($query, $params);
    }
}