<?php
// import file to charger the template of report
require_once('../../helpers/report.php');
// import files to get datas
require_once('../../entities/dto/clients.php');
require_once('../../entities/dto/users.php');

// variable to acces at report functions
$pdf = new Report;
// Here append the title of the report
$pdf->startReport('Clients at membership type');
// variable to get clients datas
$client = new Client;
// variable to get user data
$user = new User;
// Validate if exists some Membership type
if ($dataMemberTypes = $client->readAllMembresieTypes()) {
    //Design to show user data
    $pdf->setFillColor(255);
    $pdf->SetTextColor(0);
    $pdf->setFont('Arial', '', 12);
    // Set the atribute id at user to search at which employee appertain
    if ($user->setId($_SESSION['id_usuario'])) {
        if ($dataUser = $user->searchEmployee()) {  
            //Get the full name of the employee
            $nombre_employee = $dataUser['nombre_completo_empleado'];
            $pdf->Cell(48, 10, 'Employee full name: ', 0, 0,);
            $pdf->Cell(140, 10, $nombre_employee, 0, 1,);
            $pdf->Cell(0, 5, '', 0, 1);
        }
    }
    // design to headers
    $pdf->setFillColor(0);
    $pdf->SetTextColor(255);
    $pdf->setFont('Times', 'B', 11);
    // Headers at the table.
    $pdf->cell(96, 10, 'Full name', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Dui', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Phone', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Status', 1, 1, 'C', 1);

    // Design to show memebership
    $pdf->setFillColor(252);
    $pdf->SetTextColor(0);
    $pdf->setFont('Times', '', 11);

    // show data to row by row
    foreach ($dataMemberTypes as $rowMembership) {
        //Design to cells in the data of the membership
        $pdf->SetFillColor(230, 230, 230);
        $pdf->SetTextColor(0);
        $pdf->cell(0, 10, $pdf->encodeString('Membership type: ' . $rowMembership['tipo_membresia']), 1, 1, 'C', 1);
        // variable to get at the clients datas
        $client = new Client;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($client->setMembershipType($rowMembership['id_tipo_membresia'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataClients = $client->reportClientsMembresies()) {
                // Se recorren los registros fila por fila.
                foreach ($dataClients as $rowClient) {
                    ($rowClient['estado_cliente']) ? $estado = 'Active' : $estado = 'Inactive';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(96, 10, $pdf->encodeString($rowClient['nombre_completo_cliente']), 1, 0);
                    $pdf->cell(30, 10, $rowClient['dui_cliente'], 1, 0);
                    $pdf->cell(30, 10, $rowClient['telefono_cliente'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('Not have client in this membership type to show'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Membership type not exists'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('Not have membership type to show'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'clients.pdf');
