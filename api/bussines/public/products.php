<?php
require_once('../../entities/dto/products.php');

// It checks if there is an action to perform, otherwise the script ends with an error message.
if (isset($_GET['action'])) {
    // The corresponding class is instantiated.
    $product_model = new Product;
    // An array is declared and initialized to store the result returned by the API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // The action to perform when a client has logged in is compared.
    switch ($_GET['action']) {
        case 'readAllPublic':
            if ($result['dataset'] = $product_model->readAllPublic()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = "Don't exits products to show";
            }
            break;
        case 'readTop10':
            if ($result['dataset'] = $product_model->readTop10()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = "Don't exits products to show";
            }
            break;
        case 'readOnePublic':
            if (!$product_model->setId($_POST['id_producto'])) {
                $result['exception'] = 'Wrong product';
            } elseif ($result['dataset'] = $product_model->readOnePublic()) {
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
        case 'searchPublic':
            $_POST = Validator::validateForm($_POST);
            if ($_POST['search'] == '') {
                $result['status'] = 1;
                $result['dataset'] = $product_model->readAllPublic();
            } elseif ($result['dataset'] = $product_model->searchPublic($_POST['search'])) {
                $result['status'] = 1;
                $result['message'] = 'Data was found';
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No data';
            }
            break;
        case 'readProductImgsPublic':
            if (!$product_model->setId($_POST['id_producto'])) {
                $result['exception'] = 'Wrong product';
            } elseif ($result['dataset'] = $product_model->readProductImgsPublic()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'There are no images to show';
            }
            break;
        case 'productsRelated':
            if (!$product_model->setProductCategory($_POST['id_categoria'])) {
                $result['exception'] = 'Wrong category';
            }elseif (!$product_model->setId($_POST['id_producto'])) {
                $result['exception'] = 'Wrong product';
            } elseif ($result['dataset'] = $product_model->productsRelated()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = "Don't exits products to show";
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
                }elseif (!$product_model->setIdOrder($_POST['id_pedido'])) {
                    $result['exception'] = 'Order incorrect';
                }elseif ($result['dataset']=$product_model->productHistory()) {
                    $result['status'] = 1;
                }else{
                    $result['exception'] = Database::getException();
                }
                break;
            case 'orderHistory':
                if (!$product_model->setIdClient($_POST['id_cliente'])) {
                    $result['exception'] = 'Wrong client';
                }elseif ($result['dataset']=$product_model->orderHistory()) {
                    $result['status'] = 1;
                }else{
                    $result['exception'] = Database::getException();
                }
                break;
            case 'validateComments':
                if (!$product_model->setDetailId($_POST['id_detalle'])) {
                    $result['exception']='Incorrect detail';
                }elseif ($result['dataset']=$product_model->validateComments()) {
                    $result['status']=1;
                }else{
                    $result['exception']=Database::getException();
                }
                break;
            case 'createComment':
                if (!$product_model->setDetailId($_POST['id_detalle'])) {
                    $result['exception']='Incorrect detail';
                }elseif (!$product_model->setComment($_POST['comment'])) {
                    $result['exception']='Incorrect comment';
                }elseif (!$product_model->setQuantity($_POST['quantity'])) {
                    $result['exception']='Incorrect quantity';
                }elseif ($product_model->createComment()) {
                    $result['status']=1;
                    $result['message']='Succesfull create comment';
                }else {
                    $result['exception']=Database::getException();
                }
                break;
            case 'deleteComments':
                if (!$product_model->setDetailId($_POST['id_detalle'])) {
                    $result['exception']='Incorrect detail';
                }elseif ($product_model->deleteComments()) {
                    $result['status']=1;
                    $result['message']='Succesfull delete comment';
                }else {
                    $result['exception']=Database::getException();
                }
                break;
            /*Filters*/
            case 'categoriesFilter':
                if ($result['dataset'] = $product_model->categoriesFilter()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = "Don't exits products to show";
                }
                break; 
            case 'priceFilter':
                if ($result['dataset'] = $product_model->priceFilter()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = "Don't exits products to show";
                }
                break; 
            case 'yearsFilter':
                if ($result['dataset'] = $product_model->yearsFilter()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = "Don't exits products to show";
                }
                break; 
            case 'filterSearch':
                $_POST = Validator::validateForm($_POST);
                if(isset($_POST['categoryID'])) {
                    if(!$product_model->setProductCategory($_POST['categoryID'])){
                        $result['exception'] = 'Error on category';
                    }
                }
                if(isset($_POST['priceRange'])) {
                    if(!$product_model->setProductPrice($_POST['priceRange'])){
                        $result['exception'] = 'Error on price';
                    }
                }
                if(isset($_POST['modelYear'])) {
                    if(!$product_model->setModelYear($_POST['modelYear'])){
                        $result['exception'] = 'Error in the year';
                    }
                }
                if($result['dataset'] = $product_model->filterSearch()){
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = "Don't exits products to show";
                }
            break;
        default:
            $result['exception'] = 'Acción no disponible';
    }
    // The type of content to be displayed and its respective set of characters are indicated.
    header('content-type: application/json; charset=utf-8');
    // The result is printed in JSON format and returned to the controller.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}