<?php
require_once('../../helpers/database.php');

class CategoryQueries{
    //Metodo para realizar una insercion
    public function createRow(){
        $sql='INSERT INTO categorias(nombre_categoria, descripcion_categoria) VALUES(?,?)';
        $params=array($this->nombre, $this->descripcion);
        return Database::executeRow($sql,$params);
    }
    public function searchRows($value){
        $sql='SELECT id_categoria, nombre_categoria, descripcion_categoria FROM categorias WHERE nombre_categoria ILIKE ? ORDER BY id_categoria';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
    public function readAll(){
        $sql='SELECT id_categoria, nombre_categoria, descripcion_categoria FROM categorias ORDER BY id_categoria';
        return Database::getRows($sql);
    }
    public function readOne(){
        $sql='SELECT id_categoria, nombre_categoria, descripcion_categoria FROM categorias WHERE id_categoria=?';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    public function updateRow(){
        $sql='UPDATE categorias SET nombre_categoria=?, descripcion_categoria=? WHERE id_categoria=?';
        $params=array($this->nombre, $this->descripcion, $this->id);
        return Database::executeRow($sql,$params);
    }
    public function deleteRow(){
        $sql='DELETE FROM categorias WHERE id_categoria=?';
        $params=array($this->id);
        return Database::executeRow($sql,$params);
    }
}