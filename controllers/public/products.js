const PRODUCT_API='bussines/public/products.php';
const PRODUCT=document.getElementById('cards_container');

document.addEventListener('DOMContentLoaded',async()=>{
    const JSON=await dataFetch(PRODUCT_API, 'readAll');
    if (JSON.status) {
        PRODUCT.innerHTML='';
        JSON.dataset.forEach(row=>{
            PRODUCT.innerHTML+=`                    <div class="col">
            <div class="card">
                <img src="${SERVER_URL}images/products/${row.imagen_principal}" class="imagen_product">
                <div class="card-body">
                    <h5 class="card-title">${row.nombre_producto}</h5>
                    <p class="card-text"><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
                            class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                        <span>${row.precio_producto}</span>
                        <a href="product_details.html" class="button" type="button"><i
                                class='bx bxs-cart'></i></a>
                    </p>
                </div>
            </div>
        </div>`;
        });
    }
})