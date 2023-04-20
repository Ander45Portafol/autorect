const PRODUCTS_API='bussines/dashboard/products.php';
const CATEGORY_APi='bussines/dashboard/category.php';
const MODEL_API='bussines/dashboard/models.php';
const SAVE_FORM=document.getElementById('save-form');
const SEARCH_FORM=document.getElementById('form-search')
const TITLE_MODAL=document.getElementById('modal-title');
const TBODY_ROWS=document.getElementById('tbody-rows');

document.addEventListener('DOMContentLoaded', ()=>{
    fillTable();
})

SEARCH_FORM.addEventListener('submit',(event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_FORM);
    fillTable(FORM);
})

SAVE_FORM.addEventListener('submit', async(event)=>{
    event.preventDefault();
    (document.getElementById('id').value)?action='update':action='create';
    const FORM =new FormData(SAVE_FORM);
    const JSON= await dataFetch(PRODUCTS_API,action,FORM);
    if (JSON.status) {
        fillTable();
        sweetAlert(1,JSON.message,true);
        document.getElementById('btnclose').click();
    }else{
        sweetAlert(2,JSON.exception,false);
    }
})

async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form) ? action = 'search': action = 'readAll'
    const JSON= await dataFetch(PRODUCTS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            TBODY_ROWS.innerHTML+=`
                <tr>
                    <td><img src="${SERVER_URL}images/products/${row.imagen_principal}" class="image_product"></td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.precio_producto}</td>
                    <td>${row.descripcion_producto}</td>
                    <td>${row.id_estado_producto}</td>
                    <td>
                        <div class="actions">
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="UpdateProduct(${row.id_producto})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="DeleteProduct(${row.id_producto})">
                                <i class="bx bxs-trash"></i>
                            </button>
                            <button class="product_images" data-bs-toggle="modal" data-bs-target="#modalimages">
                                <i class="bx bx-images"></i>
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
function CreateProduct(){
    TITLE_MODAL.textContent='CREATE USER'
    document.getElementById('product-name').disabled=false
    document.getElementById('price').disbled=false
    document.getElementById('update').style.display='none';
    document.getElementById('adduser').style.display='block';
    document.getElementById('clean').style.display='block';
    //document.getElementById('file').required=true;
    fillSelect(CATEGORY_APi,'readAll','category')
    fillSelect(MODEL_API,'readAll','model')
    fillSelect(PRODUCTS_API,'readStatus','status')
}
async function UpdateProduct(id){
    const FORM=new FormData();
    FORM.append('id',id);
    const JSON=await dataFetch(PRODUCTS_API,'readOne',FORM);
    if (JSON.status) {
        TITLE_MODAL.textContent='UPDATE CATEGORY';
        document.getElementById('update').style.display='block';
        document.getElementById('adduser').style.display='none';
        document.getElementById('clean').style.display='none';
        document.getElementById('id').value=JSON.dataset.id_producto;
        document.getElementById('product-name').value=JSON.dataset.nombre_producto;
        document.getElementById('stock').value=JSON.dataset.existencias;
        document.getElementById('price').value=JSON.dataset.precio_producto;
        document.getElementById('product-description').value=JSON.dataset.descripcion_producto;
        fillSelect(CATEGORY_APi,'readAll','category',JSON.dataset.id_categoria)
        fillSelect(MODEL_API,'readAll','model',JSON.dataset.id_modelo)
        fillSelect(PRODUCTS_API,'readStatus','status',JSON.dataset.id_estado_producto)
        document.getElementById('file').required=false;
    }else{
        sweetAlert(2,JSON.exception,false);
    }
}
async function DeleteProduct(id){
    const RESPONSE=await confirmAction('¿Desea eliminar el producto de forma permanente?')
    if (RESPONSE) {
        const FORM=new FormData()
        FORM.append('id_producto',id)
        const JSON=await dataFetch(PRODUCTS_API,'delete',FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1,JSON.message,true)
        }else{
            sweetAlert(2,JSON.exception,false)
        }
    }
}
