<?php
require_once('../../enitites/dto/clients.php');
if (isset($_GET['action'])) {
    session_start();
    $client_model=new Client;
    $result=array('status'=>0, 'message'=>null,'exception'=>null,'dataset'=>null);
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset']=$client_model->readAll()) {
                    $result['status']=1;
                    $result['message']='Existen registros';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else {
                    $result['exception']='No hay datos registrados';
                }
                break;
            case 'search':
                $_POST=Validator::validateForm($_POST);
                if ($_POST['search']=='') {
                    $result['exception']='Ingrese un valor para buscar';
                }elseif ($result['dataset']=$client_model->searchRows($_POST['search'])) {
                    $result['status']=1;
                    $result['message']='Si se encontraron resultados';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else{
                    $result['exception']='No hay coincidencias';
                }
                break;
                case 'delete':
                    if (!$client_model->setIdCliente($_POST['id_cliente'])) {
                        $result['exception']='Cliente incorrecto';
                    }elseif (!$data=$client_model->readOne()) {
                        $result['exception']='Cliente inexistente';
                    }elseif ($client_model->deleteRow()) {
                        $result['status']=1;
                        $result['message']='Cliente Eliminado, correctamente';
                    }else{
                        $result['exception']=Database::getException();
                    }
                    break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
                break;
        }
        print(json_encode($result));
    }else{
        print(json_encode('Acceso denegado'));
    }
}else{
    print(json_encode('Recurso no disponible'));
}