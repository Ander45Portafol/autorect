const PRODUCT_CART = document.getElementById('container_products');
const ORDER_API = 'bussines/public/order.php';
const DATE=document.getElementById('date');
const NAME=document.getElementById('name_client');
var pedido_id;

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
            console.log(pedido_id);
            const JSONCAR=await dataFetch(ORDER_API,'confirmOrder',FORM);
            if (JSONCAR.dataset.direccion_pedido!='null') {
                const JSONUPDT=await dataFetch(ORDER_API,'updateOrder',FORM)
                if (JSONUPDT.status) {
                    openReportCar(pedido_id);
                    console.log(pedido_id);
                    readOrderDetail();
                    sweetAlert(1,JSONUPDT.message,false);
                }
            }else{
                sweetAlert(2,"Check your profile information",false);
            }
        }
    }else{
        sweetAlert(3,'You must accept the terms and conditions',false);
    }
}
async function readOrderDetail() {
    const JSON = await dataFetch(ORDER_API, 'readOrderDetail');
    if (JSON.status) {
        PRODUCT_CART.innerHTML = '';
        let subtotal = 0;
        let total = 0;
        JSON.dataset.forEach(row => {
            pedido_id=row.id_pedido;
            subtotal=row.precio_producto*row.cantidad_producto;
            total+=subtotal;
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
                    <button onclick="deleteOneProduct(${row.id_detalle_pedido},${row.cantidad_producto})"><i class='bx bx-minus'></i></button>
                    <p>${row.cantidad_producto}</p>
                    <button onclick="addOneProduct(${row.id_detalle_pedido},${row.cantidad_producto})"><i class='bx bx-plus'></i></button>
                </div>
            </td>
            <td>
                <p>$${row.precio_producto}</p>
            </td>
            <td>
                <p>$${subtotal.toFixed(2)}</p>
            </td>
            <td>
                <button class="delete" onclick="deleteDetail(${row.id_detalle_pedido})"><i class="bx bxs-trash"></i></button>
            </td>
        </tr>`;
        });
        document.getElementById('pago').textContent='$'+total.toFixed(2);
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
async function deleteOneProduct(id_detalle, cantidad){
    if (cantidad===1) {
        sweetAlert(3,'If you want to delete the product, press the delete button',true);
    }else{
        const FORM=new FormData();
        FORM.append('id_detalle',id_detalle);
        FORM.append('cantidad', cantidad);
        const JSON=await dataFetch(ORDER_API,'subtractDetail',FORM);
        if (JSON.status) {
            readOrderDetail();
        }else{
            sweetAlert(2,JSON.exception,false);
        }
    }
}
async function addOneProduct(id_detalle, cantidad){
    const FORMSTOCK=new FormData();
    FORMSTOCK.append('id_detalle_pedido',id_detalle);
    const STOCK = await dataFetch(ORDER_API,'readUpdatedStock',FORMSTOCK);
    if(STOCK.status){
        if (STOCK.dataset.existencias == 0) {
            sweetAlert(3,'No more products can be added',true);
        }else{
            const FORM=new FormData();
            FORM.append('id_detalle',id_detalle);
            FORM.append('cantidad', cantidad);
            const JSON=await dataFetch(ORDER_API,'addDetail',FORM);
            if (JSON.status) {
                readOrderDetail();
            }else{
                sweetAlert(2,JSON.exception,false);
            }
        }
    }else{
        sweetAlert(2,STOCK.exception,false);
    }
}
function openReportCar(idP) {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/public/receipt.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('id_pedido', idP);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
}