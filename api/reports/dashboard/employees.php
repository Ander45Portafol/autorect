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
if ($dataEmployeeTypes = $employee->readAllEmployeeType()) {
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
    // design to headers
    $pdf->setFillColor(0);
    $pdf->SetTextColor(255);
    $pdf->setFont('Arial', 'B', 11);
    // Headers at the table.
    $pdf->cell(96, 10, 'Full name', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Email', 1, 0, '', 1);
    $pdf->cell(30, 10, 'DUI', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Phone', 1, 1, 'C', 1);

    // Design to show categories
    $pdf->setFillColor(252);
    $pdf->SetTextColor(0);
    $pdf->setFont('Times', '', 11);

    // show data to row by row
    foreach ($dataEmployeeTypes as $rowEmployeeType) {
        //Design to cells in the data of the employee type
        $pdf->SetFillColor(230,230,230);
        $pdf->SetTextColor(0);
        $pdf->cell(0, 10, $pdf->encodeString('Employee type: ' . $rowEmployeeType['tipo_empleado']), 1, 1, 'C', 1);
        // variable to get at the employee datas
        $employee = new Employee;
        // Set at the employee type, to search employees
        if ($employee->setEmployeeType($rowEmployeeType['id_tipo_empleado'])) {
            //Validate if exists employees
            if ($dataEmployee = $employee->reportEmployeeType()) {
                // show data row by row
                foreach ($dataEmployee as $rowEmployee) {
                    // Show data of the employees
                    $pdf->cell(80, 10, $pdf->encodeString($rowEmployee['nombre_completo_empleado']), 1, 0,'C');
                    $pdf->cell(46, 10, $rowEmployee['correo_empleado'], 1, 0,'C');
                    $pdf->cell(30, 10, $rowEmployee['dui_empleado'], 1, 0,'C');
                    $pdf->cell(30, 10, $rowEmployee['telefono_empleado'], 1, 1,'C');
                }
            } else {
                // Message if not exists employees in that employees type.
                $pdf->cell(0, 10, $pdf->encodeString('Not have employees in this type to show'), 1, 1);
            }
        } else {
            // Message if not exists types employees
            $pdf->cell(0, 10, $pdf->encodeString('Employee type not exists'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('DO not employees types to show'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'employee.pdf');