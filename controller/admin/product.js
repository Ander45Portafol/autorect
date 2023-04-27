//Constant to charger the Products API 
const PRODUCTS_API = 'bussines/dashboard/products.php';
//Constant to charger the Category API 
const CATEGORY_API = 'bussines/dashboard/category.php';
//Constant to charger the Model API 
const MODEL_API = 'bussines/dashboard/models.php';
//Constant to use the products form
const SAVE_FORM = document.getElementById('save-form');
//Constant to use and to do the search process
const SEARCH_FORM = document.getElementById('form-search')
//Constant to manipulated the title in the products modal
const TITLE_MODAL = document.getElementById('modal-title');
//Constant to charger datas in the table to products data
const TBODY_ROWS = document.getElementById('tbody-rows');
//Constant to charger datas in the table to valorations datas
const TBODY_VALORATIONS = document.getElementById('tbody-valorations');

//Event to show the datas in the table
document.addEventListener('DOMContentLoaded', () => {
    fillTable();
})
function Clean(){
    document.getElementById('product-name').value = "";
    document.getElementById('stock').value = "";
    document.getElementById('addExists').value="";
    document.getElementById('price').value = "";
    document.getElementById('newstock').value='';
    document.getElementById('product-description').value = "";
}
//This event is to programming that send parameters at the action in the API
SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    fillTable(FORM);
})
//This event is to programming that send all respective datas at the Api
SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    if (action=='update') {
        updateStock();
    }
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(PRODUCTS_API, action, FORM);
    if (JSON.status) {
        console.log(document.getElementById('addExists').value);
        fillTable();
        Clean();
        sweetAlert(1, JSON.message, true);
        document.getElementById('btnclose').click();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
})

//This function is to charger datas in the table
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    (form) ? action = 'search' : action = 'readAll'
    const JSON = await dataFetch(PRODUCTS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML += `
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
                            <button class="valoractions" id="valorationbtn" type="button" data-bs-toggle="modal" data-bs-target="#modal-valoration" onclick="fillTableValorations(${row.id_producto})">
                            <i class='bx bxs-star-half'></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        })
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}
//This function is to manipulated some controls when the process is create
function CreateProduct() {
    TITLE_MODAL.textContent = 'CREATE PRODUCT'
    Clean();
    document.getElementById('product-name').disabled = false
    document.getElementById('price').disbled = false
    document.getElementById('update').style.display = 'none';
    document.getElementById('adduser').style.display = 'block';
    document.getElementById('newstocklabel').style.display='none';
    document.getElementById('addExists').style.display='none';
    document.getElementById('newstock').style.display='none';
    document.getElementById('clean').style.display = 'block';
    document.getElementById('fileProduct').required = true;
    fillSelect(CATEGORY_API, 'readAll', 'category');
    fillSelect(MODEL_API, 'readAll', 'model');
    fillSelect(PRODUCTS_API, 'readStatus', 'status');
}
//This function is to manipulated some controls and charger the repective data when the process is update
async function UpdateProduct(id) {
    const FORM = new FormData();
    FORM.append('id', id);
    const JSON = await dataFetch(PRODUCTS_API, 'readOne', FORM);
    if (JSON.status) {
        TITLE_MODAL.textContent = 'UPDATE PRODUCT';
        document.getElementById('update').style.display = 'block';
        document.getElementById('adduser').style.display = 'none';
        document.getElementById('clean').style.display = 'none';
        document.getElementById('addExists').style.display='block';
        document.getElementById('id').value = JSON.dataset.id_producto;
        document.getElementById('product-name').value = JSON.dataset.nombre_producto;
        document.getElementById('stock').value = JSON.dataset.existencias;
        document.getElementById('stock').disabled=true;
        document.getElementById('price').value = JSON.dataset.precio_producto;
        document.getElementById('product-description').value = JSON.dataset.descripcion_producto;
        fillSelect(CATEGORY_API, 'readAll', 'category', JSON.dataset.id_categoria);
        fillSelect(MODEL_API, 'readAll', 'model',JSON.dataset.id_modelo);
        fillSelect(PRODUCTS_API, 'readStatus', 'status', JSON.dataset.id_estado_producto);
        document.getElementById('fileProduct').required = false;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}
//This function is to communicate at the Api to do the delete action
async function DeleteProduct(id) {
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?')
    if (RESPONSE) {
        const FORM = new FormData()
        FORM.append('id_producto', id)
        const JSON = await dataFetch(PRODUCTS_API, 'delete', FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1, JSON.message, true)
        } else {
            sweetAlert(2, JSON.exception, false)
        }
    }
}
//Methods to charger and to do the actions at realizated to valorations
async function fillTableValorations(id) {
    const FORM = new FormData()
    FORM.append('id_producto', id)
    TBODY_VALORATIONS.innerHTML = '';
    const JSON = await dataFetch(PRODUCTS_API, 'readAllValoration', FORM);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            (row.estado_comentario) ? estado = 'activo' : estado = 'inactivo';
            TBODY_VALORATIONS.innerHTML += `
                <tr>
                    <td>${row.nombre_producto}</td>
                    <td>${row.calificacion_producto}</td>
                    <td>${row.comentario}</td>
                    <td>${estado}</td>
                    <td>${row.fecha_comentario}</td>
                    <td>
                        <div class="actions">
                            <button class="delete" id="deletebtn" onclick="StatusValoration(${row.id_valoracion},${row.estado_comentario},${id})">
                                <i class='bx bx-refresh'></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        })
    }
}
//This function is to change status at comentaries any valoration
async function StatusValoration(id, estado, id_product) {
    const RESPONSE = await confirmAction('¿Desea Cambiar la valoracion del producto de forma permanente?')
    if (RESPONSE) {
        const FORM = new FormData()
        FORM.append('id_valoracion', id)
        if (estado === true) {
            const JSON = await dataFetch(PRODUCTS_API, 'FalseValoration', FORM)
            if (JSON.status) {
                sweetAlert(1, JSON.message, true);
                fillTableValorations(id_product);
            }
            else {
                sweetAlert(2, JSON.exception, false)
            }
        } else if (estado === false) {
            const JSON = await dataFetch(PRODUCTS_API, 'TrueValoration', FORM)
            if (JSON.status) {
                fillTableValorations(id_product);
                sweetAlert(1, JSON.message, true);
            } else {
                sweetAlert(2, JSON.exception, false)
            }
        }
    }
}
function updateStock(){
    let existencias=parseInt(document.getElementById('addExists').value);
    let numberdata=parseInt(document.getElementById('stock').value);
    let newdata=existencias+numberdata;
    document.getElementById('newstock').value=newdata;
}