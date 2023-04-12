<?php
require_once('../../helpers/database.php');
class Order_Detail_Queries{
    public function readAll(){
        $sql='SELECT a.id_detalle_pedido, a.cantidad_producto,a.precio_producto, a.id_pedido, b.nombre_producto FROM detalles_pedidos a, productos b WHERE a.id_producto=b.id_producto';
        return Database::getRows($sql);
    }
    public function searhRows($value){
        $sql='SELECT a.id_detalle_pedido, a.cantidad_producto,a.precio_producto, a.id_pedido, b.nombre_producto FROM detalles_pedidos a, productos b WHERE a.id_producto=b.id_producto AND b.nombre_producto ILIKE ?';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
}