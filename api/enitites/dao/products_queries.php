<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');

//Class create to controller all queries at the database
class Products_queries
{
        //This function is show all datas of the products is used to show data in the table
    public function readAll()
    {
        $sql = 'SELECT * FROM productos ORDER BY id_producto';
        return Database::getRows($sql);
    }
    //This function is to show all datas of the products valorations
    public function readAllValorations(){
        $sql='SELECT c.nombre_producto, a.calificacion_producto,a.comentario,a.fecha_comentario,a.estado_comentario,a.id_valoracion FROM valoraciones a, detalles_pedidos b, productos c WHERE a.id_detalle_pedido = b.id_detalle_pedido AND b.id_producto=c.id_producto AND estado_comentario=true AND c.id_producto = ?';
        $params=array($this->id_producto);
        return Database::getRows($sql,$params);
    }
    //This function is to catch one data, whit the identicator at the valoration
    public function readOneValoration(){
        $sql='SELECT * FROM valoraciones WHERE id_valoracion=? ORDER BY id_valoracion';
        $params=array($this->id_valoracion);
        return Database::getRow($sql,$params);
    }
        //This function is to catch one data, whit the identicator at the product
    public function readOne()
    {
        $sql = 'SELECT * FROM productos WHERE id_producto=? ORDER BY id_producto';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }
        //This function is to show the status of the product data, and could choose, any status
    public function readStatusProduct()
    {
        $sql = 'SELECT * from estados_productos';
        return Database::getRows($sql);
    }
        //This function is to search the products data, with parameters
    public function searchRow($value)
    {
        $sql='SELECT * FROM productos WHERE nombre_producto ILIKE ? ORDER BY nombre_producto';
        $params=array("%$value%");
        return Database::getRows($sql,$params);
    }
    //This function is to change the status to product valoration
    public function deleleteValoration(){
        $sql='UPDATE valoraciones SET estado_comentario=false where id_valoracion=?';
        $params=array($this->id_valoracion);
        return Database::executeRow($sql,$params);
    }
        //This function is to delete the product data
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos WHERE id_producto=?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }
        //This function is to create a new product  with de respective data
    public function createRow()
    {
        $sql = 'INSERT INTO productos(nombre_producto, descripcion_producto, precio_producto, imagen_principal,existencias, id_categoria, id_modelo, id_estado_producto) VALUES(?,?,?,?,?,?,?,?)';
        $params = array($this->nombre_producto, $this->descripcion, $this->precio, $this->imagen,$this->existencias, $this->categoria, $this->modelo, $this->estado_producto);
        return Database::executeRow($sql, $params);
    }
        //This function is to update the products data
    public function updateRow($current_image)
    {
        ($this->imagen)?Validator::deleteFile($this->getRuta(),$current_image):$this->imagen=$current_image;
        $sql = 'UPDATE productos SET nombre_producto=?, descripcion_producto=?,precio_producto=?,imagen_principal=?,existencias=?,id_categoria=?, id_modelo=?,id_estado_producto=? WHERE id_producto=?';
        $params = array($this->nombre_producto, $this->descripcion, $this->precio, $this->imagen,$this->existencias, $this->categoria, $this->modelo, $this->estado_producto, $this->id_producto);
        return Database::executeRow($sql, $params);
    }
    public function readImgs()
    {
        $sql = 'SELECT id_imagen_producto, nombre_archivo_imagen FROM imagenes_productos WHERE id_producto = ?;';
        $params = array($this->id_producto);
        return Database::getRows($sql, $params);
    }

    public function readOneImg(){
        $sql = 'SELECT id_imagen_producto, nombre_archivo_imagen FROM imagenes_productos WHERE id_imagen_producto = ?;';
        $params = array($this->id_imagen_producto);
        return Database::getRow($sql, $params);
    }

    public function createImg()
    {
        $sql = 'INSERT INTO imagenes_productos(nombre_archivo_imagen, id_producto) VALUES(?,?)';
        $params = array($this->imagen_s, $this->id_producto);
        return Database::getLastRow($sql, $params);
    }

    public function deleteImg(){
        $sql = 'DELETE FROM imagenes_productos WHERE id_imagen_producto = ?';
        $params = array($this->id_imagen_producto);
        return Database::executeRow($sql, $params);
    }
}
