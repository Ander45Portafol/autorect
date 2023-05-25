
const PRODUCTS = document.getElementById('list_product');
const PRODUCTS_API = 'bussines/public/products.php';
const MODAL_TITLE = document.getElementById('modal-title');
const MODAL_FORM = document.getElementById('form_modal');

document.addEventListener('DOMContentLoaded', () => {
    const FORM = new FormData();
    FORM.append("id_cliente", PARAMS.get("id"));
    orderHistory(FORM);
})
MODAL_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    const FORM = new FormData(MODAL_FORM);
    const JSON = await dataFetch(PRODUCTS_API, 'createComment', FORM);
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
        document.getElementById('btnclose').click();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
})
function createValoration(id_detalle) {
    document.getElementById('id_detalle').value = id_detalle;
}
async function orderHistory(form) {
    const JSON = await dataFetch(PRODUCTS_API, 'orderHistory', form);
    if (JSON.status) {
        PRODUCTS.innerHTML='';
        JSON.dataset.forEach((row) => {
            (row.direccion_pedido) ? direccion = row.direccion_pedido : direccion = '';
            if (row.estado_pedido === 'Finalizado') {
                PRODUCTS.innerHTML += `                   <li class="list-group-item item">
                <div>
                <div class="info">
                    <h1>${row.fecha_pedido}</h1>
                    <h5>${direccion}</h5>
                </div>
                </div>
                <div class="info">
                <h5>${row.estado_pedido}</h5>
                </div>
                <div id="buttons">
                    <button type="button" onclick="productHistory(${PARAMS.get("id")},${row.id_pedido})" class="btn btn-primary">
                        See More ...
                    </button>
                </div>
            </li>`;
            } else {
                PRODUCTS.innerHTML += `                   <li class="list-group-item item">
                <div>
                <div class="info">
                    <h1>${row.fecha_pedido}</h1>
                    <h5>${direccion}</h5>
                </div>
                </div>
                <div class="info">
                <h5>${row.estado_pedido}</h5>
                </div>
            </li>`;
            }
        });
    }
}
async function productHistory(cliente,pedido) {
    const FORM=new FormData();
    FORM.append("id_cliente",cliente);
    FORM.append("id_pedido",pedido);
    const JSON = await dataFetch(PRODUCTS_API, 'hsitoryProduct', FORM);
    if (JSON.status) {
        PRODUCTS.innerHTML='';
        let subtotal = 0;
        let total = 0;
        JSON.dataset.forEach(async (row) => {
            subtotal=row.precio_producto*row.cantidad_producto;
            total+=subtotal;
            const FORM = new FormData();
            FORM.append("id_detalle", row.id_detalle_pedido);
            const JSONC = await dataFetch(PRODUCTS_API, 'validateComments', FORM);
                if (JSONC.dataset === false) {
                    subtotal=row.precio_producto*row.cantidad_producto;
                    total+=subtotal;
                    PRODUCTS.innerHTML += `                   <li class="list-group-item item">
                    <div>
                    <img src="${SERVER_URL}images/products/${row.imagen_principal}">
                    <div class="info">
                        <h1>${row.nombre_producto}</h1>
                        <h5>${row.descripcion_producto}</h5>
                    </div>
                    </div>
                    <div class="info">
                    <h1>PRECIO:</h1>
                    <h5>$${row.precio_producto}</h5>
                </div>
                <div class="info">
                <h1>CANTIDAD:</h1>
                <h5>${row.cantidad_producto}</h5>
            </div>
            <div class="info">
            <h1>SUBTOTAL:</h1>
            <h5>${subtotal.toFixed(2)}</h5>
        </div>
                    <div id="buttons">
                        <button type="button" onclick="createValoration(${row.id_detalle_pedido})" class="comment" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="bx bxs-message-add"></i>
                        </button>
                    </div>
                </li>`;
                } else {
                    subtotal=row.precio_producto*row.cantidad_producto;
                    total+=subtotal;
                    PRODUCTS.innerHTML += `                   <li class="list-group-item item">
                    <div>
                    <img src="${SERVER_URL}images/products/${row.imagen_principal}">
                        <div class="info">
                            <h1>${row.nombre_producto}</h1>
                            <h5>${row.descripcion_producto}</h5>
                        </div>
                    </div>
                    <div class="info">
                    <h1>PRECIO:</h1>
                    <h5>$${row.precio_producto}</h5>
                </div>
                <div class="info">
                <h1>CANTIDAD:</h1>
                <h5>${row.cantidad_producto}</h5>
            </div>
            <div class="info">
            <h1>SUBTOTAL:</h1>
            <h5>${subtotal.toFixed(2)}</h5>
        </div>
                </div>
                    <div id="buttons">
                        <button onclick="deleteComment(${row.id_detalle_pedido},${cliente},${pedido})" class="delete">
                            <i class='bx bxs-message-alt-x'></i>
                        </button>
                    </div>
                </li>`;
                }
        });
        document.getElementById('total').style.display='block'
        document.getElementById('cantidad').textContent="$"+total.toFixed(2);

    }
}
async function deleteComment(id_detalle,cliente,pedido) {
    document.getElementById('id_detalle').value = id_detalle;
    const RESPONSE = await confirmAction('Do you want to delete the user permanently?')
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_detalle', id_detalle);
        FORM.append('id_cliente', cliente);
        const JSON = await dataFetch(PRODUCTS_API, 'deleteComments', FORM);
        if (JSON.status) {
            sweetAlert(1, JSON.message, true);
            orderHistory(FORM);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}