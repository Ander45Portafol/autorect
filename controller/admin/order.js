//Constant to charger the Order Api
const ORDER_API = "/bussines/dashboard/order.php";
//Constant to use all rows in the table to Order datas
const TBODY_ROWS = document.getElementById("tbody-rows-orders");
//Constant to used the search form
const SEARCH_FORM = document.getElementById("form-search");
//Constatn to change te modal title
const TITLE_MODAL = document.getElementById("exampleModalLabel");
//Constant to use the order formulary
const SAVE_FORM = document.getElementById("order-form");
//Constant to use all rows in the table to Order detail datas
const TBODY_DETAILS = document.getElementById('tbody-detail');
//Constant to change properties in the Order detail modal
const MODAL_DETAIL=document.getElementById('modal-detail');

//This event is to charger datas in the table
document.addEventListener("DOMContentLoaded", () => {
    fillTable();
});
//This event is to charger datas when the user needs at especific data
SEARCH_FORM.addEventListener("submit", (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    fillTable(FORM);
});
//This function is to charger datas in the table to Order datas
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = "";
    form ? (action = "search") : (action = "readAll");
    const JSON = await dataFetch(ORDER_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach((row) => {
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_pedido}</td>
                    <td>${row.fecha_pedido}</td>
                    <td>${row.nombre_completo_cliente}</td>
                    <td>${row.estado_pedido}</td>
                    <td>${row.nombre_completo_empleado}</td>
                    <td class="action-btn">
                        <div class="actions">
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="EditOrder(${row.id_pedido})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="DeleteOrder(${row.id_pedido})">
                                <i class="bx bxs-trash"></i>
                            </button>
                            <button type="button" class="order_detail" data-bs-toggle="modal" data-bs-target="#modal-detail" onclick="fillTableDetail(${row.id_pedido})">
                                <i class="bx bx-spreadsheet"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}
//This event is to charger datas in the table to Order details datas
async function fillTableDetail(id) {
    TBODY_DETAILS.innerHTML = "";
    const FORM = new FormData();
    FORM.append("id", id);
    const JSON = await dataFetch(ORDER_API, 'readAllDetail', FORM);
    if (JSON.status) {
        JSON.dataset.forEach((row) => {
            TBODY_DETAILS.innerHTML += `
                <tr>
                    <td>${row.imagen_principal}</td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.direccion_pedido}</td>
                    <td>${row.fecha_pedido}</td>
                    <td>${row.precio_total}</td>
                    <td class="action-btn">
                        <div class="actions">
                            <button class="delete" id="deletebtn" onclick="DeleteDetail(${row.id_detalle_pedido})">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}
//This arrow function is to do the clean action on the inputs ands selects
const Clean = () => {
    SAVE_FORM.setAttribute("novalidate", "");

    document.getElementById("fecha").value = "";
    document.getElementById("direccion").value = "";
    fillSelect(ORDER_API, "readEstados", "estado");
    fillSelect(ORDER_API, "readClients", "clients");
    fillSelect(ORDER_API, "readEmployees", "employees");

    SAVE_FORM.removeAttribute("novalidate");
};

//This function is to manipulated some controls when the process is create
function CreateOrder() {
    var fecha = new Date(); // Fecha actual
    var mes = fecha.getMonth() + 1; // Obteniendo mes
    var dia = fecha.getDate(); // Obteniendo día
    var anio = fecha.getFullYear(); // Obteniendo año
    if (dia < 10) dia = "0" + dia; // Agrega cero si el menor de 10
    if (mes < 10) mes = "0" + mes; // Agrega cero si el menor de 10

    var fechaMaxima = new Date(fecha.getTime() + 14 * 24 * 60 * 60 * 1000); // Sumando 14 días a la fecha actual, se multiplica la cantidad de milisegundos por la cantidad de dias
    var mesMaximo = fechaMaxima.getMonth() + 1;
    var diaMaximo = fechaMaxima.getDate();
    var anioMaximo = fechaMaxima.getFullYear();
    if (diaMaximo < 10) diaMaximo = "0" + diaMaximo;
    if (mesMaximo < 10) mesMaximo = "0" + mesMaximo;

    TITLE_MODAL.textContent = "CREATE ORDER";
    document.getElementById("fecha").value = anio + "-" + mes + "-" + dia;
    document.getElementById("fecha").min = anio + "-" + mes + "-" + dia;
    document.getElementById("fecha").max =
        anioMaximo + "-" + mesMaximo + "-" + diaMaximo;
    fillSelect(ORDER_API, "readEstados", "estado");
    fillSelect(ORDER_API, "readClients", "clients");
    fillSelect(ORDER_API, "readEmployees", "employees");
    document.getElementById("update").style.display = "none";
    document.getElementById("adduser").style.display = "block";
    document.getElementById("clean").style.display = "block";
}
//This event is to send all datas to realized the respective query
SAVE_FORM.addEventListener("submit", async (event) => {
    event.preventDefault();
    document.getElementById("id").value
        ? (action = "update")
        : (action = "create");
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(ORDER_API, action, FORM);
    if (JSON.status) {
        document.getElementById("btnclose").click();
        fillTable();
        Clean();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});
//This function is to manipulated some controls and charger the repective data when the process is update
async function EditOrder(id) {
    const FORM = new FormData();
    FORM.append("id", id);
    const JSON = await dataFetch(ORDER_API, "readOne", FORM);
    if (JSON.status) {
        TITLE_MODAL.textContent = "UPDATE ORDER";
        document.getElementById("update").style.display = "block";
        document.getElementById("adduser").style.display = "none";
        document.getElementById("clean").style.display = "block";
        document.getElementById("id").value = JSON.dataset.id_pedido;
        document.getElementById("direccion").value = JSON.dataset.direccion_pedido;
        document.getElementById("fecha").value = JSON.dataset.fecha_pedido;

        var fecha = new Date(JSON.dataset.fecha_pedido);

        var fechaMinima = new Date(fecha.getTime() - 30 * 24 * 60 * 60 * 1000);
        var mesMinimo = fechaMinima.getMonth() + 1;
        var diaMinimo = fechaMinima.getDate();
        var anioMinimo = fechaMinima.getFullYear();
        if (diaMinimo < 10) diaMinimo = "0" + diaMinimo;
        if (mesMinimo < 10) mesMinimo = "0" + mesMinimo;

        var fechaMaxima = new Date(fecha.getTime() + 30 * 24 * 60 * 60 * 1000);
        var mesMaximo = fechaMaxima.getMonth() + 1;
        var diaMaximo = fechaMaxima.getDate();
        var anioMaximo = fechaMaxima.getFullYear();
        if (diaMaximo < 10) diaMaximo = "0" + diaMaximo;
        if (mesMaximo < 10) mesMaximo = "0" + mesMaximo;

        document.getElementById("fecha").min =
            anioMinimo + "-" + mesMinimo + "-" + diaMinimo;
        document.getElementById("fecha").max =
            anioMaximo + "-" + mesMaximo + "-" + diaMaximo;
        fillSelect(
            ORDER_API,
            "readEstados",
            "estado",
            JSON.dataset.id_estado_pedido
        );
        fillSelect(ORDER_API, "readClients", "clients", JSON.dataset.id_cliente);
        fillSelect(
            ORDER_API,
            "readEmployees",
            "employees",
            JSON.dataset.id_empleado
        );
    } else {
        sweetAlert(2, JSON.exception, false);
    }

    //SWITCH_STATE_USER.value='false'
}
//This function is to realized the delete action at the API
async function DeleteOrder(id) {
    const RESPONSE = await confirmAction(
        "¿Desea eliminar el pedido de forma permanente?"
    );
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append("id_pedido", id);
        const JSON = await dataFetch(ORDER_API, "delete", FORM);
        if (JSON.status) {
            fillTable();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, true);
        }
    }
}
//This function is to delete the order detail
async function DeleteDetail(idDetalle) {
    const RESPONSE = await confirmAction(
        "¿Desea eliminar el pedido de forma permanente?"
    );
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append("id_detalle_pedido", idDetalle);
        const JSON = await dataFetch(ORDER_API, "deleteDetail", FORM);
        if (JSON.status) {
            fillTable();
            sweetAlert(1, JSON.message, true);        
            document.getElementById('btnclose_detail').click();
        } else {
            sweetAlert(2, JSON.exception, true);
        }
    }
}