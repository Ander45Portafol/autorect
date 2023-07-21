<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/clients.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Clientes por tipo de membresia');
// Se instancia el módelo Categoría para obtener los datos.
$client = new Client;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategorias = $client->readAllMembresieTypes()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(0);
    $pdf->SetTextColor(255);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(96, 10, 'Nombre Completo', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Dui', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Telefono', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);

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
        $pdf->cell(0, 10, $pdf->encodeString('Tipo Membresia: ' . $rowCategoria['tipo_membresia']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $client = new Client;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($client->setMembershipType($rowCategoria['id_tipo_membresia'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $client->reportClientsMembresies()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado_cliente']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(96, 10, $pdf->encodeString($rowProducto['nombre_completo_cliente']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['dui_cliente'], 1, 0);
                    $pdf->cell(30, 10, $rowProducto['telefono_cliente'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Categoría incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorías para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'usuarios.pdf');