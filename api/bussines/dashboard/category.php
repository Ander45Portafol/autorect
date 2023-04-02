<?php

require_once('../../enitites/dto/category.php');

if(isset($_GET['action'])){
    session_start();
    $category_model=new Category;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    if (isset($_SESSION['id_usuario'])) {
        switch($_GET['action']){
            case 'readAll':
                    if ($result['dataset']=$category_model->readAll()) {
                        $result['status']=1;
                        $result['message']='Existen '.count($result['dataset']).' registros';
                    }elseif (Database::getException()) {
                        $result['exception']=Database::getException();
                    }else {
                        $result['exception']='No hay datos registrados';
                    }
                break;
            case 'search':
                break;
            case 'readOne':
                if (!$category_model->setId($_POST['id'])) {
                    $result['exception']='Categoria Incorrecto';
                }elseif ($result['dataset']=$category_model->readOne()) {
                    $result['status']=1;
                }elseif (Database::getException()) {
                    $result['exception']=Database::getException();
                }else {
                    $result['exception']='Categoria Inexiste';
                }
                break;
            case 'create':
                if(!$category_model->setNombre($_POST['category_name'])){
                    $result['exception']='Nombre incorrecto';
                }elseif (!$category_model->setDescripcion($_POST['category_description'])) {
                    $result['exception']='Descripcion incorrecta';
                }elseif ($category_model->createRow()) {
                    $result['status']=1;
                    $result['message']='Categoria creada correctamente';
                }else{
                    $result['exception']=Database::getException();
                }
                break;
            case 'update':
                $_POST=Validator::validateForm($_POST);
                if (!$category_model->setId($_POST['id'])) {
                    $reuslt['exception']='Categoria incorrecta';
                }elseif (!$data=$category_model->readOne()) {
                    $result['exception']='Categoria inexistente';
                }elseif (!$category_model->setNombre($_POST['category_name'])) {
                    $result['exception']='Nombre Incorrecto';
                }elseif (!$category_model->setDescripcion($_POST['category_description'])) {
                    $result['exception']='Descripcion incorrecta';
                }elseif ($category_model->updateRow()) {
                    $result['status']=1;
                    $result['message']='Categoria actualizada, perfectamente';
                }else {
                    $result['exception']=Database::getException();
                }
                break;
            case 'delete':
                if (!$category_model->setId($_POST['id_categoria'])) {
                    $result['exception']='Categoria incorrecta';
                }elseif (!$data=$category_model->readOne()) {
                    $result['exception']='Categoria inexistente';
                }elseif ($category_model->deleteRow()) {
                    $result['status']=1;
                    $result['message']='Categoria Eliminada, correctamente';
                }else{
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