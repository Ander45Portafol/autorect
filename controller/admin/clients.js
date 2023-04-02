const CLIENTS_API='bussines/dashboard/clients.php';
const TBODY_ROWS=document.getElementById('tbody-rows');

document.addEventListener('DOMContentLoaded',()=>{
    fillTable();
})

async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form)?action='search':action='readAll';
    const JSON=await dataFetch(CLIENTS_API,action,form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            TBODY_ROWS.innerHTML+=`
                <tr>
                    <td>${row.id_cliente}</td>
                    <td>${row.nombre_cliente}</td>
                    <td>${row.apellido_cliente}</td>
                    <td>${row.usuario_cliente}</td>
                    <td>${row.dui_cliente}</td>
                    <td>${row.telefono_cliente}</td>
                    <td>${row.estado_cliente}</td>
                </tr>
            `;
        })
    }else{
        sweetAlert(4,JSON.exception,true);
    }
}