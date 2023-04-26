//Constant to charger the Products API 
const PRODUCTS_API='bussines/dashboard/products.php';
//Constant to charger the Category API 
const CATEGORY_APi='bussines/dashboard/category.php';
//Constant to charger the Model API 
const MODEL_API='bussines/dashboard/models.php';
//Constant to use the products form
const SAVE_FORM=document.getElementById('save-form');
//Constant to use and to do the search process
const SEARCH_FORM=document.getElementById('form-search')
//Constant to manipulated the title in the products modal
const TITLE_MODAL=document.getElementById('modal-title');
//Constant to charger datas in the table to products data
const TBODY_ROWS=document.getElementById('tbody-rows');
//Constant to charger datas in the table to valorations datas
const TBODY_VALORATIONS=document.getElementById('tbody-valorations');

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
//This event is to programming that send all respective datas at the Api
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
//This function is to charger datas in the table
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
                            <button class="product_images" data-bs-toggle="modal" data-bs-target="#modalimages" onclick="readImgs(${row.id_producto})">
                                <i class="bx bx-images"></i>
                            </button>
                            <button class="valoractions" id="valorationbtn" type="button" data-bs-toggle="modal" data-bs-target="#modal-valoration" onclick="fillTableValorations(${row.id_producto})">
                                <i class='bx bxs-star-half'></i>
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
function CreateProduct(){
    TITLE_MODAL.textContent='CREATE USER'
    document.getElementById('product-name').disabled=false
    document.getElementById('price').disbled=false
    document.getElementById('update').style.display='none';
    document.getElementById('adduser').style.display='block';
    document.getElementById('clean').style.display='block';
    document.getElementById('file').required=true;
    fillSelect(CATEGORY_APi,'readAll','category')
    fillSelect(MODEL_API,'readAll','model')
    fillSelect(PRODUCTS_API,'readStatus','status')
}
//This function is to manipulated some controls and charger the repective data when the process is update
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
//This function is to communicate at the Api to do the delete action
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


    //Product images

    const imgform1=document.getElementById('form-1');
    const imgform2=document.getElementById('form-2');
    const imgform3=document.getElementById('form-3');
    const imgform4=document.getElementById('form-4');

    imgform1.addEventListener('submit', async(event)=>{
        event.preventDefault();
        const id_p = document.getElementById('id-p').value; 
        const FORM = new FormData(imgform1);
        FORM.append('id-p', id_p); 
        const JSON = await dataFetch(PRODUCTS_API, 'createImg', FORM);
        if (JSON.status) {
            document.getElementById('id-img-1').value= JSON.idimagen;
            console.log(document.getElementById('id-img-1').value);
            sweetAlert(1,JSON.message,true);
        }else{
            sweetAlert(2,JSON.exception,false);
        }
    })

    async function readImgs(productId) {
        const FORM = new FormData();
        FORM.append('id_producto', productId); 
        const JSON = await dataFetch(PRODUCTS_API, 'readImgs', FORM);
        document.getElementById('id-p').value = productId;
        //console.log(JSON.dataset[0]);
        const ruta = SERVER_URL + 'images/products/';
        if(JSON.status){
            document.getElementById("imga-1").classList.add("active");
            document.getElementById("imgp-1").src=ruta+JSON.dataset[0].nombre_archivo_imagen;
            document.getElementById("id-img-1").value = JSON.dataset[0].id_imagen_producto;
        }
    }

    function cleanImages(){
        document.getElementById("imgp-1").src="";
        document.getElementById("imgt-1").style.display = "block";
        document.getElementById("imga-1").classList.remove("active");
        document.getElementById("imgp-2").src="";
        document.getElementById("imgt-2").style.display = "block";
        document.getElementById("imga-2").classList.remove("active");
        document.getElementById("imgp-3").src="";
        document.getElementById("imgt-3").style.display = "block";
        document.getElementById("imga-3").classList.remove("active");
        document.getElementById("imgp-4").src="";
        document.getElementById("imgt-4").style.display = "block";
        document.getElementById("imga-4").classList.remove("active");
    }

    async function openFileSelector(num){
        var area = document.getElementById("imga-"+num);
        var img = document.getElementById("imgp-"+num);
        var input = document.getElementById("input-img-"+num);
        var text = document.getElementById("imgt-"+num);
        var idimg = document.getElementById("id-img-"+num);
    
        if(! area.classList.contains("active")){
            input.value = ""; 
            input.click();
        } else {
            const RESPONSE = await confirmAction('¿Desea eliminar la imagen?');
            if (RESPONSE) {
                const FORM=new FormData();
                FORM.append('id_imagen_producto', idimg.value);
                const JSON = await dataFetch(PRODUCTS_API,'deleteImg',FORM);
                if (JSON.status) {
                    img.src = "";
                    area.classList.remove("active");
                    text.style.display = "block";
                    sweetAlert(1,JSON.message,true)
                }else{
                    sweetAlert(2,JSON.exception,false)
                }
            }
        }
    }
    
    
    async function showPreview(event, num){
        var preview = document.getElementById("imgp-"+num);
        var area = document.getElementById("imga-"+num);
        var text = document.getElementById("imgt-"+num);
        var btnsubmit = document.getElementById("btnsubmit-"+num)

        event.target.files.length = 0;
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            console.log(src);
            preview.src= src;
            area.classList.add("active");
            text.style.display = "none";
            btnsubmit.click();
        }
    }

//Methods to charger and to do the actions at realizated to valorations
async function fillTableValorations(id){
    const FORM=new FormData()
    FORM.append('id_producto',id)
    TBODY_VALORATIONS.innerHTML='';
    const JSON= await dataFetch(PRODUCTS_API, 'readAllValoration', FORM);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            TBODY_VALORATIONS.innerHTML+=`
                <tr>
                    <td>${row.nombre_producto}</td>
                    <td>${row.calificacion_producto}</td>
                    <td>${row.comentario}</td>
                    <td>${row.fecha_comentario}</td>
                    <td>
                        <div class="actions">
                            <button class="delete" id="deletebtn" onclick="DeleteValoration(${row.id_valoracion})">
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
//This function is to don't show any valoration
async function DeleteValoration(id){
    const RESPONSE=await confirmAction('¿Desea eliminar la valoracion del producto de forma permanente?')
    if (RESPONSE) {
        const FORM=new FormData()
        FORM.append('id_valoracion',id)
        const JSON=await dataFetch(PRODUCTS_API,'deleteValoration',FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1,JSON.message,true)
            document.getElementById('btnclose_valorations').click();
        }else{
            sweetAlert(2,JSON.exception,false)
        }
    }
}

