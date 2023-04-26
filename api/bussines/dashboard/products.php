<?php

require_once('../../enitites/dto/products.php');

if (isset($_GET['action'])) {
    session_start();
    $product_model = new products;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $product_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readStatus':
                if ($result['dataset'] = $product_model->readStatusProduct()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $product_model->searchRow($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'readOne':
                if (!$product_model->setId($_POST['id'])) {
                    $result['exception'] = 'Producto Incorrecto';
                } elseif ($result['dataset'] = $product_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Categoria Inexiste';
                }
                break;
            case 'create':
                if (!$product_model->setNombre_Producto($_POST['Product_name'])) {
                    $result['exception'] = 'Nombre Incorrecto';
                } elseif (!$product_model->setPrecio($_POST['Price'])) {
                    $result['exception'] = 'Precio de producto incorrecto';
                } elseif (!$product_model->setExistencias($_POST['Stock'])) {
                    $reuslt['exception'] = 'Existencias no validas';
                } elseif (!$product_model->setCategoria($_POST['Category'])) {
                    $result['exception'] = 'Seleccione una categoria';
                } elseif (!$product_model->setModelo($_POST['Model'])) {
                    $result['exception'] = 'Seleccione un modelo';
                } elseif (!$product_model->setEstado_Producto($_POST['Status'])) {
                    $result['exception'] = 'Seleccione un esatdo, para el producto';
                } elseif (!$product_model->setDescripcion($_POST['product_description'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                } elseif (!$product_model->setImagen($_FILES['imageProduct'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($product_model->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageProduct'], $product_model->getRuta(), $product_model->getImagen())) {
                        $result['message'] = 'Producto creado, correctamente';
                    } else {
                        $result['message'] = 'Producto creado, pero sin la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$product_model->setId($_POST['id'])) {
                    $reuslt['exception'] = 'Producto incorrecta';
                } elseif (!$data = $product_model->readOne()) {
                    $result['exception'] = 'Categoria inexistente';
                } elseif (!$product_model->setNombre_Producto($_POST['Product_name'])) {
                    $result['exception'] = 'Nombre Incorrecto';
                } elseif (!$product_model->setPrecio($_POST['Price'])) {
                    $result['exception'] = 'Precio de producto incorrecto';
                } elseif (!$product_model->setExistencias($_POST['Stock'])) {
                    $reuslt['exception'] = 'Existencias no validas';
                } elseif (!$product_model->setCategoria($_POST['Category'])) {
                    $result['exception'] = 'Seleccione una categoria';
                } elseif (!$product_model->setModelo($_POST['Model'])) {
                    $result['exception'] = 'Seleccione un modelo';
                } elseif (!$product_model->setEstado_Producto($_POST['Status'])) {
                    $result['exception'] = 'Seleccione un esatdo, para el producto';
                } elseif (!$product_model->setDescripcion($_POST['product_description'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                }elseif (!is_uploaded_file($_FILES['imageProduct']['tmp_name'])) {
                    if ($user_model->updateRow($data['imagen_principal'])) {
                        $result['status']=1;
                        $Result['message']='Producto actualizado, correctamente';
                    }else {
                        $result['exception']=Database::getException();
                    }
                }elseif (!$product_model->setImagen($_FILES['imageProduct'])) {
                    $result['exception']=Validator::getFileError();
                }elseif ($product_model->updateRow($data['imagen_principal'])) {
                    $result['status']=1;
                    if (Validator::saveFile($_FILES['imageProduct'],$product_model->getRuta(), $product_model->getImagen())) {
                        $Result['message']='Producto actualizado, correctamente';
                    }else {
                        $Result['message']='Producto actualizado, pero no se guardo la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$product_model->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecta';
                } elseif (!$data = $product_model->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($product_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto Eliminada, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readImgs':
                if (!$product_model->setId($_POST['id'])) {
                    $result['exception'] = 'No existe ese producto';
                } elseif ($result['dataset'] = $product_model->readImgs()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'];
                }
                break;
            case 'createImg':
                $num = $_POST['num'];
                if (!$product_model->setImagenS($_FILES['input-img-' . $num]['name'])) {
                    $result['exception'] = Validator::getFileError('input-img-' . $num);
                } elseif(!$product_model->setId($_POST['id-p'])) {
                    $result['exception'] = 'No existe ese producto';
                } elseif ($product_model->createImg()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['input-img-' . $num], $product_model->getRuta(), $product_model->getImagenS())) {
                    $result['message'] = 'Imagen creada';
                    } else {
                    $result['message'] = 'Imagen no creada';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
