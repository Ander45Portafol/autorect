<?php

require_once('../../enitites/dto/category.php');

if(isset($GET['action'])){
    $category=new Category;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    switch($_GET['action']){
        case 'create':
            if(!$category->setNombre($_POST['category_name'])){
                $result['exception']='Nombre incorrecto';
            }elseif (!$category->setDescripcion($_POST['description'])) {
                $result['exception']='Descripcion incorrecta';
            }elseif ($category->createRow()) {
                $result['status']=1;
                $result['message']='Categoria creada correctamente';
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
}