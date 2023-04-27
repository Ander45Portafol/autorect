<?php
//Dependencies
require_once('../../enitites/dto/order.php');

//Validate what action is being done
if (isset($_GET['action'])) {
    session_start();
    //Object to mention the functions of the queries
    $order_model = new Order;
    //Variable to show the answer of the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Validate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Actions
        switch ($_GET['action']) {
            //Action to fill the table
            case 'readAll':
                if ($result['dataset'] = $order_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Action to read the details per order
            case 'readAllDetail':
                if (!$order_model->setID($_POST['id'])) {
                    $result['exception'] = 'El pedido es incorrecto';
                } elseif ($result['dataset'] = $order_model->readAllDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Action to search orders
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $order_model->readAll();
                } elseif ($result['dataset'] = $order_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            //Action to read one order
            case 'readOne':
                if (!$order_model->setId($_POST['id'])) {
                    $result['exception'] = 'Pedido incorrecto';
                } elseif ($result['dataset'] = $order_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Pedido inexistente';
                }
                break;
            //Action to read the status of the orders
            case 'readEstados':
                if ($result['dataset'] = $order_model->readEstados()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Action to read the clients
            case 'readClients':
                if ($result['dataset'] = $order_model->readClients()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Action to read the employees
            case 'readEmployees':
                if ($result['dataset'] = $order_model->readEmployees()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Action to create an order
            case 'create':
                if (!$order_model->setAdrress($_POST['direccion'])) {
                    $result['exception'] = 'Error en la dirección';
                } elseif (!$order_model->setDate($_POST['fecha'])) {
                    $result['exception'] = 'Error en la fecha';
                } elseif (!isset($_POST['clients'])) {
                    $result['exception'] = 'Selecciona un cliente';
                } elseif (!$order_model->setClientId($_POST['clients'])) {
                    $result['exception'] = 'Error al escoger un cliente';
                } elseif (!isset($_POST['estado'])) {
                    $result['exception'] = 'Selecciona un estado';
                } elseif (!$order_model->setStatusId($_POST['estado'])) {
                    $result['exception'] = 'Error al escoger un estado';
                } elseif (!isset($_POST['employees'])) {
                    $result['exception'] = 'Selecciona un empleado';
                } elseif (!$order_model->setEmployeeId($_POST['employees'])) {
                    $result['exception'] = 'Error al escoger un empleado';
                } elseif ($order_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido creado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to update an order
            case 'update':
                if (!$order_model->setAdrress($_POST['direccion'])) {
                    $result['exception'] = 'Error en la dirección';
                } elseif (!$order_model->setDate($_POST['fecha'])) {
                    $result['exception'] = 'Error en la fecha';
                } elseif (!isset($_POST['clients'])) {
                    $result['exception'] = 'Selecciona un cliente';
                } elseif (!$order_model->setClientId($_POST['clients'])) {
                    $result['exception'] = 'Error al escoger un cliente';
                } elseif (!isset($_POST['estado'])) {
                    $result['exception'] = 'Selecciona un estado';
                } elseif (!$order_model->setStatusId($_POST['estado'])) {
                    $result['exception'] = 'Error al escoger un estado';
                } elseif (!isset($_POST['employees'])) {
                    $result['exception'] = 'Selecciona un empleado';
                } elseif (!$order_model->setEmployeeId($_POST['employees'])) {
                    $result['exception'] = 'Error al escoger un empleado';
                } elseif (!$order_model->setId($_POST['id'])) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($order_model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pedido actualizado correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to delete an order
            case 'delete':
                if (!$order_model->setID($_POST['id_pedido'])) {
                    $result['exception'] = 'El pedido es incorrecto';
                } elseif (!$data = $order_model->readOne()) {
                    $result['exception'] = 'El pedido seleccionado, no existe';
                } elseif ($order_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Eliminado, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to delete a detail
            case 'deleteDetail':
                if (!$order_model->setDetailId($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'El Detalle es incorrecto';
                } elseif (!$data = $order_model->readOneDetail()) {
                    $result['exception'] = 'El Detalle seleccionado, no existe';
                } elseif ($order_model->deleteDetailRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Eliminado, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Default case if the action being performed does not exist
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';

        }
        //Indicate the content type
        header('content-type: application/json; charset=utf-8');
        //Show the result in format JSON and return at the controller
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    //If nothing is compilating, the api show this message in format JSON
    print(json_encode('Recurso no disponible'));
}