<?php
require_once('../../entities/dto/contacts.php');
require_once('../../mails/email.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $contact_model = new Contact;
    $mail = new Email;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'recaptcha' => 0, 'message' => null, 'exception' => null, 'mail' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['id_cliente'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un cliente ha iniciado sesión.
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
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Recurso no disponible'));
    }
}