const PRODUCT_API='bussines/public/products.php';
const PRODUCT=document.getElementById('cards_container');
const SEARCH_PRODUCT=document.getElementById('search-product');

document.addEventListener('DOMContentLoaded',async()=>{
    FillProduct();
})
SEARCH_PRODUCT.addEventListener('submit',async (event)=>{
    event.preventDefault();
    const FORM=new FormData(SEARCH_PRODUCT);
    FillProduct(FORM);
})
async function FillProduct(form=null){
    (form)?action='search':action='readAll';
    const JSON=await dataFetch(PRODUCT_API,action,form);
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
}