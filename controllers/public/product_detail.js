const PRODUCT_API = "bussines/public/products.php";
const PARAMS = new URLSearchParams(location.search);
const PRODUCTS_RELATED = document.getElementById("cards_container");
const PRODUCT_TITLE = document.getElementById("product_title");
const REVIEWS = document.getElementById("product_reviews");
const VALORATION = document.getElementById("valorations");
const REVIEWS_RECORDS = document.getElementById("number_reviews");
const ORDER_API = "bussines/public/order.php";
const ORDER = document.getElementById("add_product");

document.addEventListener("DOMContentLoaded", async () => {
  const FORM = new FormData();
  FORM.append("id_categoria", PARAMS.get("categoria"));
  FORM.append("id_producto", PARAMS.get("id"));
  productData(FORM);
  productRelated(FORM);
  productReviews(FORM);
  const JSON = await dataFetch(PRODUCT_API, "readOne", FORM);
  if (JSON.status) {
    document.getElementById("id_product").value = JSON.dataset.id_producto;
  }
});
async function productData(form) {
  const JSONP = await dataFetch(PRODUCT_API, "readOne", form);
  if (JSONP.status) {
    PRODUCT_TITLE.textContent = JSONP.dataset.nombre_producto;
    document.getElementById("price_product").textContent =
      "$" + JSONP.dataset.precio_producto;
    document.getElementById("category_product").textContent =
      JSONP.dataset.nombre_categoria;
    document.getElementById("description_product").textContent =
      JSONP.dataset.descripcion_producto;
    document.getElementById("brand_product").textContent =
      JSONP.dataset.nombre_modelo;
  }
}

async function productReviews(form) {
  REVIEWS.innerHTML = "";
  const JSON = await dataFetch(PRODUCT_API, "productReview", form);
  if (JSON.status) {
    JSON.dataset.forEach((row) => {
      REVIEWS.innerHTML = `                    <div class="reviews">
            <div class="top_review">
                <p id="name_client">${row.client_name}</p>
                <p id="date_coment">${row.fecha_comentario}</p>
            </div>
            <div class="comentary-data">
                <p class="coment">comentary:</p>
                <div class="data">
                    <p id="comentary">${row.comentario}</p>
                    <div class="valoration" id='valorations'>
                    <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
                    class='bx bxs-star'></i><i class='bx bxs-star'></i>
                    </div>
                </div>
            </div>
        </div>`;
    });
    REVIEWS_RECORDS.textContent = "(" + JSON.message + ")";
  } else {
    REVIEWS.innerHTML = `
        <div class="reviews">
            <h3>There's no comments to show</h3>
        </div>`;
  }
}
// function valoration(valoration){
//     if (valoration=5) {
//         VALORATION.innerHTML=`<i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
//         class='bx bxs-star'></i><i class='bx bxs-star'></i>`;
//     }else if(valoration=4){
//         VALORATION.innerHTML=`<i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
//         class='bx bxs-star'></i><i class='bx bxs-star' id="star-5"></i>`
//     }
// }
async function productRelated(form) {
  PRODUCTS_RELATED.innerHTML = "";
  const JSON = await dataFetch(PRODUCT_API, "productsRelated", form);
  if (JSON.status) {
    JSON.dataset.forEach((row) => {
      PRODUCTS_RELATED.innerHTML = `
            <div class="col">
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
ORDER.addEventListener("submit", async (event) => {
  event.preventDefault();
  const FORM = new FormData(ORDER);
  const JSON = await dataFetch(ORDER_API, "createDetail", FORM);
  if (JSON.status) {
    sweetAlert(1, JSON.message, true);
  } else if (JSON.session) {
    sweetAlert(2, JSON.exception, false);
  } else {
    sweetAlert(3, JSON.exception, true);
  }
});
