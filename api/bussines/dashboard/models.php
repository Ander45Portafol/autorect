<?php
//Dependencies
require_once('../../enitites/dto/models.php');

//Validate what action is being done
if (isset($_GET['action'])) {
    session_start();
    //Object to mention the functions of the queries
    $models_model = new Model;
    //Variable to show the answer of the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Validate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Actions
        switch ($_GET['action']) {
            //Action to fill the table
            case 'readAll':
                if ($result['dataset'] = $models_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Action to read one model
            case 'readOne':
                if (!$models_model->setId($_POST['id'])) {
                    $result['exception'] = 'modelo incorrecto';
                } elseif ($result['dataset'] = $models_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'modelo inexistente';
                }
                break;
            //Action to read the brands
            case 'readBrand':
                if ($result['dataset'] = $models_model->readBrand()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen resgistros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            //Action to create a model
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$models_model->setModelName($_POST['ModelName'])) {
                    $result['exception'] = 'Nombre de modelo incorrecto';
                } elseif (!$models_model->setModelYear($_POST['ModelYear'])) {
                    $result['exception'] = 'Año de modelo incorrecto';
                } elseif (!isset($_POST['Brand'])) {
                    $result['exception'] = 'Seleccione un modelo';
                } elseif (!$models_model->setModelBrand($_POST['Brand'])) {
                    $result['exception'] = 'Marca de modelo incorrecto';
                } elseif ($models_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha creado, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to update a model
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$models_model->setID($_POST['id'])) {
                    $result['exception'] = 'Modelo incorrecto';
                } elseif (!$data = $models_model->readOne()) {
                    $result['exception'] = 'Modelo inexistente';
                } elseif (!$models_model->setModelName($_POST['ModelName'])) {
                    $result['exception'] = 'Nombre de modelo incorrecto';
                } elseif (!$models_model->setModelYear($_POST['ModelYear'])) {
                    $result['exception'] = 'Año de modelo incorrecto';
                } elseif (!isset($_POST['Brand'])) {
                    $result['exception'] = 'Seleccione un modelo';
                } elseif (!$models_model->setModelBrand($_POST['Brand'])) {
                    $result['exception'] = 'Marca de modelo incorrecto';
                } elseif ($models_model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se ha actualizado, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to delete a model
            case 'delete':
                if (!$models_model->setID($_POST['id_modelo'])) {
                    $result['exception'] = 'El modelo es incorrecto';
                } elseif (!$data = $models_model->readOne()) {
                    $result['exception'] = 'El modelo seleccionado, no existe';
                } elseif ($models_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Eliminado, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to search models
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $models_model->readAll();
                } elseif ($result['dataset'] = $models_model->searchRow($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            //Default case if the action being performed does not exist
            default:
                $result['exception'] = 'Accion no disponible';
                break;
        }
       //Indicate the content type
        header('content-type: application/json; charset=utf-8');
        //Show the result in format JSON and return at the controller
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    //If nothing are compilating, the api show this message in format JSON
    print(json_encode('Recurso no dispónible'));
}