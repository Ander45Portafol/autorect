<?php
require_once('../../helpers/database.php');

class OrderQueries
{
    //Method to fill the table
    public function readAll()
    {
        $query = "SELECT * 
                  FROM vista_pedidos";
        return Database::getRows($query);
    }

    //Method to see the data of a single row
    public function readOne()
    {
        $query = "SELECT * 
                  FROM pedidos 
                  WHERE id_pedido = ?";
        $params = array($this->order_id);
        return Database::getRow($query, $params);
    }

    //Method to see the data of a single row
    public function readOneDetail()
    {
        $query = "SELECT * 
                  FROM detalles_pedidos 
                  WHERE id_detalle_pedido = ?";
        $params = array($this->detail_id);
        return Database::getRow($query, $params);
    }

    //Method to fill the combobox
    public function readEstados()
    {
        $query = "SELECT id_estado_pedido, estado_pedido 
                  FROM estados_pedidos";
        return Database::getRows($query);
    }

    public function readClients()
    {
        $space = " ";
        $query = "SELECT id_cliente, CONCAT(nombre_cliente, '$space', apellido_cliente) 
                  AS nombre_completo_cliente 
                  FROM clientes";
        return Database::getRows($query);
    }

    public function readEmployees()
    {
        $space = " ";
        $query = "SELECT id_empleado, CONCAT(nombre_empleado, '$space', apellido_empleado) 
                  AS nombre_completo_empleado 
                  FROM empleados";
        return Database::getRows($query);
    }

    //Method to search on the table
    public function searchRows($value)
    {
        $query = "SELECT * 
                  FROM vista_pedidos 
                  WHERE CAST(id_pedido AS character varying(20)) = ? 
                  OR nombre_completo_cliente 
                  ILIKE ?";
        $params = array("$value", "%$value%");
        return Database::getRows($query, $params);
    }

    //Method to create an order
    public function createRow()
    {
        $query = "INSERT INTO pedidos
                  (direccion_pedido, fecha_pedido, id_cliente, id_estado_pedido, id_empleado) 
                  VALUES (?, ?, ?, ?, ?)";
        $params = array($this->order_address, $this->order_date, $this->client_id, $this->order_status_id, $this->employee_id);
        return Database::executeRow($query, $params);
    }

    //Method to update an order
    public function updateRow()
    {
        $query = "UPDATE pedidos 
                  SET direccion_pedido = ?, fecha_pedido = ?, id_cliente = ?, id_estado_pedido = ?, id_empleado = ? 
                  WHERE id_pedido = ?";
        $params = array($this->order_address, $this->order_date, $this->client_id, $this->order_status_id, $this->employee_id, $this->order_id);
        return Database::executeRow($query, $params);
    }

    //Method to delete an order
    public function deleteRow()
    {
        $query = "DELETE FROM pedidos 
                  WHERE id_pedido = ?";
        $params = array($this->order_id);
        return Database::executeRow($query, $params);
    }
    //Method to delete an order detail
    public function deleteDetailRow()
    {
        $query = "DELETE 
                  FROM detalles_pedidos 
                  WHERE id_detalle_pedido = ?";
        $params = array($this->detail_id);
        return Database::executeRow($query, $params);
    }
    public function readAllDetail()
    {
        $query = "SELECT a.id_detalle_pedido,c.imagen_principal,c.nombre_producto,b.direccion_pedido,b.fecha_pedido,c.precio_producto, a.precio_producto 
                  AS precio_total 
                  FROM detalles_pedidos a, pedidos b, productos c 
                  WHERE  a.id_pedido = b.id_pedido 
                  AND a.id_producto = c.id_producto 
                  AND a.id_pedido = ?";
        $params = array($this->order_id);
        return Database::getRows($query, $params);
    }
}