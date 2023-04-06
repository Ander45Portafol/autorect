// Constante para completar la ruta de la API
const USERS_API= '/bussines/dashboard/users.php'
// Constante para establecer el formulario de buscar
const SEARCH_FORM=document.getElementById('form-search')
// Constante para cambiar el titulo del modal
const TITLE_MODAL=document.getElementById('exampleModalLabel')
// Constante para establecer el formulario
const  SAVE_FORM=document.getElementById('user-form')
//Cosntantes para establecer el contenido de la tabla
const TBODY_ROWS=document.getElementById('tbody-rows-users')

const SWITCH_STATE_USER=document.getElementById('flexSwitchCheckChecked')
const OPTIONS={
    dismissible:false
}
document.addEventListener('DOMContentLoaded',()=>{
    fillTable()
})

const LimpiarCampos=()=>{
    document.getElementById('id').value='';
    document.getElementById('username').value='';
    document.getElementById('password').value='';
    fillSelect(USERS_API,'readEmployees','Employee')
    fillSelect(USERS_API,'readType_Users','user_type')
}

SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})

SAVE_FORM.addEventListener('submit',async(event)=>{
    event.preventDefault();
    (document.getElementById('id').value)?action='update' : action= 'create';
    const FORM=new FormData(SAVE_FORM);
    const JSON=await dataFetch(USERS_API, action, FORM);
    if (JSON.status) {
        fillTable();
        sweetAlert(1,JSON.mesage,true);
        LimpiarCampos();
        document.getElementById('btnclose').click();
    }else{
        sweetAlert(2,JSON.exception,false);
    }
} )


async function fillTable(form=null){
    // Se inicializa el contenido de la tabla
    TBODY_ROWS.innerHTML='';
    // Se verifica la accion a realizar
    (form) ? action = 'search' : action = 'readAll';
    // Peticion para obtener los registros disponibles
    const JSON=await dataFetch(USERS_API,action,form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepcion.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML+=`
                <tr>
                    <td>${row.id_usuario}</td>
                    <td>${row.nombre_usuario}</td>
                    <td>${row.clave_usuario}</td>
                    <td>${row.estado_usuario}</td>
                    <td>${row.id_tipo_usuario}</td>
                    <td class="action-btn">
                        <div class="actions">
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="UpdateUser(${row.id_usuario})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="DeleteUser(${row.id_usuario})">
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
function CreateUser(){
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
async function UpdateUser(id){
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

    //SWITCH_STATE_USER.value='false'

}
async function DeleteUser(id){
    const RESPONSE=await confirmAction('¿Desea eliminar el usuario de forma permanente?')
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