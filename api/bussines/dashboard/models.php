<?php
//This url is to use data, of the atributes and queries through dependecies
require_once('../../enitites/dto/models.php');
//This if is to validate the action is to do
if (isset($_GET['action'])) {
    session_start();
    //Object to mecioned functions of the queries, through this object
    $models_model = new Model;
    //This variable is to show the answer at the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Is to verficate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Is to verificated that action is to do
        switch ($_GET['action']) {
            //This action is to charger datas in the table
            case 'readAll':
                if ($result['dataset'] = $models_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'No data to show';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            //This action is verificate the exists of the model
            case 'readOne':
                if (!$models_model->setId($_POST['id'])) {
                    $result['exception'] = 'Wrong model';
                } elseif ($result['dataset'] = $models_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The model does not exist';
                }
                break;
            //This action is to show the brand data in te select
            case 'readBrand':
                if ($result['dataset'] = $models_model->readBrand()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data wasfound';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            //This action is to create a new model and verificate data to send at the queries file
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$models_model->setModelName($_POST['ModelName'])) {
                    $result['exception'] = 'Wrong model name';
                } elseif (!$models_model->setModelYear($_POST['ModelYear'])) {
                    $result['exception'] = 'Wrong model year';
                } elseif (!isset($_POST['Brand'])) {
                    $result['exception'] = 'Select a model';
                } elseif (!$models_model->setModelBrand($_POST['Brand'])) {
                    $result['exception'] = 'Wrong model brand';
                } elseif ($models_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The model was created successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //This action is to update a model and verificate data to send at the queries file
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$models_model->setID($_POST['id'])) {
                    $result['exception'] = 'Wrong model';
                } elseif (!$data = $models_model->readOne()) {
                    $result['exception'] = 'The model does not exist';
                } elseif (!$models_model->setModelName($_POST['ModelName'])) {
                    $result['exception'] = 'Wrond model name';
                } elseif (!$models_model->setModelYear($_POST['ModelYear'])) {
                    $result['exception'] = 'Wrond model year';
                } elseif (!isset($_POST['Brand'])) {
                    $result['exception'] = 'Select a model';
                } elseif (!$models_model->setModelBrand($_POST['Brand'])) {
                    $result['exception'] = 'Wrong model brand';
                } elseif ($models_model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The model was updated successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //This action is to delete data of the model
            case 'delete':
                if (!$models_model->setID($_POST['id_modelo'])) {
                    $result['exception'] = 'Wrong model';
                } elseif (!$data = $models_model->readOne()) {
                    $result['exception'] = 'The model does not exist';
                } elseif ($models_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The model was deleted successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //This action is to search the especific data
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $models_model->readAll();
                } elseif ($result['dataset'] = $models_model->searchRow($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data was found';
                }
                break;
            //Case default if anything is executed
            default:
                $result['exception'] = 'The action can not be performed';
                break;
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