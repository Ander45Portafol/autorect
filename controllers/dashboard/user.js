//Constant to charger the Users API 
const USERS_API= '/bussines/dashboard/users.php'
//Constant to use and to do the search process
const SEARCH_FORM=document.getElementById('form-search')
//Constant to manipulated the title in the modal
const TITLE_MODAL=document.getElementById('exampleModalLabel')
//Constant to use the form
const  SAVE_FORM=document.getElementById('user-form')
//Constant to charger datas in the table to users data
const TBODY_ROWS=document.getElementById('tbody-rows-users')
//Constant to manipulate the properties at the switch
const SWITCH_STATE_USER=document.getElementById('flexSwitchCheckChecked')

//Event to show the datas in the table
document.addEventListener('DOMContentLoaded',()=>{
    fillTable()
})
//Function to Ccean inputs
const Clean=()=>{
    document.getElementById('id').value='';
    document.getElementById('username').value='';
    document.getElementById('password').value='';
    fillSelect(USERS_API,'readEmployees','Employee')
    fillSelect(USERS_API,'readType_Users','user_type')
}
//This event is to programming that send parameters at the action in the API
SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})
//This event is to programming that send all respective datas at the Api
SAVE_FORM.addEventListener('submit',async(event)=>{
    event.preventDefault();
    (document.getElementById('id').value)?action='update' : action= 'create';
    const FORM=new FormData(SAVE_FORM);
    const JSON=await dataFetch(USERS_API, action, FORM);
    if (JSON.status) {
        fillTable();
        sweetAlert(1,JSON.message,true);
        Clean();
        document.getElementById('btnclose').click();
    }else{
        sweetAlert(2,JSON.exception,false);
    }
} )

//This function is to charger datas in the table
async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form) ? action = 'search' : action = 'readAll';
    const JSON=await dataFetch(USERS_API,action,form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            (row.estado_usuario) ? estado = 'active' : estado = 'inactive';
            TBODY_ROWS.innerHTML+=`
                <tr>
                    <td><img src="${SERVER_URL}images/users/${row.imagen_usuario}" class="image_product"></td>
                    <td>${row.nombre_usuario}</td>
                    <td>${row.clave_usuario}</td>
                    <td>${estado}</td>
                    <td>${row.tipo_usuario}</td>
                    <td>
                        <div class="actions">
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="updateUser(${row.id_usuario})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="deleteUser(${row.id_usuario})">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `
        })
    }else{
        sweetAlert(4, JSON.exception,true)
    }
}
//This function is to manipulated some controls when the process is create
function createUser(){
    TITLE_MODAL.textContent='CREATE USER'
    document.getElementById('username').disabled=false
    document.getElementById('password').disbled=false
    document.getElementById('update').style.display='none';
    document.getElementById('adduser').style.display='block';
    document.getElementById('clean').style.display='block';
    document.getElementById('file').required=true;
    fillSelect(USERS_API,'readEmployees','Employee')
    fillSelect(USERS_API,'readType_Users','user_type')
}

//This function is to manipulated some controls and charger the repective data when the process is update
async function updateUser(id){
    const FORM=new FormData();
    FORM.append('id',id);
    const JSON=await dataFetch(USERS_API,'readOne',FORM);
    if (JSON.status) {
        TITLE_MODAL.textContent='UPDATE USER';
        document.getElementById('update').style.display='block';
        document.getElementById('adduser').style.display='none';
        document.getElementById('clean').style.display='none';
        document.getElementById('id').value=JSON.dataset.id_usuario;
        document.getElementById('username').value=JSON.dataset.nombre_usuario;
        document.getElementById('password').value=JSON.dataset.clave_usuario;
        document.getElementById('file').required=false;
        fillSelect(USERS_API,'readEmployees','Employee',JSON.dataset.id_empleado);
        fillSelect(USERS_API,'readType_Users','user_type',JSON.dataset.id_tipo_usuario);
        if (JSON.dataset.estado_usuario) {
            document.getElementById('state_user').checked=true;
        }else{
            document.getElementById('state_user').checked=false;
        }
    }else{
        sweetAlert(2,JSON.exception,false);
    }
}
//This function is to communicate at the Api to do the delete action
async function deleteUser(id){
    const RESPONSE=await confirmAction('Do you want to delete the user permanently?')
    if (RESPONSE) {
        const FORM=new FormData()
        FORM.append('id_usuario',id)
        const JSON=await dataFetch(USERS_API,'delete',FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1,JSON.message,true)
        }else{
            sweetAlert(2,JSON.exception,false)
        }
    }
}