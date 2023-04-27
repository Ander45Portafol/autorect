<?php

require_once('../../enitites/dto/employee.php');

if (isset($_GET['action'])) {
    session_start();
    $employee_model = new Employee;
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    if (isset($_SESSION['id_usuario'])) {
        switch ($_GET['action']) {
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
            case 'readTypes':
                if ($result['dataset'] = $employee_model->readTypes()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
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
            default:
                $result['exception'] = 'The action can not be performed';
                break;
        }
        print(json_encode($result));
    } else {
        print(json_encode('Access denied'));
    }
} else {
    print(json_encode('File unavaliable'));
}