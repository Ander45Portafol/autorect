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
                } elseif (!$employee_model->setEmployeePhone($_POST['employee_phone'])) {
                    $result['exception'] = 'phone incorrecto';
                } elseif (!isset($_POST['user_type'])) {
                    $result['exception'] = 'Selecciona un tipo de usuario';
                } elseif (!$user_model->setTipo_User($_POST['user_type'])) {
                    $result['exception'] = 'Tipo de usuario incorrecto';
                } elseif (!$user_model->setPassword($_POST['password'])) {
                    $result['exception'] = Validator::getAPasswordError();
                } elseif (!is_uploaded_file($_FILES['imageUser']['tmp_name'])) {
                    $result['exception'] = 'Selecione una imagen';
                } elseif (!$user_model->setImagen($_FILES['imageUser'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($user_model->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageUser'], $user_model->getRuta(), $user_model->getImagen())) {
                        $result['message'] = 'Usuario creado, correctamente';
                    } else {
                        $result['message'] = 'Usuario creado, pero sin la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                case 'delete':
                    if (!$employee_model->setId($_POST['id_empleado'])) {
                        $result['exception']='El empleado es incorrecto';
                    }elseif (!$data=$employee_model->readOne()) {
                        $result['exception']='El empleado seleccionado, no existe';
                    }elseif ($employee_model->deleteRow()) {
                        $result['status']=1;
                        $result['message']='Eliminado, correctamente';
                    }else {
                        $result['exception']=Database::getException();
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