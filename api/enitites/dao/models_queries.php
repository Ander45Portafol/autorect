<?php
require_once('../../helpers/database.php');

class ModelsQueries{
    public function readAll(){
        $sql='SELECT id_modelo, nombre_modelo, anio_modelo, id_marca FROM modelos ORDER BY id_modelo';
        return Database::getRows($sql);
    }
    public function readOne(){
        $sql='SELECT id_modelo, nombre_modelo, anio_modelo, id_marca FROM modelos WHERE id_modelo=?';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function deleteRow(){
        $sql='DELETE FROM modelos WHERE id_modelo=?';
        $params=array($this->id);
        return Database::executeRow($sql,$params);
    }
    public function readBrand(){
        $sql='SELECT id_marca, nombre_marca FROM marcas';
        return Database::getRows($sql);
    }
    public function createRow(){
        $sql='INSERT INTO modelos(nombre_modelo,anio_modelo,id_marca) VALUES (?,?,?)';
        $params=array($this->nombre_modelo,$this->anio_modelo,$this->marca);
        return Database::executeRow($sql,$params);
    }
    public function updateRow(){
        $sql='UPDATE modelos SET nombre_modelo=?, anio_modelo=?, id_marca=? WHERE id_modelo=?';
        $params=array($this->nombre_modelo,$this->anio_modelo,$this->marca, $this->id);
        return Database::executeRow($sql,$params);
    }
}