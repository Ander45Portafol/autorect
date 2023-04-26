<?php
require_once('../../helpers/validator.php');
//Here are used the functions in the database file
require_once('../../helpers/database.php');

//Class create to controller all queries at the database
class CategoryQueries
{
    //This function is to create a new category  with de respective data
    public function createRow()
    {
        $sql = 'INSERT INTO categorias(imagen_categoria,nombre_categoria, descripcion_categoria) VALUES(?,?,?)';
        $params = array($this->imagen,$this->nombre, $this->descripcion);
        return Database::executeRow($sql, $params);
    }
    //This function is to search the categories data, with parameters
    public function searchRows($value)
    {
        $sql = 'SELECT id_categoria, nombre_categoria, descripcion_categoria FROM categorias WHERE nombre_categoria ILIKE ? ORDER BY id_categoria';
        $params = array("%$value%");
        return Database::getRows($sql, $params);
    }
    //This function is show all datas of the categories is used to show data in the table
    public function readAll()
    {
        $sql = 'SELECT id_categoria,nombre_categoria, descripcion_categoria,imagen_categoria FROM categorias ORDER BY id_categoria';
        return Database::getRows($sql);
    }
    //This function is to catch one data, whit the identicator
    public function readOne()
    {
        $sql = 'SELECT id_categoria,imagen_categoria,nombre_categoria, descripcion_categoria FROM categorias WHERE id_categoria=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    //This function is to update the categories data
    public function updateRow($current_image)
    {
        ($this->imagen)?Validator::deleteFile($this->getRuta(),$current_image):$this->imagen=$current_image;
        $sql = 'UPDATE categorias SET  imagen_categoria=?, nombre_categoria=?, descripcion_categoria=? WHERE id_categoria=?';
        $params = array($this->imagen,$this->nombre, $this->descripcion, $this->id);
        return Database::executeRow($sql, $params);
    }
    //This function is to delete the category data
    public function deleteRow()
    {
        $sql = 'DELETE FROM categorias WHERE id_categoria=?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
