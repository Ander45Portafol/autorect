<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');
//Class create to controller all queries at the database
class ModelQueries{

    //This function is show all datas of the models is used to show data in the table
    public function readAll(){
        $query = "SELECT id_modelo, nombre_modelo, anio_modelo, id_marca 
                  FROM modelos 
                  ORDER BY id_modelo";
        return Database::getRows($query);
    }

    //This function is to catch one data, whit the identicator
    public function readOne(){
        $query = "SELECT id_modelo, nombre_modelo, anio_modelo, id_marca 
                  FROM modelos 
                  WHERE id_modelo = ?";
        $params=array($this->id);
        return Database::getRow($query,$params);
    }

    //This function is to show the brands data, and could choose, anybrand
    public function readBrand(){
        $query = "SELECT id_marca, nombre_marca 
                  FROM marcas";
        return Database::getRows($query);
    }

    //This function is to search the models data, with parameters
    public function searchRow($value)
    {
        $query = "SELECT id_modelo, nombre_modelo, anio_modelo, id_marca 
                  FROM modelos 
                  WHERE nombre_modelo 
                  ILIKE ? 
                  ORDER BY id_modelo";
        $params = array("%$value%");
        return Database::getRows($query, $params);
    }

    //This function is to create a new model  with de respective data
    public function createRow(){
        $query = "INSERT INTO modelos
                  (nombre_modelo,anio_modelo,id_marca) 
                  VALUES (?,?,?)";
        $params=array($this->nombre_modelo,$this->anio_modelo,$this->marca);
        return Database::executeRow($query,$params);
    }

    //This function is to update the models data
    public function updateRow(){
        $query = "UPDATE modelos 
                  SET nombre_modelo = ?, anio_modelo = ?, id_marca = ? 
                  WHERE id_modelo = ?";
        $params=array($this->nombre_modelo,$this->anio_modelo,$this->marca, $this->id);
        return Database::executeRow($query,$params);
    }

    //This function is to delete the model data
    public function deleteRow()
    {
        $query = "DELETE 
                  FROM modelos 
                  WHERE id_modelo = ?";
        $params = array($this->id);
        return Database::executeRow($query, $params);
    }
}