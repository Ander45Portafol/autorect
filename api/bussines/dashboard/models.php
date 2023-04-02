<?php
require_once('../../enitites/dto/models.php');

if (isset($_GET['action'])) {

    session_start();

    $model = new Models;

    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);

    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $model->readAll()) {
                    $result['status'] = 1;
                } else if (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No registers to show';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Search..';
                } else if ($result['dataset'] = $model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                } else if (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No registers to show';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$model->setModelName($_POST['nombre_modelo'])) {
                    $result['exception'] = 'Incorrect name';
                } else if (!$model->setModelYear($_POST['anio_modelo'])) {
                    $result['exception'] = 'Select a Year';
                } else if (!isset($_POST['id_marca'])) {
                    $result['exception'] = 'Please select a brand';
                } else if (!$model->setBrand_Id($_POST['id_marca'])) {
                    $result['exception'] = 'Wrong brand selected';
                } else if ($model->createRow()) {
                    $result['message'] = 'Brand was successfully registered';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readOne':
                if (!$model->setId($_POST['id'])) {
                    $result['exception'] = 'Incorrect model';
                } else if ($result['dataset'] = $model->readOne()) {
                    $result['status'] = 1;
                } else if (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Inexistent model';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$model->setId($_POST['id'])) {
                    $result['exception'] = 'Incorrect Model';
                } else if (!$data = $model->readOne()) {
                    $result['exception'] = 'Inexistent product';
                } else if (!$model->setModelName($_POST['nombre_modelo'])) {
                    $result['exception'] = 'Incorrect name';
                } else if (!$model->setModelYear($_POST['anio_modelo'])) {
                    $result['exception'] = 'Incorrect Year';
                } else if (!$model->setBrand_Id($_POST['id_marca'])) {
                    $result['exception'] = 'Select a brand';
                }
                if ($model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Model was modified correctly';
                } else {
                    $result['exception'] = DAtabase::getException();
                }
                break;
            case 'delete':
                if (!$model->setId($_POST['id_modelo'])) {
                    $result['exception'] = 'Wrong model';
                } else if (!$data = $model->readOne()) {
                    $result['exception'] = 'Inexistent model';
                } else if ($model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Model was deleted correctly';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Accion no disponible dentro de la sesion';
        }
        header('content-type: application/json; charset=utf-8');
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}