<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class create to controller all queries at the database
class Valorations_queries
{
    //This function is show all datas of the valorations is used to show data in the table
    public function readAll()
    {
        $query = 'SELECT * 
                  FROM valoraciones 
                  WHERE estado_comentario = true 
                  ORDER BY calificacion_producto 
                  DESC';
        return Database::getRows($query);
    }

    //This function is to catch one data, whit the identicator
    public function readOne()
    {
        $query = 'SELECT * 
                  FROM valoraciones 
                  WHERE id_valoracion = ? 
                  ORDER BY calificacion_producto';
        $params = array($this->id_valoracion);
        return Database::getRow($query, $params);
    }

    //This function is to search the valorations data, with parameters
    public function searchRow($value)
    {
        $query = 'SELECT * 
                  FROM valoraciones 
                  WHERE id_detalle_pedido = ? 
                  AND estado_comentario = true 
                  ORDER BY calificacion_producto';
        $params = array("$value");
        return Database::getRows($query, $params);
    }

    //This function is to delete the valorations data
    public function deleteRow()
    {
        $query = 'UPDATE valoraciones 
                  SET estado_comentario = false 
                  WHERE id_valoracion = ?';
        $params = array($this->id_valoracion);
        return Database::executeRow($query, $params);
    }
}