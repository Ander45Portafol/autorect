<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/models.php');
require_once('../../entities/dto/users.php');
require_once('../../entities/dto/brands.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Models at brands');
// Se instancia el módelo Categoría para obtener los datos.
$brand = new Brand;
$user=new User;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategorias = $brand->readAll()) {
    $pdf->setFillColor(255);
    $pdf->SetTextColor(0);
    $pdf->setFont('Arial', '', 12);
    if ($user->setId($_SESSION['id_usuario'])) {
        if ($dataUser=$user->searchEmployee()) {
            $nombre_employee=$dataUser['nombre_completo_empleado'];
            $pdf->Cell(48,10,'Nombre del empleado: ',0,0,);
            $pdf->Cell(140,10,$nombre_employee,0,1,);
            $pdf->Cell(0,5,'',0,1);
        }
    }
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(0);
    $pdf->SetTextColor(255);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(126, 10, 'Model Name', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Year start', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Year final', 1, 1, 'C', 1);

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
        $pdf->cell(0, 10, $pdf->encodeString('Brand: ' . $rowCategoria['nombre_marca']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $model = new Model;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($model->setModelBrand($rowCategoria['id_marca'])) { 
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $model->reportModel()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_modelo']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['anio_inicial_modelo'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['anio_final_modelo'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('Not model at brands'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Not exits brand'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('Do not show brands'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'models.pdf');