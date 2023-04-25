//Constant to charger the Category API 
const CATEGORY_API='bussines/dashboard/category.php'
//Constant to manipulated the title in the modal
const MODAL_TITLE=document.getElementById('modal-title');
//Constant to use the form
const SAVE_FORM=document.getElementById('save-form');
//Constant to charger datas in the table
const TBODY_ROWS=document.getElementById('tbody-rows');
//Constant to use and to do the search process
const SEARCH_FORM=document.getElementById('form-search')

//Event to show the datas in the table
document.addEventListener('DOMContentLoaded', ()=>{
    fillTable();
})

//This event is to programming that send parameters at the action in the API
SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})

//Function to Ccean inputs
const Clean=()=>{
    document.getElementById('id').value='';
    document.getElementById('name').value='';
    document.getElementById('description').value='';
}

//This event is to programming that send all respective datas at the Api
SAVE_FORM.addEventListener('submit', async(event)=>{
    event.preventDefault();
    (document.getElementById('id').value)?action='update':action='create';
    const FORM =new FormData(SAVE_FORM);
    const JSON= await dataFetch(CATEGORY_API,action,FORM);
    if (JSON.status) {
        fillTable();
        sweetAlert(1,JSON.message,true);
        Clean();
        document.getElementById('btnclose').click();
    }else{
        sweetAlert(2,JSON.exception,false);
    }
})

//This function is to charger datas in the table
async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form) ? action = 'search': action = 'readAll'
    const JSON= await dataFetch(CATEGORY_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            TBODY_ROWS.innerHTML+=`
                <tr>
                <td><img src="${SERVER_URL}images/categories/${row.imagen_categoria}" class="image_product"></td>
                    <td>${row.nombre_categoria}</td>
                    <td>${row.descripcion_categoria}</td>
                    <td>
                        <div class="actions">
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="updateCategory(${row.id_categoria})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="DeleteCategory(${row.id_categoria})">
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

//This function is to manipulated some controls when the process is create
function createCategory(){
    MODAL_TITLE.textContent='CREATE CATEGORY';
    document.getElementById('update').style.display='none';
    document.getElementById('addcategory').style.display='block';
    document.getElementById('clean').style.display='block';
    document.getElementById('file').required=true;
}
//This function is to manipulated some controls and charger the repective data when the process is update
async function updateCategory(id){
    const FORM=new FormData();
    FORM.append('id',id);
    const JSON=await dataFetch(CATEGORY_API,'readOne',FORM);
    if (JSON.status) {
        MODAL_TITLE.textContent='UPDATE CATEGORY';
        document.getElementById('update').style.display='block';
        document.getElementById('addcategory').style.display='none';
        document.getElementById('clean').style.display='none';
        document.getElementById('id').value=JSON.dataset.id_categoria;
        document.getElementById('name').value=JSON.dataset.nombre_categoria;
        document.getElementById('description').value=JSON.dataset.descripcion_categoria;
        document.getElementById('file').required=false;
    }
}
//This function is to communicate at the Api to do the delete action
async function DeleteCategory(id){
    const RESPONSE=await confirmAction('¿Desea eliminar el usuario de forma permanente?')
    if (RESPONSE) {
        const FORM=new FormData()
        FORM.append('id_categoria',id)
        const JSON=await dataFetch(CATEGORY_API,'delete',FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1,JSON.message,true)
        }else{
            sweetAlert(2,JSON.exception,false)
        }
    }
}