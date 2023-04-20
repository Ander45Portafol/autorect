<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class create to controller all queries at the database
class ModelsQueries{
    //This function is show all datas of the models is used to show data in the table
    public function readAll(){
        $sql='SELECT id_modelo, nombre_modelo, anio_modelo, id_marca FROM modelos ORDER BY id_modelo';
        return Database::getRows($sql);
    }
    //This function is to catch one data, whit the identicator
    public function readOne(){
        $sql='SELECT id_modelo, nombre_modelo, anio_modelo, id_marca FROM modelos WHERE id_modelo=?';
        $params=array($this->id);
        return Database::getRow($sql,$params);
    }
    //This function is to delete the model data
    public function deleteRow(){
        $sql='DELETE FROM modelos WHERE id_modelo=?';
        $params=array($this->id);
        return Database::executeRow($sql,$params);
    }
    //This function is to show the brands data, and could choose, anybrand
    public function readBrand(){
        $sql='SELECT id_marca, nombre_marca FROM marcas';
        return Database::getRows($sql);
    }
    //This function is to create a new model  with de respective data
    public function createRow(){
        $sql='INSERT INTO modelos(nombre_modelo,anio_modelo,id_marca) VALUES (?,?,?)';
        $params=array($this->nombre_modelo,$this->anio_modelo,$this->marca);
        return Database::executeRow($sql,$params);
    }
    //This function is to update the models data
    public function updateRow(){
        $sql='UPDATE modelos SET nombre_modelo=?, anio_modelo=?, id_marca=? WHERE id_modelo=?';
        $params=array($this->nombre_modelo,$this->anio_modelo,$this->marca, $this->id);
        return Database::executeRow($sql,$params);
    }
    //This function is to search the models data, with parameters
    public function searchRow($value)
    {
        $sql='SELECT id_modelo, nombre_modelo, anio_modelo, id_marca FROM modelos WHERE nombre_modelo ILIKE ? ORDER BY id_modelo';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
}