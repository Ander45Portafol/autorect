const PRODUCT_CART=document.getElementById('contained_products');
const PEDIDO_API='bussines/public/order.php';

document.addEventListener('DOMContentLoaded', () => {
    readOrderDetail();
});

async function readOrderDetail(){
    const JSON = await dataFetch(PEDIDO_API, 'readOrderDetail');
    if (JSON.status) {
        PRODUCT_CART.innerHTML='';
        JSON.dataset.forEach(row=>{
            PRODUCT_CART.innerHTML+=`
            <div class="detail_product">
            <div class="product">
                <img class="detail_img" src="../../resources/images/lambo_ejem.svg " alt="">
                <div class="product-title">
                    <p class="title">Lamborghini L.Brake</p>
                    <p>Lamborghini Aventador left brake model 2023, color red</p>
                </div>
            </div>
            <div class="quantity_product">
                <button><i class='bx bx-minus'></i></button>
                <p>1</p>
                <button><i class='bx bx-plus'></i></button>
            </div>
            <div class="price_product">
                <p>$230</p>
            </div>
        </div> `;
        })
    }
}