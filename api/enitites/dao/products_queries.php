<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');

//Class create to controller all queries at the database
class ProductQueries
{
    //This function is show all datas of the products is used to show data in the table
    public function readAll()
    {
        $query = "SELECT * 
                  FROM productos 
                  ORDER BY id_producto";
        return Database::getRows($query);
    }

    //This function is to show all datas of the products valorations
    public function readAllValorations()
    {
        $query = "SELECT c.nombre_producto, a.calificacion_producto,a.comentario,a.fecha_comentario,a.estado_comentario,a.id_valoracion 
                  FROM valoraciones a, detalles_pedidos b, productos c 
                  WHERE a.id_detalle_pedido = b.id_detalle_pedido 
                  AND b.id_producto = c.id_producto 
                  AND c.id_producto = ?";
        $params = array($this->id_producto);
        return Database::getRows($query, $params);
    }

    //This function is to catch one data, whit the identicator at the product
    public function readOne()
    {
        $query = "SELECT * 
                  FROM productos 
                  WHERE id_producto = ? 
                  ORDER BY id_producto";
        $params = array($this->id_producto);
        return Database::getRow($query, $params);
    }

    //This function is to catch one data, whit the identicator at the valoration
    public function readOneValoration()
    {
        $query = "SELECT * 
                  FROM valoraciones 
                  WHERE id_valoracion = ? 
                  ORDER BY id_valoracion";
        $params = array($this->id_valoracion);
        return Database::getRow($query, $params);
    }

    //This function is to show the status of the product data, and could choose, any status
    public function readStatusProduct()
    {
        $query = "SELECT * 
                  FROM estados_productos";
        return Database::getRows($query);
    }

    //This function is to change the status to product valoration
    public function FalseValoration()
    {
        $query = "UPDATE valoraciones 
                  SET estado_comentario = false 
                  WHERE id_valoracion = ?";
        $params = array($this->id_valoracion);
        return Database::executeRow($query, $params);
    }
    public function TrueValoration()
    {
        $query = "UPDATE valoraciones 
                  SET estado_comentario = true 
                  WHERE id_valoracion = ?";
        $params = array($this->id_valoracion);
        return Database::executeRow($query, $params);
    }

    //This function is to search the products data, with parameters
    public function searchRow($value)
    {
        $query = "SELECT * 
                  FROM productos 
                  WHERE nombre_producto 
                  ILIKE ? 
                  ORDER BY nombre_producto";
        $params = array("%$value%");
        return Database::getRows($query, $params);
    }

    //This function is to create a new product  with de respective data
    public function createRow()
    {
        $query = "INSERT INTO productos
                  (nombre_producto, descripcion_producto, precio_producto, imagen_principal,existencias, id_categoria, id_modelo, id_estado_producto) 
                  VALUES(?,?,?,?,?,?,?,?)";
        $params = array($this->nombre_producto, $this->descripcion, $this->precio, $this->imagen, $this->existencias, $this->categoria, $this->modelo, $this->estado_producto);
        return Database::executeRow($query, $params);
    }

    //This function is to update the products data
    public function updateRow($current_image)
    {
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $query = "UPDATE productos 
                  SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, imagen_principal = ?, existencias = ?, id_categoria = ?, id_modelo = ?, id_estado_producto = ? 
                  WHERE id_producto = ?";
        $params = array($this->nombre_producto, $this->descripcion, $this->precio, $this->imagen, $this->existencias, $this->categoria, $this->modelo, $this->estado_producto, $this->id_producto);
        return Database::executeRow($query, $params);
    }

    //This function is to delete the product data
    public function deleteRow()
    {
        $query = "DELETE 
                  FROM productos 
                  WHERE id_producto = ?";
        $params = array($this->id_producto);
        return Database::executeRow($query, $params);
    }
}