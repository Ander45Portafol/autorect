<?php

//Dependencies
require_once('../../entities/dto/employee.php');

//Validate what action is being done
if (isset($_GET['action'])) {
    session_start();
    //Object to mention the functions of the queries
    $employee_model = new Employee;
    //Variable to show the answer of the actions
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    //Validate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        //Actions
        switch ($_GET['action']) {
            //Action to fill the table
            case 'readAll':
                if ($result['dataset'] = $employee_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data to show';
                }
                break;
            //Action to read one employee
            case 'readOne':
                if (!$employee_model->setId($_POST['id'])) {
                    $result['exception'] = 'Wrong employee';
                } elseif ($result['dataset'] = $employee_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The employee does not exist';
                }
                break;
            //Action to read the types of employees
            case 'readTypes':
                if ($result['dataset'] = $employee_model->readTypes()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to search employees
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $employee_model->readAll();
                } elseif ($result['dataset'] = $employee_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data to show';
                }
                break;
            //Action to create a employee
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$employee_model->setEmployeeName($_POST['employee_name'])) {
                    $result['exception'] = 'Wrong name';
                } elseif (!$employee_model->setLastname($_POST['employee_lastname'])) {
                    $result['exception'] = 'Wrong lastname';
                } elseif (!$employee_model->setEmployeeDUI($_POST['employee_dui'])) {
                    $result['exception'] = 'Wrong DUI';
                } elseif (!$employee_model->setEmployeeMail($_POST['employee_email'])) {
                    $result['exception'] = 'Wrong Email';
                } elseif (!$employee_model->setEmployeePhone($_POST['employee_phone'])) {
                    $result['exception'] = 'Wrong phone number';
                } elseif (!$employee_model->setEmployeeDate($_POST['employee_date'])) {
                    $result['exception'] = 'Wrong date';
                } elseif (!$employee_model->setEmployeeAddress($_POST['employee_address'])) {
                    $result['exception'] = 'Wrong address';
                } elseif (!$employee_model->setEmployeeStatus(isset($_POST['state-employee']) ? 1 : 0)) {
                    $result['exception'] = 'Wrong status';
                } elseif (!$employee_model->setEmployeeType($_POST['Types'])) {
                    $result['exception'] = 'Wrong user type';
                } elseif (!isset($_POST['Types'])) {
                    $result['exception'] = 'Select a type';
                } elseif ($employee_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The employee was created successfully';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            //Action to update a employee
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$employee_model->setId($_POST['id'])) {
                    $reuslt['exception'] = 'Wrong employee';
                } elseif (!$data = $employee_model->readOne()) {
                    $result['exception'] = 'The employee does not exist';
                } elseif (!$employee_model->setEmployeeName($_POST['employee_name'])) {
                    $result['exception'] = 'Wrong name';
                } elseif (!$employee_model->setLastname($_POST['employee_lastname'])) {
                    $result['exception'] = 'Wrong lastname';
                } elseif (!$employee_model->setEmployeeDUI($_POST['employee_dui'])) {
                    $result['exception'] = 'Wrong DUI';
                } elseif (!$employee_model->setEmployeeMail($_POST['employee_email'])) {
                    $result['exception'] = 'Wrong Email';
                } elseif (!$employee_model->setEmployeePhone($_POST['employee_phone'])) {
                    $result['exception'] = 'Wrong phone number';
                } elseif (!$employee_model->setEmployeeDate($_POST['employee_date'])) {
                    $result['exception'] = 'Wrong date';
                } elseif (!$employee_model->setEmployeeAddress($_POST['employee_address'])) {
                    $result['exception'] = 'Wrong address';
                } elseif (!$employee_model->setEmployeeStatus(isset($_POST['state-employee']) ? 1 : 0)) {
                    $result['exception'] = 'Wrong status';
                } elseif (!$employee_model->setEmployeeType($_POST['Types'])) {
                    $result['exception'] = 'Wrong user type';
                } elseif (!isset($_POST['Types'])) {
                    $result['exception'] = 'Select a type';
                } elseif ($employee_model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The employee was updated successfully';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'There was an error on update proccess';
                }
                break;
            //Action to delete a employee
            case 'delete':
                if (!$employee_model->setId($_POST['id_empleado'])) {
                    $result['exception'] = 'Wrong employee';
                } elseif (!$data = $employee_model->readOne()) {
                    $result['exception'] = 'The employee does not exist';
                } elseif ($employee_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The employee was deleted successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Default case if the action being performed does not exist
            default:
                $result['exception'] = 'The action can not be performed';
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
    print(json_encode('File unavaliable'));
}