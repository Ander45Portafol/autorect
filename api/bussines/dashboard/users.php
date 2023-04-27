<?php
//Dependencies
require_once('../../entities/dto/users.php');

//Validate what action is being done
if (isset($_GET['action'])) {
    session_start();
    //Object to mention the functions of the queries
    $user_model = new User;
    //Variable to show the answer of the actions
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'exception' => null, 'dataset' => null, 'username' => null);
    //Validate if the session is started
    if (isset($_SESSION['id_usuario'])) {
        $result['session'] = 1;
        //Actions
        switch ($_GET['action']) {
            //Action to get the active user
            case 'getUser':
                if (isset($_SESSION['nombre_usuario'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['nombre_usuario'];
                }
                break;
            //Action to log out
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'The session was deleted successfully';
                } else {
                    $result['exception'] = 'There was a problem with the session';
                }
                break;
            //Action to read the user data
            case 'readProfile':
                if ($reuslt['dataset'] = $user->readProfile()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The user does not exist';
                }
                break;
            //Action to edit the data of the user
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (!$user_model->setUserName($_POST[''])) {
                    # code...
                }
                break;
            //Action to change the password
            case 'changePassword':
                break;
            //Action to fill the table
            case 'readAll':
                if ($result['dataset'] = $user_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to read the employees
            case 'readEmployees':
                if ($result['dataset'] = $user_model->readEmployees()) {
                    $result['status'] = 1;
                    $result['message'] = 'The data was loaded';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to read the users types
            case 'readType_Users':
                if ($result['dataset'] = $user_model->readType_Users()) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to search for users
            case 'search':
                $_POST = Validator::validateForm($_POST);
                if ($_POST['search'] == '') {
                    $result['status'] = 1;
                    $result['dataset'] = $user_model->readAll();
                } elseif ($result['dataset'] = $user_model->searchRows($_POST['search'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Data was found';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No data';
                }
                break;
            //Action to create a user
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$user_model->setUserName($_POST['username'])) {
                    $result['exception'] = 'The user does not exist';
                } elseif (!$user_model->setUserStatus(isset($_POST['state_user']) ? 1 : 0)) {
                    $result['exception'] = 'Wrong status';
                } elseif (!isset($_POST['employee'])) {
                    $result['exception'] = 'Select an employee';
                } elseif (!$user_model->setEmployee($_POST['employee'])) {
                    $result['exception'] = 'Wrong employee';
                } elseif (!isset($_POST['user_type'])) {
                    $result['exception'] = 'Select an user type';
                } elseif (!$user_model->setUserType($_POST['user_type'])) {
                    $result['exception'] = 'The type is incorrect';
                } elseif (!$user_model->setPasswordUser($_POST['password'])) {
                    $result['exception'] = Validator::getAPasswordError();
                } elseif (!is_uploaded_file($_FILES['imageUser']['tmp_name'])) {
                    $result['exception'] = 'Select an image';
                } elseif (!$user_model->setImgUser($_FILES['imageUser'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($user_model->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageUser'], $user_model->getRoute(), $user_model->getUserImg())) {
                        $result['message'] = 'The user was created successfully';
                    } else {
                        $result['message'] = 'The user was created without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to read one user
            case 'readOne':
                if (!$user_model->setId($_POST['id'])) {
                    $result['exception'] = 'Wrong user';
                } elseif ($result['dataset'] = $user_model->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'The user does not exist';
                }
                break;
            //Action to update a user
            case 'update':
                $_POST = Validator::validateForm(($_POST));
                if (!$user_model->setId($_POST['id'])) {
                    $result['exception'] = 'Wrong user';
                } elseif (!$data = $user_model->readOne()) {
                    $result['exception'] = 'The user does not exist';
                } elseif (!$user_model->setUserName($_POST['username'])) {
                    $result['exception'] = 'Wrong username';
                } elseif (!$user_model->setPasswordUser($_POST['password'])) {
                    $result['exception'] = 'Wrong password';
                } elseif (!$user_model->setUserStatus(isset($_POST['state_user']) ? 1 : 0)) {
                    $result['exception'] = 'Wrong status';
                } elseif (!$user_model->setEmployee($_POST['employee'])) {
                    $result['exception'] = 'Select an employee';
                } elseif (!$user_model->setUserType($_POST['user_type'])) {
                    $result['exception'] = 'Select an user type';
                } elseif (!is_uploaded_file($_FILES['imageUser']['tmp_name'])) {
                    if ($user_model->updateRow($data['imagen_usuario'])) {
                        $result['status'] = 1;
                        $Result['message'] = 'THe user was updated successfully';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$user_model->setImgUser($_FILES['imageUser'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($user_model->updateRow($data['imagen_usuario'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['imageUser'], $user_model->getRoute(), $user_model->getUserImg())) {
                        $Result['message'] = 'The user was updated successfully';
                    } else {
                        $Result['message'] = 'The user was updated without image';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Action to delete a user
            case 'delete':
                if ($_POST['id_usuario'] == $_SESSION['id_usuario']) {
                    $result['exception'] = 'You can delete your user';
                } elseif (!$user_model->setId($_POST['id_usuario'])) {
                    $result['exception'] = 'Wrong user';
                } elseif (!$user_model->readOne()) {
                    $result['exception'] = 'The user does not exist';
                } elseif ($user_model->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The user was deleted successfully';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            //Case default if anything is executed
            default:
                $result['exception'] = 'The action can not be performed';
            break;
        }
    } else {
        //This switch is to validate actions when the session is not active
        switch ($_GET['action']) {
            //This action is to validate if exists users
            case 'readUsers':
                if ($user_model->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'You must authenticate to login';
                } else {
                    $result['exception'] = 'Have to create an user to login';
                }
                break;
            //This action is when don't exists users and this process is to create the first user
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$user->setUser($_POST[''])) {
                    $result['exception'] = 'Wrong user';
                }
                break;
            //This action is to validate the users data like username and password, to active the session
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$user_model->checkUser($_POST['username'])) {
                    $result['exception'] = 'Wrong username';
                } elseif ($user_model->checkPassword($_POST['clave'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Login successfully';
                    $_SESSION['id_usuario'] = $user_model->getId();
                    $_SESSION['nombre_usuario'] = $user_model->getUserName();
                } else {
                    $result['exception'] = 'Wrong password';
                }
                break;
            //Default case if the action being performed does not exist
            default:
                $result['exception'] = 'The action can not be performed';
                break;
        }
    }
    //Indicate the content type
    header('content-type: application/json; charset=utf-8');
    //Show the result in format JSON and return at the controller
    print(json_encode($result));
} else {
    //If nothing are compilating, the api show this message in format JSON
    print(json_encode('File unavaliable'));
}