const PRODUCTS_API='bussines/dashboard/products.php';

document.addEventListener('DOMContentLoaded',()=>{
    graficoBarraUsuarios();
    graficoPastelPedidos();
    graficoPolarModelos();
    graficoDonaModelos();
    graficoFechasPedidos();
});
//Grafica para cargar los productos por categorias
async function graficoBarraUsuarios() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTS_API, 'cantidadUsuarios');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let tipo_usuarios = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            tipo_usuarios.push(row.tipo_usuario);
            cantidades.push(row.usuario);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1P', tipo_usuarios, cantidades, 'Cantidad de usuarios');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}
//Grafica para cargar los productos por categorias
async function graficoFechasPedidos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTS_API, 'fechasPedidos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let fecha_pedido = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            fecha_pedido.push(row.fecha_pedido);
            cantidad.push(row.n_pedidos);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        LineGraph('chartLine', fecha_pedido, cantidad, 'Cantidad de pedidos');
    } else {
        document.getElementById('chartLine').remove();
        console.log(DATA.exception);
    }
}
async function graficoPastelPedidos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTS_API, 'porcentajesPedidos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let estado = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estado.push(row.estado_pedido);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2P', estado, porcentajes, 'Porcentaje de pedidos');
    } else {
        document.getElementById('chart2P').remove();
        console.log(DATA.exception);
    }
}
//Grafica para cargar los productos por categorias
async function graficoPolarModelos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTS_API, 'cantidadModeloMarca');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let marca = [];
        let modelos = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            marca.push(row.nombre_marca);
            modelos.push(row.modelo);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        polarGraph('chart3P', modelos, marca);
    } else {
        document.getElementById('chart3P').remove();
        console.log(DATA.exception);
    }
}
//Grafica para cargar los productos por categorias
async function graficoDonaModelos() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTS_API, 'porcentajeClientes');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let estado_cliente = [];
        let porcentajes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estado_cliente.push(row.estado_cliente);
            porcentajes.push(row.porcentaje);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        doughnutGraph('chart4P', estado_cliente, porcentajes,'Porcentaje de clientes');
    } else {
        document.getElementById('chart4P').remove();
        console.log(DATA.exception);
    }
}
