<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/users.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Users at types');
// Se instancia el módelo Categoría para obtener los datos.
$user = new User;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategorias = $user->readAllTypesUsers()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(0);
    $pdf->SetTextColor(255);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(126, 10, 'Full Name', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'User', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Status', 1, 1, 'C', 1);

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
        $pdf->cell(0, 10, $pdf->encodeString('Type user: ' . $rowCategoria['tipo_usuario']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $users = new User;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($users->setUserType($rowCategoria['id_tipo_usuario'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $users->reportUsersType()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado_usuario']) ? $estado = 'Active' : $estado = 'Inactive';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_completo']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['nombre_usuario'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('Not have users in this type to show'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('This users type is not ecists'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('Not have users type to show'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'usuarios.pdf');