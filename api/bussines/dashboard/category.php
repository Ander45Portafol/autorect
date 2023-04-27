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
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data to show';
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
                    $result['message'] = 'There is data to show';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data avaliable';
                }
                break;
            //This action is verificate the exists of the category
            case 'readOne':
                if (!$category_model->setId($_POST['id'])) {
                    $result['exception'] = 'Wrong category';
                } elseif ($result['dataset'] = $category_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The category does not exist';
                }
                break;
            //This action is to create a new category and verificate data to send at the queries file
            case 'create':
                if (!$category_model->setCategoryName($_POST['category_name'])) {
                    $result['exception'] = 'Wrong name';
                } elseif (!$category_model->setCategoryDescription($_POST['category_description'])) {
                    $result['exception'] = 'Wrong description';
                } elseif (!$category_model->setCategoryImg($_FILES['imageCategories'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($category_model->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageCategories'], $category_model->getRoute(), $category_model->getCategoryImg())) {
                        $result['message'] = 'The product was created successfully';
                    } else {
                        $result['message'] = 'The product was created without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //This action is to update a category and verificate data to send at the queries file
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$category_model->setId($_POST['id'])) {
                    $reuslt['exception'] = 'Wrong category';
                } elseif (!$data = $category_model->readOne()) {
                    $result['exception'] = 'The category does not exist';
                } elseif (!$category_model->setCategoryName($_POST['category_name'])) {
                    $result['exception'] = 'Wrong name';
                } elseif (!$category_model->setCategoryDescription($_POST['category_description'])) {
                    $result['exception'] = 'Wrong description';
                } elseif (!is_uploaded_file($_FILES['imageCategories']['tmp_name'])) {
                    if ($category_model->updateRow($data['imagen_categoria'])) {
                        $result['status'] = 1;
                        $Result['message'] = 'The user was updated successfully';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$category_model->setCategoryImg($_FILES['imageCategories'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($category_model->updateRow($data['imagen_categoria'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageCategories'], $category_model->getRoute(), $category_model->getCategoryImg())) {
                        $Result['message'] = 'The user was updated successfully';
                    } else {
                        $Result['message'] = 'The user was updated without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //This action is to delete data of the category
            case 'delete':
                if (!$category_model->setId($_POST['id_categoria'])) {
                    $result['exception'] = 'Wrong category';
                } elseif (!$data = $category_model->readOne()) {
                    $result['exception'] = 'The category does not exist';
                } elseif ($category_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The category was deleted successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Case default if anything is executed
            default:
                $result['exception'] = 'This action cant be performed in the session';
        }
        //indicate the tyoe of the content to show and yours respective strings
        header('content-type: application/json; charset=utf-8');
        //Show the result in format JSON and return at the controller
        print(json_encode($result));
    } else {
        print(json_encode('Access denied'));
    }
} else {
    //If nothing are compilating, the api show this message in format JSON
    print(json_encode('File unavaliable'));
}