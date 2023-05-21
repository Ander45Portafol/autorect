
const PRODUCTS = document.getElementById('list_product');
const PRODUCTS_API = 'bussines/public/products.php';
const MODAL_TITLE = document.getElementById('modal-title');
const MODAL_FORM=document.getElementById('form_modal');

document.addEventListener('DOMContentLoaded', () => {
    const FORM = new FormData();
    FORM.append("id_cliente", PARAMS.get("id"));
    productHistory(FORM);
})
MODAL_FORM.addEventListener('submit',async (event)=>{
    event.preventDefault();
    const FORM=new FormData(MODAL_FORM);
    const JSON=await dataFetch(PRODUCTS_API, 'createComment', FORM);
    if (JSON.status) {
        sweetAlert(1,JSON.message,true);
        document.getElementById('btnclose').click();
    }else{
        sweetAlert(2,JSON.exception,false);
    }
})
function createValoration(id_detalle) {
    document.getElementById('id_detalle').value=id_detalle;
}
async function productHistory(form) {
    const JSON = await dataFetch(PRODUCTS_API, 'hsitoryProduct', form);
    if (JSON.status) {
        JSON.dataset.forEach(async (row) => {
            const FORM = new FormData();
            FORM.append("id_detalle", row.id_detalle_pedido);
            const JSONC = await dataFetch(PRODUCTS_API, 'validateComments', FORM);
            if (row.id_estado_pedido === 4) {
                if (JSONC.dataset === false) {
                    PRODUCTS.innerHTML += `                   <li class="list-group-item">
                    <div>
                    <img src="../../resources/images/lambo_ejem.svg" alt="">
                    <div class="info">
                        <h1>${row.nombre_producto}</h1>
                        <h5>${row.descripcion_producto}</h5>
                    </div>
                    </div>
                    <div id="buttons">
                        <button type="button" onclick="createValoration(${row.id_detalle_pedidSSo})" class="comment" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="bx bxs-message-add"></i>
                        </button>
                    </div>
                </li>`;
                } else {
                    PRODUCTS.innerHTML += `                   <li class="list-group-item">
                    <div>
                    <img src="../../resources/images/lambo_ejem.svg" alt="">
                    <div class="info">
                        <h1>${row.nombre_producto}</h1>
                        <h5>${row.descripcion_producto}</h5>
                    </div>
                    </div>
                    <div id="buttons">
                        <button onclick="deleteComment(${row.id_detalle_pedido})" class="delete">
                            <i class='bx bxs-message-alt-x'></i>
                        </button>
                    </div>
                </li>`;
                }
            } else {
                PRODUCTS.innerHTML += `                   <li class="list-group-item">
                    <img src="../../resources/images/lambo_ejem.svg" alt="">
                    <div class="info">
                        <h1>${row.nombre_producto}</h1>
                        <h5>${row.descripcion_producto}</h5>
                    </div>
                </li>`;
            }
        });
    }
}
async function deleteComment(id_detalle) {
    console.log(id_detalle)
    document.getElementById('id_detalle').value = id_detalle;
    const RESPONSE = await confirmAction('Do you want to delete the user permanently?')
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_detalle', id_detalle);
        const JSON = await dataFetch(PRODUCTS_API, 'deleteComments', FORM);
        if (JSON.status) {
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}