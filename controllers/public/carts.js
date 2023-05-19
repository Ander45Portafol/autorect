const PRODUCT_CART = document.getElementById('container_products');
const ORDER_API = 'bussines/public/order.php';
const NAME=document.getElementById('name_client');

document.addEventListener('DOMContentLoaded', () => {
    readOrderDetail();
    chargerDataUser();
});

async function chargerDataUser(){
    const JSON = await dataFetch(USER_API, 'getUser');
    NAME.textContent=JSON.fullname;
}

async function readOrderDetail() {
    const JSON = await dataFetch(ORDER_API, 'readOrderDetail');
    if (JSON.status) {
        PRODUCT_CART.innerHTML = '';
        JSON.dataset.forEach(row => {
            PRODUCT_CART.innerHTML += `                    <tr>
            <td>
                <div class="product">
                    <img src="${SERVER_URL}images/products/${row.imagen_principal}" class="image_product">
                    <div class="product-title">
                        <p class="title">${row.nombre_producto}</p>
                        <p>${row.descripcion_producto}</p>
                    </div>
                </div>
            </td>
            <td>
                <div class="quantity_product">
                    <button><i class='bx bx-minus'></i></button>
                    <p>${row.cantidad_producto}</p>
                    <button><i class='bx bx-plus'></i></button>
                </div>
            </td>
            <td>
                <p>$${row.precio_producto}</p>
            </td>
            <td>
                <button class="delete" onclick="deleteDetail(${row.id_detalle_pedido})"><i class="bx bxs-trash"></i></button>
            </td>
        </tr>`;
        })
    }
}
async function deleteDetail(id) {
    const RESPONSE = await confirmAction('Do you want to delete the product permanently?')
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append("id_detalle_pedido", id);
        const JSON = await dataFetch(ORDER_API, 'deleteDetail', FORM);
        if (JSON.status) {
            readOrderDetail();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}