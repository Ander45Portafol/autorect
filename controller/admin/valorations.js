const VALORATIONS_API='bussines/dashboard/valorations.php';
const TBODY_ROWS=document.getElementById('tbody-rows');
const SEARCH_FORM=document.getElementById('form-search')

document.addEventListener('DOMContentLoaded', ()=>{
    fillTable();
})

SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})

async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form) ? action = 'search': action = 'readAll'
    const JSON= await dataFetch(VALORATIONS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            TBODY_ROWS.innerHTML+=`
                <tr>
                    <td>${row.fecha_comentario}</td>
                    <td>${row.comentario}</td>
                    <td>${row.calificacion_producto}</td>
                    <td>${row.id_detalle_pedido}</td>
                    <td>
                        <div class="actions">
                            <button class="delete" id="deletebtn" onclick="DeleteValoracion(${row.id_valoracion})">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        })
    }else{
        sweetAlert(4,JSON.exception, true);
    }
}

async function DeleteValoracion(id){
    const RESPONSE=await confirmAction('¿Desea eliminar la valoracion de forma permanente?')
    if (RESPONSE) {
        const FORM=new FormData()
        FORM.append('id_valoracion',id)
        const JSON=await dataFetch(VALORATIONS_API,'delete',FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1,JSON.message,true)
        }else{
            sweetAlert(2,JSON.exception,false)
        }
    }
}