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
            /*Filters*/
            case 'categoriesFilter':
                if ($result['dataset'] = $product_model->categoriesFilter()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No existen categorias para mostrar';
                }
                break; 
            case 'priceFilter':
                if ($result['dataset'] = $product_model->priceFilter()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No existen precios para mostrar';
                }
                break; 
            case 'yearsFilter':
                if ($result['dataset'] = $product_model->yearsFilter()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No existen años para mostrar';
                }
                break; 
            case 'filterSearch':
                $_POST = Validator::validateForm($_POST);
                if(isset($_POST['categoryID'])) {
                    if(!$product_model->setProductCategory($_POST['categoryID'])){
                        $result['exception'] = 'Error en la categoria';
                    }
                }
                if(isset($_POST['priceRange'])) {
                    if(!$product_model->setProductPrice($_POST['priceRange'])){
                        $result['exception'] = 'Error en el precio';
                    }
                }
                if(isset($_POST['modelYear'])) {
                    if(!$product_model->setModelYear($_POST['modelYear'])){
                        $result['exception'] = 'Error en el año';
                    }
                }
                if($result['dataset'] = $product_model->filterSearch()){
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No existen productos para mostrar';
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