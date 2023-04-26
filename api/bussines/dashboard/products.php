<?php
//This url is to use data, of the atributes and queries through dependecies
require_once('../../enitites/dto/products.php');
//This if is to validate the action is to do
if (isset($_GET['action'])) {
    session_start();
    //Object to mecioned functions of the queries, through this object
    $product_model = new products;
    //This variable is to show the answer at the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'idimagen' => 0);
    //Is to verficate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Is to verificated that action is to do
        switch ($_GET['action']) {
            //This action is to charger datas in the table
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
                //This action is to show all valorations of the products
            case 'readAllValoration':
                if (!$product_model->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecta';
                }elseif ($result['dataset'] = $product_model->readAllValorations()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //This action is to show the status of the product data in te select
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
            //This action is to search the especific data
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1; 
                    $result['dataset'] = $product_model->readAll(); 
                } elseif ($result['dataset'] = $product_model->searchRow($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            //This action is verificate the exists of the product
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
            //This action is to create a new product and verificate data to send at the queries file
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
            //This action is to update a product and verificate data to send at the queries file
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$product_model->setId($_POST['id'])) {
                    $reuslt['exception'] = 'Employee incorrecto';
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
                } elseif (!is_uploaded_file($_FILES['imageProduct']['tmp_name'])) {
                    if ($user_model->updateRow($data['imagen_principal'])) {
                        $result['status'] = 1;
                        $Result['message'] = 'Producto actualizado, correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$product_model->setImagen($_FILES['imageProduct'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($product_model->updateRow($data['imagen_principal'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageProduct'], $product_model->getRuta(), $product_model->getImagen())) {
                        $Result['message'] = 'Producto actualizado, correctamente';
                    } else {
                        $Result['message'] = 'Producto actualizado, pero no se guardo la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //This action is to delete data of the product
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
                //This action is to delete data of the product valoration
                case 'deleteValoration':
                    if (!$product_model->setIdValoracion($_POST['id_valoracion'])) {
                        $result['exception'] = 'Valoracion incorrecta';
                    } elseif (!$data = $product_model->readOneValoration()) {
                        $result['exception'] = 'Valoracion inexistente';
                    } elseif ($product_model->deleleteValoration()) {
                        $result['status'] = 1;
                        $result['message'] = 'Valoracion Eliminada, correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                    break;
            case 'readImgs':
                if (!$product_model->setId($_POST['id_producto'])) {
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
                if (!$product_model->setImagenS($_FILES['input-img-' . $num])) {
                    $result['exception'] = Validator::getFileError('input-img-' . $num);
                } elseif(!$product_model->setId($_POST['id-p'])) {
                    $result['exception'] = 'No existe ese producto';
                } elseif ($id = $product_model->createImg()) {
                    $result['status'] = 1;
                    $result['idimagen'] = $id;
                    if (Validator::saveFile($_FILES['input-img-' . $num], $product_model->getRuta(), $product_model->getImagenS())) {
                    $result['message'] = 'Imagen creada';
                    } else {
                    $result['message'] = 'Imagen no creada';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readLastImg':
                if ($result['dataset'] = $product_model->readLastImg()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'deleteImg':
                if (!$product_model->setIdImg($_POST['id_imagen_producto'])) {
                    $result['exception'] = 'Error en el id';
                }elseif (!$data = $product_model->readOneImg()) {
                    $result['exception'] = 'Imagen inexistente';
                }elseif ($product_model->deleteImg()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($product_model->getRuta(), $data['nombre_archivo_imagen'])) {
                        $result['message'] = 'Imagen eliminada correctamente';
                    } else {
                        $result['message'] = 'Imagen eliminada pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        //indicate the tyoe of the content to show and yours respective strings
        header('content-type: application/json; charset=utf-8');
        //Show the result in format JSON and return at the controller
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    //If nothing are compilating, the api show this message in format JSON
    print(json_encode('Recurso no disponible'));
}