const CUERPO_TEXTO=document.getElementById('tbody-rows');
const titulo_modal=document.getElementById('modal-title');
const FORMULARIO=document.getElementById('save-form-M');
const MODELS_API='/bussines/dashboard/models.php';

document.addEventListener('DOMContentLoaded', ()=>{
    cargarTabla();
})

FORMULARIO.document.addEventListener('submit' ,async (event)=>{
    event.preventDefault();
    (document.getElementById('id').value)?action='update':action='create';
    const FORM =new FormData(FORMULARIO);
    const JSON=await dataFetch(MODELS_API, action, FORM);
    if (JSON.status) {
        cargarTabla();
        sweetAlert(1, JSON.message, true);
    }else{
        sweetAlert(2, JSON.exception, false);
    }
})

async function cargarTabla(form=null){
    CUERPO_TEXTO.innerHTML='';
    (form)?action='search':action='readAll';
    const JSON=await dataFetch(MODELS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            CUERPO_TEXTO.innerHTML+=`
            <tr>
                <td>${row.id_modelo}</td>
                <td>${row.nombre_modelo}</td>
                <td>${row.anio_modelo}</td>
                <td>${row.id_marca}</td>
                <td class="action-btn">
                <div class="actions">
                <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="updateModel(${row.id_modelo})">
                    <i class="bx bxs-edit"></i>
                </button>
                <button class="delete" id="deletebtn" onclick="deleteModel(${row.id_modelo})">
                    <i class="bx bxs-trash"></i>
                </button>
            </div>
                </td>
            </tr>
        `;
        })
    }else{
        sweetAlert(4,JSON.exception, true)
    }
}

function createModel(){
    titulo_modal.textContent='CREATE MODEL';
    fillSelect(MODELS_API,'readBrand','brand');
    document.getElementById('update').style.display='none';
    document.getElementById('adduser').style.display='block';
    document.getElementById('clean').style.display='block';
}

async function updateModel(id){
    const FORM=new FormData();
    FORM.append('id',id);
    const JSON=await dataFetch(MODELS_API, 'readOne',FORM);
    if (JSON.status) {
        titulo_modal.textContent='UPDATE MODEL';
        document.getElementById('update').style.display='block';
        document.getElementById('adduser').style.display='none';
        document.getElementById('clean').style.display='none';
        document.getElementById('id').value=JSON.dataset.id_modelo;
        document.getElementById('modelname').value=JSON.dataset.nombre_modelo;
        document.getElementById('modelyear').value=JSON.dataset.anio_modelo;
        fillSelect(MODELS_API, 'readBrand', 'brand',JSON.dataset.id_marca);
    }
}

async function deleteModel(id){
    const RESPONSE=await confirmAction('¿Desea eliminar el modelo de forma permanente?');
    if (RESPONSE) {
        const FORM=new FormData();
        FORM.append('id_modelo', id);
        const JSON =await dataFetch(MODELS_API, 'delete', FORM);
        if (JSON.status) {
            cargarTabla();
            sweetAlert(1,JSON.message,true);
        }else{
            sweetAlert(2,JSON.exception,true);
    }
    }
}