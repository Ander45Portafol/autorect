<?php
require_once('../../enitites/dto/users.php');
//Se comprueba si existe una accion a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    //Se crea una sesion o se reanuda la actual para poder utilizar variables de sesion en el script.
    session_start();
    // Se instancia la clase correspondiente
    $user_model = new User;
    //se declara e inicializa un arreglo para guardar el resultado que retorna de la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    //Se verifica si existe una sesion iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        //Se compara la accion a realizar cuando un adminisrtrador ha iniciado sesion.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['nombre_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['nombre_usuario'];
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesion eliminada correctamente';
                } else {
                    $result['exception'] = 'Ocurrio un problema al cerrar la sesion';
                }
                break;
            case 'readProfile':
                if ($reuslt['dataset'] = $user->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Usuario inexistente';
                }
                break;
                //Esta parte esta en proceso
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$user_model->setUser($_POST[''])) {
                    # code...
                }
                break;
            case 'changePassword':
                break;
            case 'readAll':
                if ($result['dataset'] = $user_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen' . count($result['dataset']) . 'registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'search':
                break;
            case 'create':
                break;
            case 'readOne':
                break;
            case 'update':
                break;
            case 'delete':
                break;
            default:
                $result['exception'] = 'Accion no disponible dentro de la sesion';
                break;
        }
    } else {
        switch ($_GET['action']) {
            case 'readUsers':
                if ($user_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    $result['exception'] = 'Debe crear un usuario para comenzar';
                }
                break;
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setUser($_POST[''])) {
                    $result['exception'] = 'Usuario incorrecto';
                }
                break;
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
            default:
                $result['exception'] = 'Accion no disponible fuera de la sesion';
                break;
        }
    }
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
