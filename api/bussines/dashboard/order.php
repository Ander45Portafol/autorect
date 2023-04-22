<?php

require_once('../../enitites/dto/order.php');

if(isset($_GET['action'])){
    session_start();
    $order_model=new Order;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    if (isset($_SESSION['id_usuario'])) {
        switch($_GET['action']){
            case 'readAll':
                if ($result['dataset']=$order_model->readAll()) {
                    $result['status']=1;
                    $result['message']='Existen '.count($result['dataset']).' registros';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else {
                    $result['exception']='No hay datos registrados';
                }
            break;
            case 'readAllDetail':
                if (!$order_model->setID($_POST['id'])) {
                    $result['exception']='El pedido es incorrecto';
                }elseif ($result['dataset']=$order_model->readAllDetail()) {
                    $result['status']=1;
                    $result['message']='Existen '.count($result['dataset']).' registros';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else {
                    $result['exception']='No hay datos registrados';
                }
                break;
            case 'search':
                $_POST=Validator::validateForm($_POST);
                if ($_POST['search']=='') {
                    $result['status'] = 1; 
                    $result['dataset'] = $order_model->readAll(); 
                }elseif ($result['dataset']=$order_model->searchRows($_POST['search'])) {
                    $result['status']=1;
                    $result['message']='Si se encontraron resultados';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else{
                    $result['exception']='No hay coincidencias';
                }
            break;
            case 'readOne':
                    if (!$order_model->setId($_POST['id'])) {
                        $result['exception'] = 'Pedido incorrecto';
                    } elseif ($result['dataset'] = $order_model->readOne()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Pedido inexistente';
                    }
            break;
            case 'readEstados':
                if ($result['dataset']=$order_model->readEstados()) {
                    $result['status']=1;
                    $result['message']='Existen '.count($result['dataset']).' registros';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else {
                    $result['exception']='No hay datos registrados';
                }
            break;
            case 'readClients':
                if ($result['dataset']=$order_model->readClients()) {
                    $result['status']=1;
                    $result['message']='Existen '.count($result['dataset']).' registros';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else {
                    $result['exception']='No hay datos registrados';
                }
            break;
            case 'readEmployees':
                if ($result['dataset']=$order_model->readEmployees()) {
                    $result['status']=1;
                    $result['message']='Existen '.count($result['dataset']).' registros';
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else {
                    $result['exception']='No hay datos registrados';
                }
            break;
            case 'create':
                if (!$order_model->setDireccion($_POST['direccion'])) {
                    $result['exception']='Error en la dirección';
                }elseif (!$order_model->setFecha($_POST['fecha'])) {
                    $result['exception']='Error en la fecha';
                }elseif (!isset($_POST['clients'])) {
                    $result['exception']='Selecciona un cliente';
                }elseif (!$order_model->setId_Cliente($_POST['clients'])) {
                    $result['exception']='Error al escoger un cliente';
                }elseif (!isset($_POST['estado'])) {
                    $result['exception']='Selecciona un estado';
                }elseif (!$order_model->setId_Estado($_POST['estado'])) {
                    $result['exception']='Error al escoger un estado';
                }elseif (!isset($_POST['employees'])) {
                    $result['exception']='Selecciona un empleado';
                }elseif (!$order_model->setId_Empleado($_POST['employees'])) {
                    $result['exception']='Error al escoger un empleado';
                }elseif ($order_model->createRow()) {
                    $result['status']=1;
                    $result['message']='Pedido creado correctamente';
                }else {
                    $result['exception']=Database::getException();
                }
                break;
            case 'update':
                if (!$order_model->setDireccion($_POST['direccion'])) {
                    $result['exception']='Error en la dirección';
                }elseif (!$order_model->setFecha($_POST['fecha'])) {
                    $result['exception']='Error en la fecha';
                }elseif (!isset($_POST['clients'])) {
                    $result['exception']='Selecciona un cliente';
                }elseif (!$order_model->setId_Cliente($_POST['clients'])) {
                    $result['exception']='Error al escoger un cliente';
                }elseif (!isset($_POST['estado'])) {
                    $result['exception']='Selecciona un estado';
                }elseif (!$order_model->setId_Estado($_POST['estado'])) {
                    $result['exception']='Error al escoger un estado';
                }elseif (!isset($_POST['employees'])) {
                    $result['exception']='Selecciona un empleado';
                }elseif (!$order_model->setId_Empleado($_POST['employees'])) {
                    $result['exception']='Error al escoger un empleado';
                }elseif  (!$order_model->setId($_POST['id'])){
                    $result['exception']='Pedido inexistente';
                }elseif ($order_model->updateRow()) {
                    $result['status']=1;
                    $result['message']='Pedido actualizado correctamente';
                }else {
                    $result['exception']=Database::getException();
                }
            break;
            case 'delete':
                if (!$order_model->setID($_POST['id_pedido'])) {
                    $result['exception']='El pedido es incorrecto';
                }elseif (!$data=$order_model->readOne()) {
                    $result['exception']='El pedido seleccionado, no existe';
                }elseif ($order_model->deleteRow()) {
                    $result['status']=1;
                    $result['message']='Eliminado, correctamente';
                }else {
                    $result['exception']=Database::getException();
                }
            break;
            case 'deleteDetail':
                if (!$order_model->setIdDetalle($_POST['id_detalle_pedido'])) {
                    $result['exception']='El Detalle es incorrecto';
                }elseif (!$data=$order_model->readOneDetail()) {
                    $result['exception']='El Detalle seleccionado, no existe';
                }elseif ($order_model->deleteDetailRow()) {
                    $result['status']=1;
                    $result['message']='Eliminado, correctamente';
                }else {
                    $result['exception']=Database::getException();
                }
            break;
                default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
            
        } 
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    }else {
        print(json_encode('Acceso denegado'));
    }
}else {
    print(json_encode('Recurso no disponible'));
}