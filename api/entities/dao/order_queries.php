<?php
require_once('../../helpers/database.php');

class OrderQueries
{
    //Function to fill the table
    public function readAll()
    {
        $query = "SELECT * 
                  FROM vista_pedidos";
        return Database::getRows($query);
    }

    //Function to see the data of a single row
    public function readOne()
    {
        $query = "SELECT * 
                  FROM pedidos 
                  WHERE id_pedido = ?";
        $params = array($this->order_id);
        return Database::getRow($query, $params);
    }

    //Function to see the data of a single row
    public function readOneDetail()
    {
        $query = "SELECT * 
                  FROM detalles_pedidos 
                  WHERE id_detalle_pedido = ?";
        $params = array($this->detail_id);
        return Database::getRow($query, $params);
    }

    //Functions to fill the combobox
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

    //Function to search on the table
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

    //Function to create an order
    public function createRow()
    {
        $query = "INSERT INTO pedidos
                  (direccion_pedido, fecha_pedido, id_cliente, id_estado_pedido, id_empleado) 
                  VALUES (?, ?, ?, ?, ?)";
        $params = array($this->order_address, $this->order_date, $this->client_id, $this->order_status_id, $this->employee_id);
        return Database::executeRow($query, $params);
    }

    //Function to update an order
    public function updateRow()
    {
        $query = "UPDATE pedidos 
                  SET direccion_pedido = ?, fecha_pedido = ?, id_cliente = ?, id_estado_pedido = ?, id_empleado = ? 
                  WHERE id_pedido = ?";
        $params = array($this->order_address, $this->order_date, $this->client_id, $this->order_status_id, $this->employee_id, $this->order_id);
        return Database::executeRow($query, $params);
    }

    //Function to delete an order
    public function deleteRow()
    {
        $query = "DELETE FROM pedidos 
                  WHERE id_pedido = ?";
        $params = array($this->order_id);
        return Database::executeRow($query, $params);
    }
    //Function to delete an order detail
    public function deleteDetailRow()
    {
        $query = "DELETE 
                  FROM detalles_pedidos 
                  WHERE id_detalle_pedido = ?";
        $params = array($this->detail_id);
        return Database::executeRow($query, $params);
    }

    //Function to read the details per order
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
    public function startOrder()
    {
        $query = "SELECT id_pedido FROM pedidos WHERE id_estado_pedido=1 AND id_cliente=?";
        $params = array($_SESSION['id_cliente']);
        if ($data = Database::getRow($query, $params)) {
            $this->order_id = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedidos(fecha_pedido,id_estado_pedido, id_cliente)
            VALUES(?, ?,?)';
            date_default_timezone_set('America/El_Salvador');
            $params = array($this->order_date=date("d-m-Y"),$this->order_status_id=1, $_SESSION['id_cliente']);
            if ($this->order_id = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return Database::getException();
            }
        }
    }
    public function createDetail(){
        $query="INSERT INTO detalles_pedidos(cantidad_producto,precio_producto,id_pedido,id_producto) values (?,(SELECT precio_producto FROM productos WHERE id_producto = ?),?,?)";
        $params=array($this->quantity_product,$this->id_product,$this->order_id,$this->id_product);
        return Database::executeRow($query,$params);
    }
    public function readOrderDetail()
    {
        $query = 'SELECT b.id_detalle_pedido,a.id_pedido, c.nombre_producto ,b.precio_producto, b.cantidad_producto,c.imagen_principal,c.descripcion_producto,c.existencias
        FROM pedidos a INNER JOIN detalles_pedidos b USING(id_pedido) INNER JOIN productos c USING(id_producto)
        WHERE id_pedido = ? AND id_estado_pedido=1';
        $params = array($this->order_id);
        return Database::getRows($query, $params);
    }
    public function deleteOrderDetail(){
        $query='DELETE FROM detalles_pedidos WHERE id_detalle_pedido=?';
        $params=array($this->detail_id);
        return Database::executeRow($query,$params);
    }
    public function confirmOrder(){
        $query="SELECT direccion_pedido FROM pedidos WHERE id_cliente=?";
        $params=array($this->client_id);
        return Database::getRow($query,$params);
    }
    public function updateOrder(){
        $query="UPDATE pedidos SET id_estado_pedido=4 WHERE id_cliente=?";
        $params=array($this->client_id);
        return Database::executeRow($query,$params);
    }
    public function subtractDetail(){
        $quantitysubtract=$this->quantity_product-1;
        $query='UPDATE detalles_pedidos SET cantidad_producto=? WHERE id_detalle_pedido=?';
        $params=array($quantitysubtract,$this->detail_id);
        return Database::executeRow($query,$params);
    }
    public function addDetail(){
        $quantitysubtract=$this->quantity_product+1;
        $query='UPDATE detalles_pedidos SET cantidad_producto=? WHERE id_detalle_pedido=?';
        $params=array($quantitysubtract,$this->detail_id);
        return Database::executeRow($query,$params);
    }

    public function readUpdatedStock(){
        $query="SELECT pr.existencias 
        FROM detalles_pedidos dp
        INNER JOIN productos pr
        ON dp.id_producto = pr.id_producto
        WHERE dp.id_detalle_pedido = ?;";
        $params=array($this->detail_id);
        return Database::getRow($query, $params);
    }
}
