<?php
// import file to charger the template of report
require_once('../../helpers/report.php');
// import files to get datas
require_once('../../entities/dto/models.php');
require_once('../../entities/dto/users.php');
require_once('../../entities/dto/brands.php');

// variable to acces at report functions
$pdf = new Report;
// Here append the title of the report
$pdf->startReport('Models at brands');
// variable to get brands datas
$brand = new Brand;
// variable to get users datas
$user = new User;
// Validate if exists some brand
if ($dataBrands = $brand->readAll()) {
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
    $pdf->setFont('Times', 'B', 11);
    // Headers at the table.
    $pdf->cell(126, 10, 'Model Name', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Year start', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Year final', 1, 1, 'C', 1);

    // Design to show brands
    $pdf->setFillColor(252);
    $pdf->SetTextColor(0);
    $pdf->setFont('Times', '', 11);

    // show data to row by row
    foreach ($dataBrands as $rowBrand) {
        //Design to cells in the data of the brands
        $pdf->SetFillColor(230, 230, 230);
        $pdf->SetTextColor(0);
        $pdf->cell(0, 10, $pdf->encodeString('Brand: ' . $rowBrand['nombre_marca']), 1, 1, 'C', 1);
        // variable to get at the models datas
        $model = new Model;
        // Set at the brand, to search models
        if ($model->setModelBrand($rowBrand['id_marca'])) {
            //Validate if exists models
            if ($dataModels = $model->reportModel()) {
                // show data row by row
                foreach ($dataModels as $rowModel) {
                    // Show data of the models
                    $pdf->cell(126, 10, $pdf->encodeString($rowModel['nombre_modelo']), 1, 0);
                    $pdf->cell(30, 10, $rowModel['anio_inicial_modelo'], 1, 0);
                    $pdf->cell(30, 10, $rowModel['anio_final_modelo'], 1, 1);
                }
            } else {
                // Message if not exists employees in that brand.
                $pdf->cell(0, 10, $pdf->encodeString('Not model at brands'), 1, 1);
            }
        } else {
            // Message if not exists brand
            $pdf->cell(0, 10, $pdf->encodeString('Not exits brand'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('Do not show brands'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'models.pdf');
