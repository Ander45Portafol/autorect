<?php
require_once('../../entities/dto/order.php');

// It checks if there is an action to perform, otherwise the script ends with an error message.
if (isset($_GET['action'])) {
    // A session is created or the current one is resumed in order to use session variables in the script.
    session_start();
    // The corresponding class is instantiated.
    $order_model = new Order;
    // An array is declared and initialized to store the result returned by the API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // The action to perform when a client has logged in is compared.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        switch ($_GET['action']) {
            case 'createDetail':
                $_POST = Validator::validateForm($_POST);
                if (!$order_model->startOrder()) {
                    $result['exception'] = 'Problems with the order';
                } elseif (!$order_model->setProduct($_POST['id_product'])) {
                    $result['exception'] = 'Wrong product';
                } elseif (!$order_model->setQuantityProduct($_POST['product_exits'])) {
                    $result['exception'] = 'Wrong quantity';
                } elseif ($order_model->createDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Succesfull, add product';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOrderDetail':
                if (!$order_model->startOrder()) {
                    $result['exception'] = 'Please, add a product';
                } elseif ($result['dataset'] = $order_model->readOrderDetail()) {
                    $result['status'] = 1;
                    $_SESSION['id_pedido'] = $order_model->getId();
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Select products, to cart buy';
                }
                break;
            case 'updateOrder':
                if (!$order_model->setClientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente not found';
                } elseif ($order_model->updateOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'Update order, data';
                } else {
                    $result['exception'] = "Can't update order ";
                }
                break;
            case 'confirmOrder':
                if (!$order_model->setClientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente not found';
                } elseif ($result['dataset'] = $order_model->confirmOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'CONFIRM';
                }
                break;
            case 'subtractDetail':
                if (!$order_model->setDetailId($_POST['id_detalle'])) {
                    $result['exception'] = 'Detail not found';
                } elseif (!$order_model->setQuantityProduct($_POST['cantidad'])) {
                    $result['exception'] = 'Wrong quantity';
                } elseif ($order_model->subtractDetail()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'addDetail':
                if (!$order_model->setDetailId($_POST['id_detalle'])) {
                    $result['exception'] = 'Detail not found';
                } elseif (!$order_model->setQuantityProduct($_POST['cantidad'])) {
                    $result['exception'] = 'Wrong quantity';
                } elseif ($order_model->addDetail()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'deleteDetail':
                if (!$order_model->setDetailId($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'Wrong detail';
                } elseif ($order_model->deleteOrderDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'deleted product';
                } else {
                    $result['exception'] = 'Problems at the delete product';
                }
                break;
            case 'readUpdatedStock':
                if (!$order_model->setDetailId($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'Wrong detail';
                } elseif ($result['dataset'] = $order_model->readUpdatedStock()) {
                    $result['status'] = 1;
                    $result['message'] = 'Yes, have stock';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Error at read the stock';
                }
                break;
            default:
                $result['exception'] = 'Action no disponible';
        }
    } else {
        switch ($_GET['action']) {
            case 'createDetail':
                $result['exception'] = 'To add, products at cart, you have to login';
                break;
            default:
                $result['exception'] = 'Action not found, outside the session';
        }
    }
    // The type of content to be displayed and its respective set of characters are indicated.
    header('content-type: application/json; charset=utf-8');
    // The result is printed in JSON format and returned to the controller.
    print(json_encode(($result)));
} else {
    print(json_encode('Recurso no disponible'));
}
