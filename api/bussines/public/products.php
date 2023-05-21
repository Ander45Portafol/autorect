<?php
require_once('../../entities/dto/products.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se instancia la clase correspondiente.
    $product_model = new Product;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se compara la acción a realizar según la petición del controlador.
    switch ($_GET['action']) {
        case 'readAll':
            if ($result['dataset'] = $product_model->readAll()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No existen productos para mostrar';
            }
            break;
        case 'readTop10':
            if ($result['dataset'] = $product_model->readTop10()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No existen productos para mostrar';
            }
            break;
            case 'readOne':
                if (!$product_model->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Wrong product';
                } elseif ($result['dataset'] = $product_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The category does not exist';
                }
                break;
        case 'search':
            $_POST = Validator::validateForm($_POST);
            if ($_POST['search'] == '') {
                $result['status'] = 1;
                $result['dataset'] = $product_model->readAll();
            } elseif ($result['dataset'] = $product_model->searchRow($_POST['search'])) {
                $result['status'] = 1;
                $result['message'] = 'Data was found';
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No data';
            }
            break;
        case 'productsRelated':
            if (!$product_model->setProductCategory($_POST['id_categoria'])) {
                $result['exception'] = 'Categoría incorrecta';
            }elseif (!$product_model->setId($_POST['id_producto'])) {
                $result['exception'] = 'Producto incorrecta';
            } elseif ($result['dataset'] = $product_model->productsRelated()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No existen productos para mostrar';
            }
            break;
            case 'productReview':
                if (!$product_model->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Wrong product';
                } elseif ($result['dataset'] = $product_model->productsReview()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']);
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The category does not exist';
                }
                break;
            case 'hsitoryProduct':
                if (!$product_model->setIdClient($_POST['id_cliente'])) {
                    $result['exception'] = 'Wrong client';
                }elseif ($result['dataset']=$product_model->productHistory()) {
                    $result['status'] = 1;
                }else{
                    $result['exception'] = Database::getException();
                }
                break;
            case 'validateComments':
                if (!$product_model->setDetailId($_POST['id_detalle'])) {
                    $result['exception']='Detalle incorrecto';
                }elseif ($result['dataset']=$product_model->validateComments()) {
                    $result['status']=1;
                }else{
                    $result['exception']=Database::getException();
                }
                break;
        default:
            $result['exception'] = 'Acción no disponible';
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}