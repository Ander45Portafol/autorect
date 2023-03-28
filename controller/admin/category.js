const CATEGORY_API='bussines/dashboard/category.php'
const FORM_SAVE=document.getElementById('save-form')
const CLEAN=document.getElementById('clean')
const BTN_CATEGORY=document.getElementById('btncategory')
const MODAL_TITLE=document.getElementById('modal-title')

function openmodal(){
    MODAL_TITLE.textContent='Create category';
}
function updateModal(){
    MODAL_TITLE.textContent='Update category';
}
async function deleteModal(){
    const RESPONSE = await confirmAction('¿Desea eliminar el usuario de forma permanente?');
}
FORM_SAVE.addEventListener('submit', async(event)=>{
    (document.getElementById('id').value) ? action ='update': action ='create';
    const FORM= new FormData(FORM_SAVE);
    const JSON= await dataFetch(CATEGORY_API, action, FORM);
    console.log('No pasa de aqui')
    if(JSON.status){
        console.log('si se hace')
    }else{
        console.log('error')
    }
})