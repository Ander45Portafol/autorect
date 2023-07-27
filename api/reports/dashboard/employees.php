<?php
// import file to charger the template of report
require_once('../../helpers/report.php');
// import files to get datas
require_once('../../entities/dto/employee.php');
require_once('../../entities/dto/users.php');

// variable to acces at report functions
$pdf = new Report;
// Here append the title of the report
$pdf->startReport('Employees at type');
// variable to get employees datas
$employee = new Employee;
//variable to get users datas
$user=new User;
// Validate if exists some employee type
if ($dataCategorias = $employee->readAllEmployeeType()) {
    // Apply color on the cell
    $pdf->setFillColor(255);
    // Apply color at the text
    $pdf->SetTextColor(0);
    // Apply font family and font size at the text
    $pdf->setFont('Arial', '', 12);
    // Set the atribute id at user to search at which employee appertain
    if ($user->setId($_SESSION['id_usuario'])) {
        if ($dataUser=$user->searchEmployee()) {
            //Get the full name of the employee
            $nombre_employee=$dataUser['nombre_completo_empleado'];
            $pdf->Cell(48,10,'Employee full name: ',0,0,);
            $pdf->Cell(140,10,$nombre_employee,0,1,);
            $pdf->Cell(0,5,'',0,1);
        }
    }
    // header at the table
    $pdf->setFillColor(0);
    $pdf->SetTextColor(255);
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(96, 10, 'Full name', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Email', 1, 0, '', 1);
    $pdf->cell(30, 10, 'DUI', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Phone', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(252);
    $pdf->SetTextColor(0);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataCategorias as $rowCategoria) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->SetFillColor(230,230,230);
        $pdf->SetTextColor(0);
        $pdf->cell(0, 10, $pdf->encodeString('Employee type: ' . $rowCategoria['tipo_empleado']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $employee = new Employee;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($employee->setEmployeeType($rowCategoria['id_tipo_empleado'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $employee->reportEmployeeType()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(80, 10, $pdf->encodeString($rowProducto['nombre_completo_empleado']), 1, 0,'C');
                    $pdf->cell(46, 10, $rowProducto['correo_empleado'], 1, 0,'C');
                    $pdf->cell(30, 10, $rowProducto['dui_empleado'], 1, 0,'C');
                    $pdf->cell(30, 10, $rowProducto['telefono_empleado'], 1, 1,'C');
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('Not have employees in this type to show'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('EMployee type not exists'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('DO not employees types to show'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'employee.pdf');