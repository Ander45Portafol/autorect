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
                    $result['exception'] = 'Ocurrió un problema al obtener el pedido';
                } elseif (!$order_model->setProduct($_POST['id_product'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$order_model->setQuantityProduct($_POST['product_exits'])) {
                    $result['exception'] = 'Cantidad incorrecta';
                } elseif ($order_model->createDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto agregado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOrderDetail':
                if (!$order_model->startOrder()) {
                    $result['exception'] = 'Debe agregar un producto al carrito';
                } elseif ($result['dataset'] = $order_model->readOrderDetail()) {
                    $result['status'] = 1;
                    $_SESSION['id_pedido'] = $order_model->getId();
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No tiene productos en el carrito';
                }
                break;
            case 'updateOrder':
                if (!$order_model->setClientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente no encontrado';
                }elseif ($order_model->updateOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido actualizado correctamente';
                }else{
                    $result['exception']='No se pudo actualizar el estado del pedido';
                }
                break;
            case 'confirmOrder':
                if (!$order_model->setClientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Cliente no encontrado';
                }elseif ($result['dataset']=$order_model->confirmOrder()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido actualizado correctamente';
                }
                break;
            case 'subtractDetail':
                if (!$order_model->setDetailId($_POST['id_detalle'])) {
                    $result['exception']='Detalle, no encontrado';
                }elseif (!$order_model->setQuantityProduct($_POST['cantidad'])) {
                    $result['exception']='Cantidad, incorrecta';
                }elseif ($order_model->subtractDetail()) {
                    $result['status']=1;
                }else{
                    $result['exception']=Database::getException();
                }
                break;
                case 'addDetail':
                    if (!$order_model->setDetailId($_POST['id_detalle'])) {
                        $result['exception']='Detalle, no encontrado';
                    }elseif (!$order_model->setQuantityProduct($_POST['cantidad'])) {
                        $result['exception']='Cantidad, incorrecta';
                    }elseif ($order_model->addDetail()) {
                        $result['status']=1;
                    }else{
                        $result['exception']=Database::getException();
                    }
                    break;
            case 'deleteDetail':
                if (!$order_model->setDetailId($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'Detalle incorrecto';
                } elseif ($order_model->deleteOrderDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto removido correctamente';
                } else {
                    $result['exception'] = 'Ocurrió un problema al remover el producto';
                }
                break;
            case 'readUpdatedStock':
                if (!$order_model->setDetailId($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'Detalle incorrecto';
                } elseif ($result['dataset'] = $order_model->readUpdatedStock()) {
                    $result['status'] = 1;
                    $result['message'] = 'Si hay stock';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }else{
                    $result['exception'] = 'Error al leer el stock';
                }
                break;
            default:
                $result['exception'] = 'Accion no disponible';
        }
    } else {
        switch ($_GET['action']) {
            case 'createDetail':
                $result['exception'] = 'Debe iniciar sesión para agregar el producto al carrito';
                break;
            default:
                $result['exception'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // The type of content to be displayed and its respective set of characters are indicated.
    header('content-type: application/json; charset=utf-8');
    // The result is printed in JSON format and returned to the controller.
    print(json_encode(($result)));
} else {
    print(json_encode('Recurso no disponible'));
}
