// Constante para completar la ruta de la API
const ORDER_API= '/bussines/dashboard/order.php'
//Constantes para establecer el contenido de la tabla
const TBODY_ROWS=document.getElementById('tbody-rows-orders')
// Constante para establecer el formulario de buscar
const SEARCH_FORM=document.getElementById('form-search')
// Constante para cambiar el titulo del modal
const TITLE_MODAL=document.getElementById('exampleModalLabel')
// Constante para establecer el formulario
const SAVE_FORM=document.getElementById('order-form')

document.addEventListener('DOMContentLoaded',()=>{
    fillTable()
})

SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})

async function fillTable(form=null){
    // Se inicializa el contenido de la tabla
    TBODY_ROWS.innerHTML='';
    // Se verifica la accion a realizar
    (form) ? action = 'search' : action = 'readAll';
    // Peticion para obtener los registros disponibles
    const JSON=await dataFetch(ORDER_API,action,form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepcion.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML+=`
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
                        </div>
                    </td>
                </tr>
            `
        })
        // Se muestra un mensaje de acuerdo con el resultado
    }else{
        sweetAlert(4, JSON.exception,true)
    }
}

const Clean=()=>{
    SAVE_FORM.setAttribute('novalidate', '');

    document.getElementById('fecha').value='';
    document.getElementById('direccion').value='';
    fillSelect(ORDER_API,'readEstados','estado');
    fillSelect(ORDER_API,'readClients','clients');
    fillSelect(ORDER_API,'readEmployees','employees');

    SAVE_FORM.removeAttribute('novalidate');
}

function CreateOrder(){
    var fecha = new Date(); // Fecha actual
    var mes = fecha.getMonth() + 1; // Obteniendo mes
    var dia = fecha.getDate(); // Obteniendo día
    var anio = fecha.getFullYear(); // Obteniendo año
    if (dia < 10)
        dia = '0' + dia; // Agrega cero si el menor de 10
    if (mes < 10)
        mes = '0' + mes; // Agrega cero si el menor de 10

    var fechaMaxima = new Date(fecha.getTime() + (14 * 24 * 60 * 60 * 1000)); // Sumando 14 días a la fecha actual, se multiplica la cantidad de milisegundos por la cantidad de dias
    var mesMaximo = fechaMaxima.getMonth() + 1; 
    var diaMaximo = fechaMaxima.getDate(); 
    var anioMaximo = fechaMaxima.getFullYear(); 
    if (diaMaximo < 10)
        diaMaximo = '0' + diaMaximo; 
    if (mesMaximo < 10)
        mesMaximo = '0' + mesMaximo; 

    TITLE_MODAL.textContent='CREATE ORDER';
    document.getElementById('fecha').value = anio + "-" + mes + "-" + dia;
    document.getElementById('fecha').min = anio + "-" + mes + "-" + dia;
    document.getElementById('fecha').max = anioMaximo + "-" + mesMaximo + "-" + diaMaximo;
    fillSelect(ORDER_API,'readEstados','estado');
    fillSelect(ORDER_API,'readClients','clients');
    fillSelect(ORDER_API,'readEmployees','employees');
    document.getElementById('update').style.display='none';
    document.getElementById('adduser').style.display='block';
    document.getElementById('clean').style.display='block';
}

SAVE_FORM.addEventListener('submit',async(event)=>{
    event.preventDefault();
    (document.getElementById('id').value)?action='update' : action= 'create';
    const FORM=new FormData(SAVE_FORM);
    const JSON=await dataFetch(ORDER_API, action, FORM);
    if (JSON.status) {
        document.getElementById('btnclose').click();
        fillTable();
        Clean();
        sweetAlert(1,JSON.message,true);
    }else{
        sweetAlert(2,JSON.exception,false);
    }
})

async function EditOrder(id){
    const FORM=new FormData();
    FORM.append('id',id);
    const JSON=await dataFetch(ORDER_API,'readOne',FORM);
    if (JSON.status) {
        TITLE_MODAL.textContent='UPDATE ORDER';
        document.getElementById('update').style.display='block';
        document.getElementById('adduser').style.display='none';
        document.getElementById('clean').style.display='block';
        document.getElementById('id').value=JSON.dataset.id_pedido;
        document.getElementById('direccion').value=JSON.dataset.direccion_pedido;
        document.getElementById('fecha').value=JSON.dataset.fecha_pedido;

        var fecha = new Date(JSON.dataset.fecha_pedido);

        var fechaMinima = new Date(fecha.getTime() - (30 * 24 * 60 * 60 * 1000)); 
        var mesMinimo = fechaMinima.getMonth() + 1; 
        var diaMinimo = fechaMinima.getDate(); 
        var anioMinimo = fechaMinima.getFullYear(); 
        if (diaMinimo < 10)
            diaMinimo = '0' + diaMinimo; 
        if (mesMinimo < 10)
            mesMinimo = '0' + mesMinimo; 
    
        var fechaMaxima = new Date(fecha.getTime() + (30 * 24 * 60 * 60 * 1000)); 
        var mesMaximo = fechaMaxima.getMonth() + 1; 
        var diaMaximo = fechaMaxima.getDate(); 
        var anioMaximo = fechaMaxima.getFullYear(); 
        if (diaMaximo < 10)
            diaMaximo = '0' + diaMaximo; 
        if (mesMaximo < 10)
            mesMaximo = '0' + mesMaximo; 

        document.getElementById('fecha').min = anioMinimo + "-" + mesMinimo + "-" + diaMinimo;
        document.getElementById('fecha').max = anioMaximo + "-" + mesMaximo + "-" + diaMaximo;
        fillSelect(ORDER_API,'readEstados','estado',JSON.dataset.id_estado_pedido);
        fillSelect(ORDER_API,'readClients','clients',JSON.dataset.id_cliente);
        fillSelect(ORDER_API,'readEmployees','employees',JSON.dataset.id_empleado);
    }else{
        sweetAlert(2,JSON.exception,false);
    }

    //SWITCH_STATE_USER.value='false'

}

async function DeleteOrder(id){
    const RESPONSE=await confirmAction('¿Desea eliminar el pedido de forma permanente?');
    if (RESPONSE) {
        const FORM=new FormData();
        FORM.append('id_pedido', id);
        const JSON =await dataFetch(ORDER_API, 'delete', FORM);
        if (JSON.status) {
            fillTable();
            sweetAlert(1,JSON.message,true);
        }else{
            sweetAlert(2,JSON.exception,true);
        }
    }
}