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
                    $result['exception'] = 'empleado incorrecto';
                } elseif ($result['dataset'] = $employee_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'empleado inexistente';
                }
                break;
            case 'readTypes':
                if ($result['dataset'] = $employee_model->readTypes()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['exception'] = 'Ingrese un valor para buscar';
                } elseif ($result['dataset'] = $employee_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$employee_model->setEmployeeName($_POST['employee_name'])) {
                    $result['exception'] = 'name incorrecto';
                } elseif (!$employee_model->setLastname($_POST['employee_lastname'])) {
                    $result['exception'] = 'lastname Incorrecto';
                } elseif (!$employee_model->setEmployeeDUI($_POST['employee_dui'])) {
                    $result['exception'] = 'dui incorrecto';
                }elseif (!$employee_model->setEmployeeMail($_POST['employee_email'])) {
                    $result['exception'] = 'Email incorrecto';
                } elseif (!$employee_model->setEmployeePhone($_POST['employee_phone'])) {
                    $result['exception'] = 'phone incorrecto';
                } elseif (!$employee_model->setEmployeeDate($_POST['employee_date'])) {
                    $result['exception'] = 'Fecha incorrecto';
                } elseif (!$employee_model->setEmployeeAddress($_POST['employee_address'])) {
                    $result['exception'] = 'Address incorrecta';
                }elseif (!$employee_model->setEmployeeStatus(isset($_POST['state-employee']) ? 1 : 0)) {
                    $result['exception'] = 'Estado Incorrecto';
                }elseif (!$employee_model->setEmployeeType($_POST['Types'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif (!isset($_POST['Types'])) {
                    $result['exception'] = 'Selecciona un tipo de usuario';
                } elseif ($employee_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Employee creado, correctamente';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$employee_model->setId($_POST['id'])) {
                    $reuslt['exception'] = 'Employee incorrecto';
                } elseif (!$data = $employee_model->readOne()) {
                    $result['exception'] = 'Employee inexistente';
                } elseif (!$employee_model->setEmployeeName($_POST['employee_name'])) {
                    $result['exception'] = 'Name Incorrecto';
                }elseif (!$employee_model->setLastname($_POST['employee_lastname'])) {
                    $result['exception'] = 'LastName Incorrecto';
                } elseif (!$employee_model->setEmployeeDUI($_POST['employee_dui'])) {
                    $result['exception'] = 'dui incorrecto';
                }elseif (!$employee_model->setEmployeeMail($_POST['employee_email'])) {
                    $result['exception'] = 'Email incorrecto';
                } elseif (!$employee_model->setEmployeePhone($_POST['employee_phone'])) {
                    $result['exception'] = 'phone incorrecto';
                } elseif (!$employee_model->setEmployeeDate($_POST['employee_date'])) {
                    $result['exception'] = 'Fecha incorrecto';
                }elseif (!$employee_model->setEmployeeAddress($_POST['employee_address'])) {
                    $result['exception'] = 'Address incorrecta';
                }elseif (!$employee_model->setEmployeeStatus(isset($_POST['state-employee']) ? 1 : 0)) {
                    $result['exception'] = 'Estado Incorrecto';
                } elseif (!$employee_model->setEmployeeType($_POST['Types'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif (!isset($_POST['Types'])) {
                    $result['exception'] = 'Selecciona un tipo de usuario';
                } elseif ($employee_model->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Employee actualizado, correctamente';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Error en la actualizacion de data';
                }
                break;
            case 'delete':
                if (!$employee_model->setId($_POST['id_empleado'])) {
                    $result['exception'] = 'El empleado es incorrecto';
                } elseif (!$data = $employee_model->readOne()) {
                    $result['exception'] = 'El empleado seleccionado, no existe';
                } elseif ($employee_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Eliminado, correctamente';
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
    print(json_encode('The file is not avaliable'));
}