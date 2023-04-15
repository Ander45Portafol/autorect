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