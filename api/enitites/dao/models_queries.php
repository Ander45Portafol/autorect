<?php
require_once('../../helpers/database.php');

class ModelQueries{
    //metodo de busqueda para registros, devuelve modelos segun parametrizacion.
    public function searchRows($value){
        $sql = 'SELECT id_modelo, nombre_modelo, anio_modelo, id_marca 
                FROM modelos 
                WHERE nombre_modelo ILIKE ? OR anio_modelo ILIKE ?
                ORDER BY nombre_modelo';
        $params = array("%$value%", "%$value%");
        return Database::getRow($sql, $params);
    }

    public function createRow(){
        $sql = 'INSERT INTO modelos(nombre_modelo, anio_modelo, id_marca)
                VALUES(?,?,?)';
        $params = array($this->name, $this->year, $this->brand_id, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readAll(){
        $sql = 'SELECT id_modelo, nombre_modelo, anio_modelo, id_marca
                FROM modelos
                ORDER BY nombre_modelo';
        return Database::getRow($sql);
    }

    public function readOne(){
        $sql = 'SELECT id_modelo, nombre_modelo, anio_modelo, id_marca
                FROM modelos
                WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow(){
        $sql = 'UPDATE modelos
                SET nombre_modelo = ?, anio_modelo = ?, id_marca = ?
                WHERE id_modelo = ?';
        $params = array($this->name, $this->year, $this->brand_id, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow(){
        $sql = 'DELETE FROM modelos
                WHERE id_modelo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}