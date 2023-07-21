<?Php
//Dependencies
require_once('../../helpers/database.php');

class EmployeeQueries
{
    //Function to fill the table 
    public function readAll()
    {
        $query = "SELECT a.id_empleado,a.nombre_empleado,a.apellido_empleado,a.dui_empleado,a.correo_empleado,a.telefono_empleado,a.estado_empleado,b.tipo_empleado
                  FROM empleados a
                  INNER JOIN tipos_empleados b
                  USING(id_tipo_empleado)
                  ORDER BY id_empleado";
        return Database::getRows($query);
    }

    //Function to read the data of one employee
    public function readOne()
    {
        $query = "SELECT * 
                  FROM empleados 
                  WHERE id_empleado = ?";
        $params = array($this->employee_id);
        return Database::getRow($query, $params);
    }

    //Function to read the types of employee
    public function readTypes()
    {
        $query = "SELECT * 
                  FROM tipos_empleados";
        return Database::getRows($query);
    }

    //Function to search employees
    public function searchRows($value)
    {
        $query = "SELECT * 
                  FROM empleados 
                  WHERE nombre_empleado 
                  ILIKE ? 
                  OR apellido_empleado 
                  ILIKE ? 
                  OR correo_empleado ILIKE ? 
                  OR dui_empleado 
                  ILIKE ?  
                  ORDER BY id_empleado";
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($query, $params);
    }

    //Function to create a employee
    public function createRow()
    {
        $query = "INSERT INTO empleados 
                  (nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, telefono_empleado, nacimiento_empleado, direccion_empleado, estado_empleado, id_tipo_empleado) 
                  VALUES (?,?,?,?,?,?,?,?,?)";
        $params = array($this->employee_name, $this->employee_lastname, $this->employee_dui, $this->employee_mail, $this->employee_phone, $this->employee_date, $this->employee_address, $this->employee_status, $this->employee_type);
        return Database::executeRow($query, $params);
    }

    //Function to update a employee
    public function updateRow()
    {
        $query = "UPDATE empleados 
                  SET nombre_empleado = ?, apellido_empleado = ?, dui_empleado = ?, correo_empleado = ?, telefono_empleado = ?, nacimiento_empleado = ?, direccion_empleado = ?, estado_empleado = ?, id_tipo_empleado = ?
                  WHERE id_empleado = ?";
        $params = array($this->employee_name, $this->employee_lastname, $this->employee_dui, $this->employee_mail, $this->employee_phone, $this->employee_date, $this->employee_address, $this->employee_status, $this->employee_type, $this->employee_id);
        return Database::executeRow($query, $params);
    }

    //Function to delete a employee
    public function deleteRow()
    {
        $query = "DELETE 
                  FROM empleados 
                  WHERE id_empleado = ?";
        $params = array($this->employee_id);
        return Database::executeRow($query, $params);
    }
    //Functions to use at reports
    public function readAllEmployeeType(){
        $query="SELECT id_tipo_empleado, tipo_empleado FROM tipos_empleados";
        return Database::getRows($query);
    }
    public function reportEmployeeType(){
        $query="	SELECT CONCAT(a.nombre_empleado,' ',a.apellido_empleado) as nombre_completo_empleado,a.telefono_empleado, b.tipo_empleado,a.correo_empleado, a.dui_empleado
        FROM empleados a
        INNER JOIN tipos_empleados b
        USING (id_tipo_empleado)
        WHERE id_tipo_empleado=? AND a.estado_empleado=true";
        $params=array($this->employee_type);
        return Database::getRows($query,$params);
    }
}