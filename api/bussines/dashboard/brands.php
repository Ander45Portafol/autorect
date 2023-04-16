<?php
require_once('../../enitites/dto/brands.php');

if (isset($_GET['action'])) {
    session_start();
    $brand_model = new Brand;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);

    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $brand_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . 'was founded';
                } else if (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No info to show';
                }
                break;
            case 'readOne':
                if (!$brand_model->setID($_POST['id'])) {
                    $result['exception'] = 'The brand was incorrect';
                } elseif ($result['dataset'] = $brand_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The brand does not exist';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$brand_model->setBrandName($_POST['BrandName'])) {
                    $result['exception'] = 'There was an error with the brand name';
                } else if ($brand_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The brand has been created';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$brand_model->setID($_POST['id'])) {
                    $result['exception'] = 'The brand does not exist';
                } else if (!$data = $brand_model->readOne()) {
                    $result['exception'] = 'The data does not exist';
                } else if (!$brand_model->setBrandName($_POST['BrandName'])) {
                    $result['exception'] = 'There was an error with the brand name';
                } else if ($brand_model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The brand has been created';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'delete':
                if (!$brand_model->setID($_POST['id_marca'])) {
                    $result['exception'] = 'The brand was incorrect';
                } else if (!$data = $brand_model->readOne()) {
                    $result['exception'] = 'The selected brand does not exist';
                } else if ($brand_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The brand was deleted';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'The action was not avaliable';
                break;
        }
        header('content-type: application/json; charset=utf-8');
        print(json_encode($result));
    } else {
        print(json_encode('Access denied'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}