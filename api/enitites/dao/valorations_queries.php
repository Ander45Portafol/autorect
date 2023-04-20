<?php
require_once('../../helpers/database.php');
class Valorations_queries
{
    public function readAll()
    {
        $sql = 'SELECT * FROM valoraciones WHERE estado_comentario=true ORDER BY calificacion_producto DESC';
        return Database::getRows($sql);
    }
    public function readOne()
    {
        $sql = 'SELECT * FROM valoraciones WHERE id_valoracion=? ORDER BY calificacion_producto';
        $params = array($this->id_valoracion);
        return Database::getRow($sql, $params);
    }
    public function deleteRow(){
        $sql='UPDATE valoraciones SET estado_comentario=false WHERE id_valoracion=?';
        $params=array($this->id_valoracion);
        return Database::executeRow($sql,$params);
    }
    public function searchRow($value)
    {
        $sql='SELECT * FROM valoraciones WHERE id_detalle_pedido=? AND estado_comentario=true ORDER BY calificacion_producto';
        $params=array("$value");
        return Database::getRows($sql,$params);
    }
}
