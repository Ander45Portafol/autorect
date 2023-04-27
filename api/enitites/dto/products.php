<?php
require_once('../../helpers/validator.php');
require_once('../../enitites/dao/products_queries.php');

//Class with dependeces at he Querie's file
class products extends ProductQueries
{
    //Atributes to do manipule data
    protected $id_producto;
    protected $id_valoracion;
    protected $nombre_producto;
    protected $descripcion;
    protected $precio;
    protected $imagen;
    protected $existencias;
    protected $categoria;
    protected $modelo;
    protected $estado_producto;
    protected $ruta = '../../images/products/';
    protected $id_imagen_producto;
    protected $imagen_s;

    //Method's set for each atribute
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdValoracion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_valoracion = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setNombre_Producto($value)
    {
        if (Validator::validateAlphanumeric($value, 0, 80)) {
            $this->nombre_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setDescripcion($value)
    {
        if (Validator::validateAlphanumeric($value, 0, 150)) {
            $this->descripcion = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 1500, 1500)) {
            $this->imagen = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }
    public function setExistencias($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->existencias = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->categoria = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setModelo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setEstado_Producto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdImg($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_imagen_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagenS($file){
        if (Validator::validateImageFile($file, 1500, 1500)) {
            $this->imagen_s=Validator::getFileName();
            return true;
        }else{
            return false;
        }
    }

    // Metodos get de los atributos
    public function getId(){
        return $this->id_producto;
    }
    public function getIdValoracion()
    {
        return $this->id_valoracion;
    }
    public function getNombre_Producto()
    {
        return $this->nombre_producto;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getExistencias()
    {
        return $this->existencias;
    }
    public function getCategoria()
    {
        return $this->categoria;
    }
    public function getModelo()
    {
        return $this->modelo;
    }
    public function getEstado_Producto()
    {
        return $this->estado_producto;
    }
    //This method getRuta is to capture the url of the products image
    public function getRuta()
    {
        return $this->ruta;
    }

    public function getImagenS()
    {
        return $this->imagen_s;
    }

    public function getIdImg()
    {
        return $this->id_imagen_producto;
    }
}