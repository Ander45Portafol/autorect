const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
const SERVER_URL = "http://localhost/autorect/api/";

async function dataFetch(filename, action, form = null) {
    const OPTIONS = new Object();
    if (form) {
        OPTIONS.method = "post";
        OPTIONS.body = form;
    } else {
        OPTIONS.method = "get";
    }
    try {
        const PATH = new URL(SERVER_URL + filename);
        PATH.searchParams.append("action", action);
        const RESPONSE = await fetch(PATH.href, OPTIONS);
        return RESPONSE.json();
    } catch (error) {
        console.log(error);
    }
}

function confirmAction(message) {
    return swal({
        title: 'Warning',
        text: message,
        icon: 'warning',
        closeOnCLickOutSide: false,
        CloseOnEsc: false,
        buttons: {
            cancel: {
                text: 'No',
                value: false,
                visible: true,
                className: 'red accent-1'
            },
            confirm: {
                text: 'Sí',
                value: true,
                visible: true,
                className: 'grey darken-1'
            }
        }
    })
}

async function logOut() {
    // Se muestra un mensaje de confirmacion y se captura la respuesta en una constante
    const RESPONSE = await confirmAction('Are you sure you want log out?')
    // Se verifica la respuesta del mensaje
    if (RESPONSE) {
        // Peticion para eliminar la sesion.
        const JSON = await dataFetch(USER_API, 'logOut')
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepcion.
        if (JSON.status) {
            sweetAlert(1, JSON.message, true, 'index.html')
        } else {
            sweetAlert(2, JSON.exception, false)
        }
    }
}

function sweetAlert(type, text, timer, url = null) {
    // Se compara el tipo de mensaje a mostrar
    switch (type) {
        case 1:
            title = "Success";
            icon = "success";
            break;
        case 2:
            title = "Error";
            icon = "error";
            break;
        case 3:
            title = "Warning";
            icon = "warning";
            break;
        case 4:
            title = "Info";
            icon = "info";
            break;
        case 5:
            title = "Successful Payment";
            icon = "success";
            break;
        default:
            break;
    }
    // Se define un objeto con las opciones principales para el mensaje.
    let options = {
        title: title,
        text: text,
        icon: icon,
        closeOnClickOutside: false,
        closeOnEsc: false,
        button: {
            text: "Ok",
            className: "cyan",
        },
    };
    // Se verifica el uso de temporizador.
    timer ? (options.timer = 3000) : (options.timer = null);
    // Se muestra el mensaje. Requiere la librería sweetalert para funcionar.
    swal(options).then(() => {
        if (url) {
            // Se direcciona a la página web indicada.
            location.href = url;
        }
    });
}

async function fillSelect(filename, action, select, selected = null) {
    const JSON = await dataFetch(filename, action)
    let content = '';
    if (JSON.status) {
        content += '<option disable selected>Select something</option>'
        JSON.dataset.forEach(row => {
            value = Object.values(row)[0]
            text = Object.values(row)[1]
            if (value != selected) {
                content += `<option value="${value}">${text}</option>`
            } else {
                content += `<option value="${value}" selected>${text}</option>`
            }
        })
    } else {
        content += '<option>No data to show</option>'
    }
    document.getElementById(select).innerHTML = content
}


/*
*   Función para generar un gráfico de barras verticales.
*   Parámetros: canvas (identificador de la etiqueta canvas), xAxis (datos para el eje X), yAxis (datos para el eje Y), legend (etiqueta para los datos) y title (título del gráfico).
*   Retorno: ninguno.
*/
function barGraph(canvas, xAxis, yAxis, legend, title) {
    // Se declara un arreglo para guardar códigos de colores en formato hexadecimal.
    let colors = [];
    // Se generan códigos hexadecimales de 6 cifras de acuerdo con el número de datos a mostrar y se agregan al arreglo.
    xAxis.forEach(() => {
        colors.push('#' + (Math.random().toString(16)).substring(2, 8));
    });
    // Se establece el contexto donde se mostrará el gráfico, es decir, la etiqueta canvas a utilizar.
    const CONTEXT = document.getElementById(canvas).getContext('2d');
    // Se crea una instancia para generar el gráfico con los datos recibidos. Requiere la librería chart.js para funcionar.
    const CHART = new Chart(CONTEXT, {
        type: 'bar',
        data: {
            labels: xAxis,
            datasets: [{
                label: legend,
                data: yAxis,
                backgroundColor: colors
            }]
        },
        options: {
            aspectRatio: 1,
            plugins: {
                title: {
                    display: true,
                    text: title
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

/*
*   Función para generar un gráfico de pastel.
*   Parámetros: canvas (identificador de la etiqueta canvas), legends (valores para las etiquetas), values (valores de los datos) y title (título del gráfico).
*   Retorno: ninguno.
*/
function pieGraph(canvas, legends, values, title) {
    // Se declara un arreglo para guardar códigos de colores en formato hexadecimal.
    let colors = [];
    // Se generan códigos hexadecimales de 6 cifras de acuerdo con el número de datos a mostrar y se agregan al arreglo.
    values.forEach(() => {
        colors.push('#' + (Math.random().toString(16)).substring(2, 8));
    });
    // Se establece el contexto donde se mostrará el gráfico, es decir, la etiqueta canvas a utilizar.
    const CONTEXT = document.getElementById(canvas).getContext('2d');
    // Se crea una instancia para generar el gráfico con los datos recibidos. Requiere la librería chart.js para funcionar.
    const CHART = new Chart(CONTEXT, {
        type: 'pie',
        data: {
            labels: legends,
            datasets: [{
                data: values,
                backgroundColor: colors
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: title
                }
            }
        }
    });
}