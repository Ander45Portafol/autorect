<?php
//Here are used the functions in the database file
require_once('../../helpers/database.php');

//Class to control all queries at the database
class ProductQueries
{
    //This function is show all datas of the products is used to show data in the table
    public function readAll()
    {
        $query = "SELECT a.id_producto, a.imagen_principal,a.nombre_producto,a.precio_producto,a.descripcion_producto, b.estado_producto, a.id_categoria
                  FROM productos a
                  INNER JOIN estados_productos b
                  USING(id_estado_producto)
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
        $params = array($this->product_id);
        return Database::getRows($query, $params);
    }

    //This function is to show the 10 most selled products 
    public function readTop10()
    {
        $query = "SELECT pr.id_producto, pr.nombre_producto, pr.descripcion_producto, pr.precio_producto, pr.imagen_principal, pr.id_categoria, COUNT(dp.id_producto) as num
        FROM detalles_pedidos as dp
        INNER JOIN productos as pr
        ON dp.id_producto = pr.id_producto
        GROUP BY pr.id_producto, pr.nombre_producto, pr.descripcion_producto, pr.precio_producto, pr.imagen_principal
        ORDER BY num DESC LIMIT 10";
        return Database::getRows($query);
    }

    //This function is to catch one data with the identicator at the product
    public function readOne()
    {
        $query = "SELECT a.id_producto, a.imagen_principal,a.nombre_producto,a.precio_producto,a.descripcion_producto, b.estado_producto, a.id_categoria, c.nombre_categoria,d.nombre_modelo, a.existencias, a.id_modelo, a.id_estado_producto
                  FROM productos a
                  INNER JOIN estados_productos b
                  USING(id_estado_producto)
                  INNER JOIN categorias c
				  USING (id_categoria)
                  INNER JOIN modelos d
                  USING (id_modelo)
                  WHERE id_producto = ? 
                  ORDER BY id_producto";
        $params = array($this->product_id);
        return Database::getRow($query, $params);
    }

    //This function is to catch one data with the identicator at the valoration
    public function readOneValoration()
    {
        $query = "SELECT * 
                  FROM valoraciones 
                  WHERE id_valoracion = ? 
                  ORDER BY id_valoracion";
        $params = array($this->valoration_id);
        return Database::getRow($query, $params);
    }

    //This function is to show the status of the product data, and could choose any status
    public function readStatusProduct()
    {
        $query = "SELECT * 
                  FROM estados_productos";
        return Database::getRows($query);
    }

    //These functions is to change the status to product valoration
    public function FalseValoration()
    {
        $query = "UPDATE valoraciones 
                  SET estado_comentario = false 
                  WHERE id_valoracion = ?";
        $params = array($this->valoration_id);
        return Database::executeRow($query, $params);
    }
    public function TrueValoration()
    {
        $query = "UPDATE valoraciones 
                  SET estado_comentario = true 
                  WHERE id_valoracion = ?";
        $params = array($this->valoration_id);
        return Database::executeRow($query, $params);
    }

    //This function is to search the products data with parameters
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

    //This function is to create a new product with the respective data
    public function createRow()
    {
        $query = "INSERT INTO productos
                  (nombre_producto, descripcion_producto, precio_producto, imagen_principal,existencias, id_categoria, id_modelo, id_estado_producto) 
                  VALUES(?,?,?,?,?,?,?,?)";
        $params = array($this->product_name, $this->product_description, $this->product_price, $this->product_img, $this->product_stock, $this->product_category, $this->product_model, $this->product_status);
        return Database::executeRow($query, $params);
    }

    //This function is to update the products data
    public function updateRow($current_image)
    {
        ($this->product_img) ? Validator::deleteFile($this->getRoute(), $current_image) : $this->product_img = $current_image;

        $query = "UPDATE productos 
                  SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, imagen_principal = ?, existencias = ?, id_categoria = ?, id_modelo = ?, id_estado_producto = ? 
                  WHERE id_producto = ?";
        $params = array($this->product_name, $this->product_description, $this->product_price, $this->product_img, $this->product_stock, $this->product_category, $this->product_model, $this->product_status, $this->product_id);
        return Database::executeRow($query, $params);
    }

    //This function is to delete the product data
    public function deleteRow()
    {
        $query = "DELETE 
                  FROM productos 
                  WHERE id_producto = ?";
        $params = array($this->product_id);
        return Database::executeRow($query, $params);
    }

    //Function to read the products 
    public function readImgs()
    {
        $sql = 'SELECT id_imagen_producto, nombre_archivo_imagen FROM imagenes_productos WHERE id_producto = ?;';
        $params = array($this->product_id);
        return Database::getRows($sql, $params);
    }

    //Function to read one image
    public function readOneImg()
    {
        $sql = 'SELECT id_imagen_producto, nombre_archivo_imagen FROM imagenes_productos WHERE id_imagen_producto = ?;';
        $params = array($this->product_img_id);
        return Database::getRow($sql, $params);
    }

    //Function to create an image asociated with a product
    public function createImg()
    {
        $sql = 'INSERT INTO imagenes_productos(nombre_archivo_imagen, id_producto) VALUES(?,?)';
        $params = array($this->s_img, $this->product_id);
        return Database::getLastRow($sql, $params);
    }

    //Function to delete an image
    public function deleteImg()
    {
        $sql = 'DELETE FROM imagenes_productos WHERE id_imagen_producto = ?';
        $params = array($this->product_img_id);
        return Database::executeRow($sql, $params);
    }

    //Function to load the related products
    public function productsRelated()
    {
        $query = "SELECT pr.id_producto, pr.imagen_principal,pr.nombre_producto,pr.precio_producto,pr.descripcion_producto, ep.estado_producto,
        CASE
            WHEN AVG(va.calificacion_producto) IS NOT NULL THEN ROUND(AVG(va.calificacion_producto), 1)
            ELSE 0.0
        END AS calificacion
        FROM productos pr
        INNER JOIN estados_productos ep ON pr.id_estado_producto = ep.id_estado_producto
        LEFT JOIN detalles_pedidos dp ON pr.id_producto = dp.id_producto
        LEFT JOIN valoraciones va ON va.id_detalle_pedido = dp.id_detalle_pedido AND va.estado_comentario = true
        WHERE pr.id_categoria = ? AND pr.id_producto != ?
        GROUP BY pr.id_producto, pr.imagen_principal,pr.nombre_producto,pr.precio_producto,pr.descripcion_producto, ep.estado_producto
        ORDER BY id_producto limit 4";
        $params = array($this->product_category, $this->product_id);
        return Database::getRows($query, $params);
    }

    //Function to load the reviews
    public function productsReview()
    {
        $query = "SELECT a.calificacion_producto, a.comentario, a.fecha_comentario, a.estado_comentario, CONCAT(d.nombre_cliente,' ',d.apellido_cliente) AS client_name
        FROM valoraciones a
        INNER JOIN detalles_pedidos b
        USING(id_detalle_pedido)
        INNER JOIN pedidos c
        USING (id_pedido)
        INNER JOIN clientes d
        USING (id_cliente)
        INNER JOIN productos e
        USING (id_producto)
        WHERE e.id_producto=? AND a.estado_comentario=true";
        $params = array($this->product_id);
        return Database::getRows($query, $params);
    }

    //Function to load the product history.
    public function productHistory()
    {
        $query = "SELECT b.nombre_producto,a.id_detalle_pedido, b.imagen_principal,a.cantidad_producto,a.precio_producto, c.id_estado_pedido, d.estado_pedido,b.descripcion_producto from detalles_pedidos a INNER JOIN productos b using (id_producto)
        INNER JOIN pedidos c USING (id_pedido) INNER JOIN estados_pedidos d USING (id_estado_pedido) WHERE id_cliente=? AND id_pedido=?
        ORDER BY id_detalle_pedido";
        $params = array($this->client_id,$this->order_id);
        return Database::getRows($query, $params);
    }
    public function orderHistory(){
        $query='SELECT a.fecha_pedido,a.id_cliente,a.id_pedido,c.estado_pedido,a.direccion_pedido FROM pedidos a INNER JOIN estados_pedidos c USING (id_estado_pedido) WHERE id_cliente=?';
        $params=array($this->client_id);
        return Database::getRows($query,$params);
    }

    public function cantidadUsuarios()
    {
        $sql = 'SELECT tipo_usuario, COUNT(id_usuario) usuario
        FROM usuarios
        INNER JOIN tipos_usuarios USING(id_tipo_usuario)
        GROUP BY tipo_usuario ORDER BY usuario DESC';
        return Database::getRows($sql);
    }
    public function cantidadModelosMarcas(){
        $sql='SELECT ma.nombre_marca,COUNT(mo.id_modelo) modelo
        FROM marcas as ma
        INNER JOIN modelos as mo
        ON mo.id_marca = ma.id_marca
        GROUP BY ma.nombre_marca
        ORDER BY modelo DESC LIMIT 7';
        return Database::getRows($sql);
    }
    public function porcentajesPedidos()
    {
        $sql = 'SELECT estado_pedido, ROUND((COUNT(id_pedido)*100.0/(SELECT COUNT(id_pedido) FROM pedidos)),2) porcentaje
        FROM detalles_pedidos
        INNER JOIN pedidos USING (id_pedido)
        INNER JOIN estados_pedidos USING (id_estado_pedido)
        GROUP BY estado_pedido ORDER BY porcentaje DESC';
        return Database::getRows($sql);
    }
    public function porcentajesClientes()
    {
        $sql = 'SELECT estado_cliente, ROUND((COUNT(id_cliente)*100.0/(SELECT COUNT(id_cliente) FROM clientes)),2)as porcentaje
        FROM clientes
        GROUP BY estado_cliente';
        return Database::getRows($sql);
    }
    public function fechasPedidos()
    {
        $sql = "SELECT fecha_pedido, COUNT(id_pedido) as n_pedidos
        FROM pedidos
        WHERE fecha_pedido >= DATE_TRUNC('week', CURRENT_DATE)
          AND fecha_pedido < DATE_TRUNC('week', CURRENT_DATE) + INTERVAL '1 week' AND id_estado_pedido=4
        GROUP BY fecha_pedido ORDER BY n_pedidos DESC";
        return Database::getRows($sql);
    }
    //Function to validate comments
    public function validateComments(){
        $query="SELECT c.nombre_producto,a.comentario from valoraciones a INNER JOIN detalles_pedidos b using (id_detalle_pedido) INNER JOIN productos c using (id_producto)
        INNER JOIN pedidos d using(id_pedido) where id_detalle_pedido=?";
        $params=array($this->detail_id);
        return Database::getRow($query,$params);
    }
    /*Filters*/

    public function categoriesFilter()
    {
        $query = "SELECT ct.id_categoria, ct.nombre_categoria, COUNT(pr.id_categoria) AS num
        FROM productos AS pr
        INNER JOIN categorias AS ct ON pr.id_categoria = ct.id_categoria
        GROUP BY ct.id_categoria, ct.nombre_categoria";
        return Database::getRows($query);
    }

    public function priceFilter()
    {
        $query = "SELECT CAST( MAX(precio_producto) AS integer) as maxi
        FROM productos";
        return Database::getRows($query);
    }

    public function yearsFilter()
    {
        $query = "SELECT anio, SUM(cantidad_modelos) AS num
        FROM (
          SELECT mo.anio_inicial_modelo AS anio, COUNT(pr.id_modelo) AS cantidad_modelos, 1 AS orden
          FROM productos AS pr
          INNER JOIN modelos AS mo ON pr.id_modelo = mo.id_modelo
          GROUP BY mo.anio_inicial_modelo
          UNION ALL
          SELECT mo.anio_final_modelo AS anio, COUNT(pr.id_modelo) AS cantidad_modelos, 2 AS orden
          FROM productos AS pr
          INNER JOIN modelos AS mo ON pr.id_modelo = mo.id_modelo
          GROUP BY mo.anio_final_modelo
        ) AS subconsulta
        GROUP BY anio, orden
        ORDER BY orden ASC, anio ASC;";
        return Database::getRows($query);
    }

    public function filterSearch()
    {
        $query = "SELECT pr.id_producto, pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria,
        CASE
            WHEN AVG(va.calificacion_producto) IS NOT NULL THEN ROUND(AVG(va.calificacion_producto), 1)
            ELSE 0.0
        END AS calificacion
        FROM productos as pr
        INNER JOIN estados_productos as ep
            ON pr.id_estado_producto = ep.id_estado_producto
        INNER JOIN modelos as mo
            ON pr.id_modelo = mo.id_modelo
        LEFT JOIN detalles_pedidos dp ON pr.id_producto = dp.id_producto
        LEFT JOIN valoraciones va ON va.id_detalle_pedido = dp.id_detalle_pedido AND va.estado_comentario = true
        WHERE 1=1";

        $query2 = " GROUP BY pr.id_producto, pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria";        

        $params = array();

        if (!empty($this->product_category)) {
            $query .= " AND pr.id_categoria = ?";
            $params[] = $this->product_category;
        }

        if (!empty($this->product_price) && $this->product_price != 0) {
            $query .= " AND CAST(pr.precio_producto as integer) BETWEEN ? AND (SELECT MAX(precio_producto) FROM productos)";
            $params[] = $this->product_price;
        }

        if (!empty($this->model_year)) {
            $query .= " AND (mo.anio_inicial_modelo = ? OR mo.anio_final_modelo = ?)";
            ;
            $params[] = $this->model_year;
            $params[] = $this->model_year;
        }

        $query = $query.$query2;
        return Database::getRows($query, $params);
    }


    //Function to colect all the data of the product
    public function readAllPublic()
    {
        $query = "SELECT pr.id_producto, pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria,
        CASE
            WHEN AVG(va.calificacion_producto) IS NOT NULL THEN ROUND(AVG(va.calificacion_producto), 1)
            ELSE 0.0
        END AS calificacion
        FROM productos pr
        INNER JOIN estados_productos ep ON pr.id_estado_producto = ep.id_estado_producto
        LEFT JOIN detalles_pedidos dp ON pr.id_producto = dp.id_producto
        LEFT JOIN valoraciones va ON va.id_detalle_pedido = dp.id_detalle_pedido AND va.estado_comentario = true
        GROUP BY pr.id_producto, pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria
        ORDER BY pr.id_producto;";
        return Database::getRows($query);
    }

    //Function to search the products
    public function searchPublic($value)
    {
        $query = "SELECT pr.id_producto, pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria,
            CASE
                WHEN AVG(va.calificacion_producto) IS NOT NULL THEN ROUND(AVG(va.calificacion_producto), 1)
                ELSE 0.0
            END AS calificacion
        FROM productos pr
        INNER JOIN estados_productos ep ON pr.id_estado_producto = ep.id_estado_producto
        LEFT JOIN detalles_pedidos dp ON pr.id_producto = dp.id_producto
        LEFT JOIN valoraciones va ON va.id_detalle_pedido = dp.id_detalle_pedido AND va.estado_comentario = true
        WHERE pr.nombre_producto ILIKE ?
        GROUP BY pr.id_producto, pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria
        ORDER BY pr.id_producto";
        $params = array("%$value%");
        return Database::getRows($query, $params);
    }

    //Function to read the imgs of the products
    public function readProductImgsPublic(){
        $query="SELECT nombre_archivo_imagen 
        FROM imagenes_productos
        WHERE id_producto = ?;";
        $params = array($this->product_id);
        return Database::getRows($query, $params);
    }

    //This function is to catch one data with the identicator at the product
    public function readOnePublic()
    {
        $query = "SELECT pr.id_producto, pr.existencias,pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria, mo.nombre_modelo, pr.existencias, pr.id_modelo, ca.nombre_categoria, pr.id_estado_producto, COUNT(va.id_valoracion) as valo,
        CASE
            WHEN AVG(va.calificacion_producto) IS NOT NULL THEN ROUND(AVG(va.calificacion_producto), 1)
            ELSE 0.0
        END AS calificacion
        FROM productos pr
        INNER JOIN estados_productos ep ON pr.id_estado_producto = ep.id_estado_producto
        LEFT JOIN detalles_pedidos dp ON pr.id_producto = dp.id_producto
        LEFT JOIN valoraciones va ON va.id_detalle_pedido = dp.id_detalle_pedido AND va.estado_comentario = true
        INNER JOIN modelos mo ON pr.id_modelo = mo.id_modelo
        INNER JOIN categorias ca ON pr.id_categoria = ca.id_categoria
        WHERE pr.id_producto = ?
        GROUP BY pr.id_producto, pr.imagen_principal, pr.nombre_producto, pr.precio_producto, pr.descripcion_producto, ep.estado_producto, pr.id_categoria, mo.nombre_modelo, pr.existencias, pr.id_modelo, ca.nombre_categoria, pr.id_estado_producto
        ORDER BY pr.id_producto";
        $params = array($this->product_id);
        return Database::getRow($query, $params);
    }

    //Function to delete comments
    public function deleteComments(){
        $query="DELETE FROM valoraciones WHERE id_detalle_pedido=?";
        $params=array($this->detail_id);
        return Database::executeRow($query,$params);
    }

    //Function to create a comment
    public function createComment(){
        $date=date("d-m-Y");
        $comment_status='true';
        $query="INSERT INTO valoraciones (calificacion_producto, comentario, fecha_comentario, estado_comentario,id_detalle_pedido)
        VALUES(?,?,?,?,?)";
        $params=array($this->quantity,$this->comments,$date,$comment_status,$this->detail_id);
        return Database::executeRow($query,$params);
    }
    //functions to make reports
    public function productsReport(){
        $query="SELECT a.id_producto, a.imagen_principal,a.nombre_producto,a.precio_producto,a.descripcion_producto, b.nombre_categoria, c.estado_producto
        FROM productos a
        INNER JOIN categorias b
         USING(id_categoria)
        INNER JOIN estados_productos c
        USING (id_estado_producto)
        WHERE id_categoria=?
        ORDER BY id_producto";
        $params=array($this->product_category);
        return Database::getRows($query,$params);
    }
}