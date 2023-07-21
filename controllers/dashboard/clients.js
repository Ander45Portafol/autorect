//Constant to charger datas of the Clients API
const CLIENTS_API='bussines/dashboard/clients.php';
//Constant to manipulated datas in the table
const TBODY_ROWS=document.getElementById('tbody-rows');
//Constant to programated the action search
const SEARCH_FORM=document.getElementById('form-search')

//This event is to show datas in the table
document.addEventListener('DOMContentLoaded',()=>{
    fillTable();
})
//This event is to do the search action in the API
SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})
//This function is to charger datas in the table
async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form)?action='search':action='readAll';
    const JSON=await dataFetch(CLIENTS_API,action,form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            (row.estado_cliente) ? estado = 'active' : estado = 'inactive';
            TBODY_ROWS.innerHTML+=`
                <tr>
                    <td>${row.nombre_cliente}</td>
                    <td>${row.apellido_cliente}</td>
                    <td>${row.usuario_cliente}</td>
                    <td>${row.dui_cliente}</td>
                    <td>${estado}</td>
                    <td>${row.telefono_cliente}</td>
                    <td class="action-btn">
                        <div class="actions">
                            <button class="delete" id="deletebtn" onclick="statusClient(${row.id_cliente},${row.estado_cliente})">
                                <i class='bx bx-refresh'></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="deleteClient(${row.id_cliente})">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        })
    }else{
        sweetAlert(4,JSON.exception,true);
    }
}
//This function is to realized the delete action at the API
async function deleteClient(id){
    const RESPONSE=await confirmAction('Do you want to delete this client permanently?')
    if (RESPONSE) {
        const FORM=new FormData()
        FORM.append('id_cliente',id)
        const JSON=await dataFetch(CLIENTS_API,'delete',FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1,JSON.message,true)
        }else{
            sweetAlert(2,JSON.exception,false)
        }
    }
}

async function statusClient(id,estado) {
    const RESPONSE = await confirmAction('Do you want to change the Client rating permanently?')
    if (RESPONSE) {
        const FORM = new FormData()
        FORM.append('id_cliente', id)
        if (estado === true) {
            const JSON = await dataFetch(CLIENTS_API, 'FalseClient', FORM)
            if (JSON.status) {
                sweetAlert(1, JSON.message, true);
                fillTable();
            }
            else {
                sweetAlert(2, JSON.exception, false)
            }
        } else if (estado === false) {
            const JSON = await dataFetch(CLIENTS_API, 'TrueClient', FORM)
            if (JSON.status) {
                fillTable();
                sweetAlert(1, JSON.message, true);
            } else {
                sweetAlert(2, JSON.exception, false)
            }
        }
    }
}
//codigo para abrir el reporte
function openReport() {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/dashboard/clients.php`);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}