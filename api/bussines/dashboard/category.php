<?php
require_once('../../helpers/validator.php');
//This url is to use data, of the atributes and queries through dependecies
require_once('../../enitites/dto/category.php');
//This if is to validate the action is to do
if (isset($_GET['action'])) {
    session_start();
    //Object to mecioned functions of the queries, through this object
    $category_model = new Category;
    //This variable is to show the answer at the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Is to verficate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Is to verificated that action is to do
        switch ($_GET['action']) {
                //This action is to charger datas in the table
            case 'readAll':
                if ($result['dataset'] = $category_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //This action is to search the especific data
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $category_model->readAll();
                } elseif ($result['dataset'] = $category_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                //This action is verificate the exists of the category
            case 'readOne':
                if (!$category_model->setId($_POST['id'])) {
                    $result['exception'] = 'Categoria Incorrecto';
                } elseif ($result['dataset'] = $category_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Categoria Inexiste';
                }
                break;
                //This action is to create a new category and verificate data to send at the queries file
            case 'create':
                if (!$category_model->setNombre($_POST['category_name'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$category_model->setDescripcion($_POST['category_description'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                } elseif (!$category_model->setImagen($_FILES['imageCategories'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($category_model->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageCategories'], $category_model->getRuta(), $category_model->getImagen())) {
                        $result['message'] = 'Producto creado, correctamente';
                    } else {
                        $result['message'] = 'Producto creado, pero sin la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //This action is to update a category and verificate data to send at the queries file
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$category_model->setId($_POST['id'])) {
                    $reuslt['exception'] = 'Categoria incorrecta';
                } elseif (!$data = $category_model->readOne()) {
                    $result['exception'] = 'Categoria inexistente';
                } elseif (!$category_model->setNombre($_POST['category_name'])) {
                    $result['exception'] = 'Nombre Incorrecto';
                } elseif (!$category_model->setDescripcion($_POST['category_description'])) {
                    $result['exception'] = 'Descripcion incorrecta';
                } elseif (!is_uploaded_file($_FILES['imageCategories']['tmp_name'])) {
                    if ($category_model->updateRow($data['imagen_categoria'])) {
                        $result['status'] = 1;
                        $Result['message'] = 'Usuario actualizado, correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$category_model->setImagen($_FILES['imageCategories'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($category_model->updateRow($data['imagen_categoria'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageCategories'], $category_model->getRuta(), $category_model->getImagen())) {
                        $Result['message'] = 'Usuario actualizado, correctamente';
                    } else {
                        $Result['message'] = 'Usuario actualizado, pero no se guardo la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //This action is to delete data of the category
            case 'delete':
                if (!$category_model->setId($_POST['id_categoria'])) {
                    $result['exception'] = 'Categoria incorrecta';
                } elseif (!$data = $category_model->readOne()) {
                    $result['exception'] = 'Categoria inexistente';
                } elseif ($category_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoria Eliminada, correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Case default if anything is executed
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        //indicate the tyoe of the content to show and yours respective strings
        header('content-type: application/json; charset=utf-8');
        //Show the result in format JSON and return at the controller
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    //If nothing are compilating, the api show this message in format JSON
    print(json_encode('Recurso no disponible'));
}
