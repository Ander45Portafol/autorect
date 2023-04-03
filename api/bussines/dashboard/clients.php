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