<?php

require_once('../../enitites/dto/order.php');

if (isset($_GET['action'])) {
    session_start();
    $order_model = new Order;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $order_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            case 'readAllDetail':
                if (!$order_model->setID($_POST['id'])) {
                    $result['exception'] = 'Wrong order';
                } elseif ($result['dataset'] = $order_model->readAllDetail()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $order_model->readAll();
                } elseif ($result['dataset'] = $order_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            case 'readOne':
                if (!$order_model->setId($_POST['id'])) {
                    $result['exception'] = 'Wrong order';
                } elseif ($result['dataset'] = $order_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The order does not exist';
                }
                break;
            case 'readEstados':
                if ($result['dataset'] = $order_model->readEstados()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            case 'readClients':
                if ($result['dataset'] = $order_model->readClients()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            case 'readEmployees':
                if ($result['dataset'] = $order_model->readEmployees()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            case 'create':
                if (!$order_model->setAdrress($_POST['direccion'])) {
                    $result['exception'] = 'Wrong address';
                } elseif (!$order_model->setDate($_POST['fecha'])) {
                    $result['exception'] = 'Wrong date';
                } elseif (!isset($_POST['clients'])) {
                    $result['exception'] = 'Select a client';
                } elseif (!$order_model->setClientId($_POST['clients'])) {
                    $result['exception'] = 'Something went wrong';
                } elseif (!isset($_POST['estado'])) {
                    $result['exception'] = 'Select a status';
                } elseif (!$order_model->setStatusId($_POST['estado'])) {
                    $result['exception'] = 'Something went wrong';
                } elseif (!isset($_POST['employees'])) {
                    $result['exception'] = 'Select an employee';
                } elseif (!$order_model->setEmployeeId($_POST['employees'])) {
                    $result['exception'] = 'Something went wrong';
                } elseif ($order_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The order was created successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'update':
                if (!$order_model->setAdrress($_POST['direccion'])) {
                    $result['exception'] = 'Wrong address';
                } elseif (!$order_model->setDate($_POST['fecha'])) {
                    $result['exception'] = 'Wrong date';
                } elseif (!isset($_POST['clients'])) {
                    $result['exception'] = 'Select a client';
                } elseif (!$order_model->setClientId($_POST['clients'])) {
                    $result['exception'] = 'Something went wrong';
                } elseif (!isset($_POST['estado'])) {
                    $result['exception'] = 'Select a status';
                } elseif (!$order_model->setStatusId($_POST['estado'])) {
                    $result['exception'] = 'Something went wrong';
                } elseif (!isset($_POST['employees'])) {
                    $result['exception'] = 'Select an employee';
                } elseif (!$order_model->setEmployeeId($_POST['employees'])) {
                    $result['exception'] = 'Something went wrong';
                } elseif (!$order_model->setId($_POST['id'])) {
                    $result['exception'] = 'Pedido inexistente';
                } elseif ($order_model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The order was updated successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$order_model->setID($_POST['id_pedido'])) {
                    $result['exception'] = 'Wrong order';
                } elseif (!$data = $order_model->readOne()) {
                    $result['exception'] = 'The order does not exist';
                } elseif ($order_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The order was deleted successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'deleteDetail':
                if (!$order_model->setDetailId($_POST['id_detalle_pedido'])) {
                    $result['exception'] = 'Wrong detail';
                } elseif (!$data = $order_model->readOneDetail()) {
                    $result['exception'] = 'The detail you select, does not exist';
                } elseif ($order_model->deleteDetailRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The detail was deleted successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'The action can not be performed';

        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Access denied'));
    }
} else {
    print(json_encode('File unavaliable'));
}