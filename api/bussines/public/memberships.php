<?php
require_once('../../entities/dto/memberships.php');

// It checks if there is an action to perform, otherwise the script ends with an error message.
if (isset($_GET['action'])) {
    // A session is created or the current one is resumed in order to use session variables in the script.
    session_start();
    // The corresponding class is instantiated.
    $membership_model = new Membership();
    // An array is declared and initialized to store the result returned by the API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null);
    // The action to perform when a client has logged in is compared.
    switch ($_GET['action']) {
        case 'readPay':
            if ($result['dataset'] = $membership_model->readPay()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No existen membresias para mostrar';
            }
            break;
        case 'readImgs':
            if ($result['dataset'] = $membership_model->readImgs()) {
                $result['status'] = 1;
            } elseif (Database::getException()) {
                $result['exception'] = Database::getException();
            } else {
                $result['exception'] = 'No existen imagenes para mostrar';
            }
            break;
        default:
            $result['exception'] = 'Acción no disponible';
    }
    // The type of content to be displayed and its respective set of characters are indicated.
    header('Content-Type: application/json; charset=utf-8');
    // The result is printed in JSON format and returned to the controller.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}