//In this variable is used to manipulated the data charger in the table
const TBODY_ROWS=document.getElementById('tbody-rows');
//In this variable are charging the titule in the modal
const MODEL_TITLE=document.getElementById('modal-title');
//In this variable is create to manipulated the form data
const FORMU=document.getElementById('save-form-M');
//This variable is create to make funcionated the search method
const SEARCH_FORM=document.getElementById('form-search')
//In this variable are using the Api
const MODELS_API='/bussines/dashboard/models.php';

//This event is to charger table in the formulary
document.addEventListener('DOMContentLoaded', ()=>{
    fillTable();
})

//This is the event to form to do the update or create process
FORMU.addEventListener('submit' ,async (event)=>{
    event.preventDefault();
    (document.getElementById('id').value)?action='update':action='create';
    const FORM =new FormData(FORMU);
    const JSON=await dataFetch(MODELS_API, action, FORMU);
    if (JSON.status) {
        fillTable();
        sweetAlert(1, JSON.message, true);
    }else{
        sweetAlert(2, JSON.exception, false);
    }
})

//This event is to make the event subimt at the search form
SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})

//This function is to charger the models data in the table
async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form)?action='search':action='readAll';
    const JSON=await dataFetch(MODELS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            TBODY_ROWS.innerHTML+=`
            <tr>
                <td>${row.id_modelo}</td>
                <td>${row.nombre_modelo}</td>
                <td>${row.anio_modelo}</td>
                <td>${row.id_marca}</td>
                <td>
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
//This function is to change somethings when the process are create
function createModel(){
    MODAL_TITLE.textContent='CREATE MODEL';
    fillSelect(MODELS_API,'readBrand','brand');
    document.getElementById('update').style.display='none';
    document.getElementById('adduser').style.display='block';
    document.getElementById('clean').style.display='block';
}
//This function is to charger somethings when the process are update
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
//This function is to do the delete process in the models
async function deleteModel(id){
    const RESPONSE=await confirmAction('Do you want to delete the model permanently?');
    if (RESPONSE) {
        const FORM=new FormData();
        FORM.append('id_modelo', id);
        const JSON =await dataFetch(MODELS_API, 'delete', FORM);
        if (JSON.status) {
            fillTable();
            sweetAlert(1,JSON.message,true);
        }else{
            sweetAlert(2,JSON.exception,true);
    }
    }
}