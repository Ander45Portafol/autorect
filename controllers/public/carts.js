const PRODUCT_CART = document.getElementById('container_products');
const ORDER_API = 'bussines/public/order.php';
const DATE=document.getElementById('date');
const NAME=document.getElementById('name_client');

document.addEventListener('DOMContentLoaded', () => {
    readOrderDetail();
    chargerDataUser();
});

async function chargerDataUser(){
    const JSON = await dataFetch(USER_API, 'getUser');
    NAME.textContent=JSON.fullname;
    n =  new Date();
//Año
y = n.getFullYear();
//Mes
m = n.getMonth() + 1;
//Día
d = n.getDate();
DATE.textContent=d + "/" + m + "/" + y;
}
async function validateConditions(){
    const check=document.getElementById('check_conditions').checked;
    if (check) {
        const JSON=await dataFetch(USER_API,'getUser');
        if (JSON.status) {
            const FORM=new FormData();
            FORM.append('id_cliente',JSON.id);
            const JSONCAR=await dataFetch(ORDER_API,'confirmOrder',FORM);
            if (JSONCAR.dataset.direccion_pedido==='null') {
                const JSONUPDT=await dataFetch(ORDER_API,'updateOrder',FORM)
                if (JSONUPDT.status) {
                    sweetAlert(1,JSONUPDT.message,false);
                    readOrderDetail();
                }
            }else{
                sweetAlert(2,"Verifique la informacion de su perfil",false);
            }
        }
    }else{
        sweetAlert(3,'Debe aceptar los terminos y condiciones',false);
    }
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