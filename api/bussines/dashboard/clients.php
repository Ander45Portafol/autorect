<?php
//This url is to use data, of the atributes and queries through dependecies
require_once('../../enitites/dto/clients.php');

//This if is to validate the action is to do
if (isset($_GET['action'])) {
    session_start();
    //Object to mecioned functions of the queries, through this object
    $client_model = new Client;
    //This variable is to show the answer at the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Is to verficate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Is to verificated that action is to do
        switch ($_GET['action']) {
            //This action is to capture the client data
            case 'readAll':
                if ($result['dataset'] = $client_model->readAll()) {
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
                    $result['dataset'] = $client_model->readAll();
                } elseif ($result['dataset'] = $client_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data to show';
                }
                break;
            //This action is to delete data of the client
            case 'delete':
                if (!$client_model->setCLientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Wrong client';
                } elseif (!$data = $client_model->readOne()) {
                    $result['exception'] = 'The client does not exist';
                } elseif ($client_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The client was deleted successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Case default if anything is executed
            default:
                $result['exception'] = 'This action cant be performed in the session';
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