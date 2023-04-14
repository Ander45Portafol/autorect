// Constante para completar la ruta de la API
const ORDER_API= '/bussines/dashboard/order.php'
//Constantes para establecer el contenido de la tabla
const TBODY_ROWS=document.getElementById('tbody-rows-orders')
//
// Constante para establecer el formulario de buscar
const SEARCH_FORM=document.getElementById('form-search')

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
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="UpdateUser(${row.id_pedido})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="DeleteUser(${row.id_pedido})">
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