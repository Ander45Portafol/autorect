<?php
require_once('../../entities/dto/clients.php');

// It checks if there is an action to perform, otherwise the script ends with an error message.
if (isset($_GET['action'])) {
    // A session is created or the current one is resumed in order to use session variables in the script.
    session_start();
    // The corresponding class is instantiated.
    $client_model = new Client;
    // An array is declared and initialized to hold the result returned by the API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'username' => null, 'fullname' => null, 'id' => 0);
    // It is verified if there is a session started as a client to carry out the corresponding actions.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // The action to perform when a client has logged in is compared.
        switch ($_GET['action']) {
            case 'getUser':
                if (isset($_SESSION['usuario_cliente'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['usuario_cliente'];
                    $result['fullname'] = $_SESSION['nombre_completo_cliente'];
                    $result['id'] = $_SESSION['id_cliente'];
                } else {
                    $result['exception'] = 'User, undifined';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Close session';
                } else {
                    $result['exception'] = 'Problems to close session';
                }
                break;
            case 'readOne':
                if (!$client_model->setCLientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Wrong client';
                } elseif ($result['dataset'] = $client_model->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'readActualMembership':
                if (!$client_model->setCLientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Wrong client';
                } elseif ($result['dataset'] = $client_model->readActualMembership()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Error';
                }
                break;
            case 'updateMembership':
                $_POST = Validator::validateForm($_POST);
                if (!$client_model->setCLientId($_POST['id_cliente'])) {
                    $result['exception'] = 'Wrong client';
                } elseif (!$client_model->setMembershipType($_POST['id_tipo_membresia'])) {
                    $result['exception'] = 'Wrong membership type';
                } elseif ($client_model->updateMembership()) {
                    $result['status'] = 1;
                    $result['message'] = 'Thank you for your purchase!';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Action not disposable  inside of the session';
        }
    } else {
        // The action to perform when the client is not logged in is compared.
        switch ($_GET['action']) {
            case 'signup':
                $_POST = Validator::validateForm($_POST);
                if (!$client_model->setName($_POST['firstname'])) {
                    $result['exception'] = 'Wrong name';
                } elseif (!$client_model->setLastname($_POST['lastname'])) {
                    $result['exception'] = 'Wrong lastname';
                } elseif (!$client_model->setClientMail($_POST['email'])) {
                    $result['exception'] = 'Wrong mail';
                } elseif (!$client_model->setClientPhone($_POST['phone'])) {
                    $result['exception'] = 'Wrong phone number';
                } elseif ($_POST['password'] != $_POST['confirm_password']) {
                    $result['exception'] = 'Invalid password';
                } elseif (!$client_model->setPassword($_POST['password'])) {
                    $result['exception'] = Validator::getAPasswordError();
                } elseif ($client_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Succesfull, to register user';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            case 'login':
                $_POST = Validator::validateForm($_POST);
                if (!$client_model->checkUser($_POST['username'])) {
                    $result['exception'] = 'Wrong username';
                } elseif (!$client_model->getStatus()) {
                    $result['exception'] = 'Account is desactive';
                } elseif ($client_model->checkPassword($_POST['password'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Correct';
                    $_SESSION['id_cliente'] = $client_model->getId();
                    $_SESSION['usuario_cliente'] = $client_model->getUsername();
                    $_SESSION['nombre_completo_cliente'] = $client_model->getName() . ' ' . $client_model->getLastname();
                } else {
                    $result['exception'] = 'Invalide Password';
                }
                break;
            default:
                $result['exception'] = 'Action not dispossable outside of the session';
        }
    }
    // The type of content to be displayed and its respective set of characters are indicated.
    header('content-type: application/json; charset=utf-8');
    // The result is printed in JSON format and returned to the controller.
    print(json_encode($result));
} else {
    print(json_encode('Resource not dispossable'));
}