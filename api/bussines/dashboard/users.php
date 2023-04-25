<?php
//This url is to use data, of the atributes and queries through dependecies
require_once('../../enitites/dto/users.php');
//This if is to validate the action is to do
if (isset($_GET['action'])) {
    session_start();
    //Object to mecioned functions of the queries, through this object
    $user_model = new User;
    //This variable is to show the answer at the actions
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    //Is to verficate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        //Is to verificated that action is to do
        switch ($_GET['action']) {
                //This action is to capture the user data
            case 'getUser':
                if (isset($_SESSION['nombre_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['nombre_usuario'];
                }
                break;
                //This action is to close session
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesion eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrio un problema al cerrar la sesion';
                }
                break;
                //This action is to show all data of the user
            case 'readProfile':
                if ($reuslt['dataset'] = $user->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                //In this action to can edit all data respective at the user
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$user_model->setUser($_POST[''])) {
                    # code...
                }
                break;
                //This action is to could change your password
            case 'changePassword':
                break;
                //This action is to charger datas in the table
            case 'readAll':
                if ($result['dataset'] = $user_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
                //This action is to show the employees data in te select
            case 'readEmployees':
                if ($result['dataset'] = $user_model->readEmployees()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se logran cargar los datos';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
                //This action is to show the types of users data in te select
            case 'readType_Users':
                if ($result['dataset'] = $user_model->readType_Users()) {
                    $result['status'] = 1;
                    $result['message'] = 'Se logran cargar los datos';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
                //This action is to search the especific data
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1; 
                    $result['dataset'] = $user_model->readAll(); 
                } elseif ($result['dataset'] = $user_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Si se encontraron resultados';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay coincidencias';
                }
                break;
                //This action is to create a new user and verificate data to send at the queries file
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$user_model->setUser($_POST['username'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$user_model->setEstadoUser(isset($_POST['state_user']) ? 1 : 0)) {
                    $result['exception'] = 'Estado Incorrecto';
                } elseif (!isset($_POST['employee'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$user_model->setEmpleado($_POST['employee'])) {
                    $result['exception'] = 'Empleado incorrecto';
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
                //This action is verificate the exists of the user
            case 'readOne':
                if (!$user_model->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto readOne';
                } elseif ($result['dataset'] = $user_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                //This action is to update a user and verificate data to send at the queries file
            case 'update':
                $_POST = Validator::validateForm(($_POST));
                if (!$user_model->setId($_POST['id'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$data = $user_model->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif (!$user_model->setUser($_POST['username'])) {
                    $result['exception'] = 'Nombre de usuario incorrecto';
                } elseif (!$user_model->setPassword($_POST['password'])) {
                    $result['exception'] = 'Contraseña incorrecta';
                } elseif (!$user_model->setEstadoUser(isset($_POST['state_user']) ? 1 : 0)) {
                    $result['exception'] = 'Estado de usuario incorrecto';
                } elseif (!$user_model->setEmpleado($_POST['employee'])) {
                    $result['exception'] = 'Seleccione un empleado';
                } elseif (!$user_model->setTipo_User($_POST['user_type'])) {
                    $result['exception'] = 'Seleccione un tipo de usuario';
                } elseif (!is_uploaded_file($_FILES['imageUser']['tmp_name'])) {
                    if ($user_model->updateRow($data['imagen_usuario'])) {
                        $result['status'] = 1;
                        $Result['message'] = 'Usuario actualizado, correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$user_model->setImagen($_FILES['imageUser'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($user_model->updateRow($data['imagen_usuario'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageUser'], $user_model->getRuta(), $user_model->getImagen())) {
                        $Result['message'] = 'Usuario actualizado, correctamente';
                    } else {
                        $Result['message'] = 'Usuario actualizado, pero no se guardo la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //This action is to delete data of the user
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'No se puede eliminar a si mismo';
                } elseif (!$user_model->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif (!$user_model->readOne()) {
                    $result['exception'] = 'Usuario inexistente';
                } elseif ($user_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Usuario eliminado, Correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Case default if anything is executed
            default:
                $result['exception'] = 'Accion no disponible dentro de la sesion';
                break;
        }
    } else {
        //This switch is to validate actions when the session is not active
        switch ($_GET['action']) {
            //This action is to validate if exists users
            case 'readUsers':
                if (!$user_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
                //This action is when don't exists users and this process is to create the first user
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setUser($_POST[''])) {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
                //This action is to validate the users data like username and password, to active the session
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$user_model->checkUser($_POST['username'])) {
                    $result['exception'] = 'Usuario incorrecto';
                } elseif ($user_model->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Autenticacion correcta';
                    $_SESSION['id_usuario'] = $user_model->getId();
                    $_SESSION['nombre_usuario'] = $user_model->getUser();
                } else {
                    $result['exception'] = 'Clave incorrecta';
                }
                break;
                //If any action is realized is active the default action
            default:
                $result['exception'] = 'Accion no disponible fuera de la sesion';
                break;
        }
    }
    //indicate the tyoe of the content to show and yours respective strings
    header('content-type: application/json; charset=utf-8');
    //Show the result in format JSON and return at the controller
    print(json_encode($result));
} else {
    //If nothing are compilating, the api show this message in format JSON
    print(json_encode('Recurso no disponible'));
}
