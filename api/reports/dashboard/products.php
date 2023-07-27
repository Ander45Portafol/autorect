<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/products.php');
require_once('../../entities/dto/category.php');
require_once('../../entities/dto/users.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Products at categories');
// Se instancia el módelo Categoría para obtener los datos.
$category = new Category;
$user=new User;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategorias = $category->readAll()) {
    // Se establece un color de relleno para los encabezados.
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
    $pdf->setFillColor(0);
    $pdf->SetTextColor(255);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(126, 10, 'Product Name', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Price $(US)', 1, 0, 'C', 1);
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
        $pdf->cell(0, 10, $pdf->encodeString('Category: ' . $rowCategoria['nombre_categoria']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $product = new Product;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($product->setProductCategory($rowCategoria['id_categoria'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $product->productsReport()) {
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado_producto']) ? $estado = 'Active' : $estado = 'Inactive';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $estado, 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('Not have products in this categories to show'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Category not exists'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('Not have categories to show'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'products.pdf');