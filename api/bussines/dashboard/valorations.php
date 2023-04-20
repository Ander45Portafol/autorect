<?php

require_once('../../enitites/dto/valorations.php');

if (isset($_GET['action'])) {
    session_start();
    $valoration_model = new valorations;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $valoration_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $valoration_model->searchRow($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'readOne':
                if (!$valoration_model->setId($_POST['id'])) {
                    $result['exception'] = 'Producto Incorrecto';
                } elseif ($result['dataset'] = $valoration_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Categoria Inexiste';
                }
                break;
            case 'delete':
                if (!$valoration_model->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'Producto incorrecta';
                } elseif (!$data = $valoration_model->readOne()) {
                    $result['exception'] = 'Valoracion inexistente';
                } elseif ($valoration_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Valoracion Eliminada, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
