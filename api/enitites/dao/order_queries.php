<?php
require_once('../../helpers/database.php');

class OrderQueries{
    //Method to fill the table
    public function readAll(){
        $sql='SELECT * FROM vista_pedidos';
        return Database::getRows($sql);
    }

    //Method to search on the table
    public function searchRows($value){
        $sql='SELECT * FROM vista_pedidos WHERE CAST(id_pedido as character varying(20)) = ? OR nombre_completo_cliente ILIKE ?';
        $params=array("$value", "%$value%");
        return Database::getRows($sql,$params);
    }

    //Method to see the data of a single row
    public function readOne(){
        $sql='SELECT * FROM pedidos WHERE id_pedido=?';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }

        //Method to see the data of a single row
        public function readOneDetail(){
            $sql='SELECT * FROM detalles_pedidos WHERE id_detalle_pedido=?';
            $params=array($this->id_Detalle);
            return Database::getRow($sql,$params);
        }

    //Method to fill the combobox
    public function readEstados(){
        $sql = "SELECT id_estado_pedido, estado_pedido FROM estados_pedidos";
        return Database::getRows($sql);
    }

    public function readClients(){
        $space = " ";
        $sql = "SELECT id_cliente, CONCAT(nombre_cliente, '$space', apellido_cliente) as nombre_completo_cliente FROM clientes";
        return Database::getRows($sql);
    }

    public function readEmployees(){
        $space = " ";
        $sql = "SELECT id_empleado, CONCAT(nombre_empleado, '$space', apellido_empleado) as nombre_completo_empleado FROM empleados";
        return Database::getRows($sql);
    }

    //Method to create an order
    public function createRow(){
        $sql='INSERT INTO pedidos(direccion_pedido, fecha_pedido, id_cliente, id_estado_pedido, id_empleado) VALUES (?, ?, ?, ?, ?)';
        $params=array($this->direccion,$this->fecha, $this->id_cliente, $this->id_estado_pedido ,$this->id_empleado);
        return Database::executeRow($sql,$params);
    }

    //Method to update an order
    public function updateRow(){
        $sql='UPDATE pedidos SET direccion_pedido=?, fecha_pedido=?, id_cliente=?, id_estado_pedido=?, id_empleado=? WHERE id_pedido = ?';
        $params=array($this->direccion,$this->fecha, $this->id_cliente, $this->id_estado_pedido,$this->id_empleado,$this->id);
        return Database::executeRow($sql,$params);
    }

    //Method to delete an order
    public function deleteRow(){
        $sql='DELETE FROM pedidos WHERE id_pedido=?';
        $params=array($this->id);
        return Database::executeRow($sql,$params);
    }
       //Method to delete an order detail
       public function deleteDetailRow(){
        $sql='DELETE FROM detalles_pedidos WHERE id_detalle_pedido=?';
        $params=array($this->id_Detalle);
        return Database::executeRow($sql,$params);
    }
    public function readAllDetail(){
        $sql='SELECT a.id_detalle_pedido,c.imagen_principal,c.nombre_producto,b.direccion_pedido,b.fecha_pedido,c.precio_producto, a.precio_producto AS precio_total FROM detalles_pedidos a, pedidos b, productos c WHERE  a.id_pedido=b.id_pedido AND a.id_producto=c.id_producto AND a.id_pedido=?';
        $params=array($this->id);
        return Database::getRows($sql,$params);
    }
}
