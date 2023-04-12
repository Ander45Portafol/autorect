<?php
require_once('../../enitites/dto/models.php');

if (isset($_GET['action'])) {
    session_start();
    $models_model=new Models;
    $result=array('status'=>0, 'message'=>null,'exception'=>null,'dataset'=>null);
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'search':
                break;
            case 'readAll':
                if ($result['dataset'] = $models_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
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
            case 'create':
                    $_POST=Validator::validateForm($_POST);
                    if (!$models_model->setModelo($_POST['ModelName'])) {
                        $result['exception']='Nombre de modelo incorrecto';
                    }elseif (!$models_model->setAnio($_POST['ModelYear'])) {
                        $result['exception']='Año de modelo incorrecto';
                    } elseif (!isset($_POST['Brand'])) {
                        $result['exception']='Seleccione un modelo';
                    } elseif (!$models_model->setMarcas($_POST['Brand'])) {
                        $result['exception']='Marca de modelo incorrecto';
                    }elseif ($models_model->createRow()) {
                        $result['status']=1;
                        $result['message']='Se ha creado, correctamente';
                    }else {
                        $result['exception']=Database::getException();
                    }
                break;
            case 'update':
                $_POST=Validator::validateForm($_POST);
                if (!$models_model->setID($_POST['id'])) {
                    $result['exception']='Modelo incorrecto';
                } elseif (!$data=$models_model->readOne()) {
                    $result['exception']='Modelo inexistente';
                } elseif (!$models_model->setModelo($_POST['ModelName'])) {
                    $result['exception']='Nombre de modelo incorrecto';
                }elseif (!$models_model->setAnio($_POST['ModelYear'])) {
                    $result['exception']='Año de modelo incorrecto';
                } elseif (!isset($_POST['Brand'])) {
                    $result['exception']='Seleccione un modelo';
                } elseif (!$models_model->setMarcas($_POST['Brand'])) {
                    $result['exception']='Marca de modelo incorrecto';
                }elseif ($models_model->updateRow()) {
                    $result['status']=1;
                    $result['message']='Se ha actualizado, correctamente';
                }else {
                    $result['exception']=Database::getException();
                }
                break;
            case 'delete':
                if (!$models_model->setID($_POST['id_modelo'])) {
                    $result['exception']='El modelo es incorrecto';
                }elseif (!$data=$models_model->readOne()) {
                    $result['exception']='El modelo seleccionado, no existe';
                }elseif ($models_model->deleteRow()) {
                    $result['status']=1;
                    $result['message']='Eliminado, correctamente';
                }else {
                    $result['exception']=Database::getException();
                }
                break;
            default:
                $result['exception']='Accion no disponible';
                break;
        }
        header('content-type: application/json; charset=utf-8');
        print(json_encode($result));
    }else {
        print(json_encode('Acceso denegado'));
    }
}else{
    print(json_encode('Recurso no dispónible'));
}