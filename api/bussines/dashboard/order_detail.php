<?php
require_once('../../enitites/dto/order_detail.php');

if (isset($_GET['action'])) {
    session_start();
    $order_detail_model=new Order_Detail;
    $result=array('status'=>0, 'message'=>null,'exception'=>null,'dataset'=>null);
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset']=$order_detail_model->readAll()) {
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
    }else {
        print(json_encode('Acceso denegado'));
    }
}else{
    print(json_encode('Recurso no disponible'));
}