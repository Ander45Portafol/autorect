<?php
//Dependencies
require_once('../../entities/dto/brands.php');

//Validate what action is being done
if (isset($_GET['action'])) {
    session_start();
    //Object to mention the functions of the queries
    $brand_model = new Brand;
    //Variable to show the answer of the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Validate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Actions
        switch ($_GET['action']) {
            //Action to fill the table
            case 'readAll':
                if ($result['dataset'] = $brand_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = count($result['dataset']) . 'was founded';
                } else if (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No info to show';
                }
                break;
            //Action to read one brand
            case 'readOne':
                if (!$brand_model->setID($_POST['id'])) {
                    $result['exception'] = 'The brand was incorrect';
                } elseif ($result['dataset'] = $brand_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The brand does not exist';
                }
                break;
            //Action to search brands
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $brand_model->readAll();
                } elseif ($result['dataset'] = $brand_model->searchRow($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            //Action to create a brand
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$brand_model->setBrandName($_POST['BrandName'])) {
                    $result['exception'] = 'There was an error with the brand name';
                } elseif (!$brand_model->setBrandLogo($_FILES['imageBrand'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($brand_model->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageBrand'], $brand_model->getRoute(), $brand_model->getLogo())) {
                        $result['message'] = 'The brand was created successfully';
                    } else {
                        $result['message'] = 'Brand created without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to update a brand
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$brand_model->setID($_POST['id'])) {
                    $result['exception'] = 'The brand does not exist';
                } else if (!$data = $brand_model->readOne()) {
                    $result['exception'] = 'The data does not exist';
                } else if (!$brand_model->setBrandName($_POST['BrandName'])) {
                    $result['exception'] = 'There was an error with the brand name';
                } elseif (!is_uploaded_file($_FILES['imageBrand']['tmp_name'])) {
                    if ($brand_model->updateRow($data['logo_marca'])) {
                        $result['status'] = 1;
                        $Result['message'] = 'The brand was updated successfully';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$brand_model->setBrandLogo($_FILES['imageBrand'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($brand_model->updateRow($data['logo_marca'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageBrand'], $brand_model->getRoute(), $brand_model->getLogo())) {
                        $Result['message'] = 'The brand was updated successfully';
                    } else {
                        $Result['message'] = 'The brand was updated without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to delete a brand
            case 'delete':
                if (!$brand_model->setID($_POST['id_marca'])) {
                    $result['exception'] = 'The brand was incorrect';
                } else if (!$data = $brand_model->readOne()) {
                    $result['exception'] = 'The selected brand does not exist';
                } else if ($brand_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The brand was deleted';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Default case if the action being performed does not exist
            default:
                $result['exception'] = 'The action was not avaliable';
                break;
        }
        //Indicate the content type
        header('content-type: application/json; charset=utf-8');
        //Show the result in format JSON and return at the controller
        print(json_encode($result));
    } else {
        print(json_encode('Access denied'));
    }
} else {
    //If nothing is compilating, the api show this message in format JSON
    print(json_encode('Recurso no disponible'));
}