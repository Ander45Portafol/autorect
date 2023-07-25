<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/reportP.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_pedido'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/order.php');
    // Se instancian las entidades correspondientes.
    $order = new Order;
    if ($order->setId($_GET['id_pedido'])) {
        if ($rowCategoria = $order->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Identificador de pedido: ' . $rowCategoria['id_pedido']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
                if ($dataOrder = $order->readOrderDetailReport()) {
                    // Se establece un color de relleno para los encabezados.
                    $pdf->setFillColor(225);
                    // Se establece la fuente para los encabezados.
                    $pdf->setFont('Times', 'B', 11);
                    // Se imprimen las celdas con los encabezados.
                    $pdf->cell(96, 10, 'Name product', 1, 0, 'C', 1);
                    $pdf->cell(30, 10, 'Price C/U (US$)', 1, 0, 'C', 1);
                    $pdf->cell(30, 10, 'Quantity', 1, 0, 'C', 1);
                    $pdf->Cell(30,10,'Subtotal',1,1,'C',1);
                    // Se establece la fuente para los datos de los productos.
                    $pdf->setFont('Times', '', 11);
                    // Se recorren los registros fila por fila.
                    $total=0;
                    foreach ($dataOrder as $rowOrder) {
                        // Se imprimen las celdas con los datos de los productos.
                        $subtotal=$rowOrder['cantidad_producto']* $rowOrder['precio_producto'];
                        $total+=$subtotal;
                        $pdf->cell(96, 10, $pdf->encodeString($rowOrder['nombre_producto']), 1, 0);
                        $pdf->cell(30, 10, $rowOrder['precio_producto'], 1, 0);
                        $pdf->cell(30, 10, $rowOrder['cantidad_producto'], 1, 0);
                        $pdf->Cell(30,10,$subtotal,1,1);
                    }
                    $pdf->Cell(186,10,'Total: '.$total,1,1);
                } else {
                    $pdf->cell(0, 10, $pdf->encodeString('Error to show data'), 1, 1);
                }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Receipt.pdf');
        } else {
            print('Receipt not exists');
        }
    } else {
        print('Do not exists this client');
    }
}
