<?php
require_once('../../entities/dto/contacts.php');
require_once('../../mails/email.php');

// It checks if there is an action to perform, otherwise the script ends with an error message.
if (isset($_GET['action'])) {
    // A session is created or the current one is resumed in order to use session variables in the script.
    session_start();
    // The corresponding class is instantiated.
    $contact_model = new Contact;
    $mail = new Email;
    // An array is declared and initialized to store the result returned by the API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'mail' => null);
    // It is verified if there is a session started as a client to carry out the corresponding actions.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // The action to perform when a client has logged in is compared.
        switch ($_GET['action']) {
            case 'sendMail':
                if (!$contact_model->setContactingEmail($_POST['emailinput'])) {
                    $result['exception'] = 'Wrong email';
                } elseif (!$contact_model->setMessage($_POST['messageinput'])) {
                    $result['exception'] = 'Message is too long';
                } elseif (!$contact_model->setClientId($_POST['idinput'])) {
                    $result['exception'] = 'Wrong ID';
                } elseif ($contact_model->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'The mail was created successfully';
                    $result['mail'] = $mail->sendMail($_POST['emailinput'], $_POST['nameinput'], $_POST['messageinput']);
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible';
        }
        // The type of content to be displayed and its respective set of characters are indicated.
        header('content-type: application/json; charset=utf-8');
        // The result is printed in JSON format and returned to the controller.
        print(json_encode($result));
    } else {
        print(json_encode('Recurso no disponible'));
    }
}