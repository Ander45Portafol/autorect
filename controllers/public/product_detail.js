const PRODUCT_API = "bussines/public/products.php";
const PARAMS = new URLSearchParams(location.search);
const PRODUCTS_RELATED = document.getElementById("cards_container");
const PRODUCT_TITLE = document.getElementById("product_title");
const REVIEWS = document.getElementById("product_reviews");
const VALORATION = document.getElementById("valorations");
const REVIEWS_RECORDS = document.getElementById("number_reviews");
const ORDER_API = "bussines/public/order.php";
const ORDER = document.getElementById("add_product");
const PRODUCT_IMGS = document.getElementById("otherimages");

document.addEventListener("DOMContentLoaded", async () => {
    const FORM = new FormData();
    FORM.append("id_categoria", PARAMS.get("categoria"));
    FORM.append("id_producto", PARAMS.get("id"));
    productData(FORM);
    productRelated(FORM);
    productReviews(FORM);
    productImgs(FORM);
    const JSON = await dataFetch(PRODUCT_API, "readOnePublic", FORM);
    if (JSON.status) {
        document.getElementById("id_product").value = JSON.dataset.id_producto;
    }
});
async function productData(form) {
    const JSONP = await dataFetch(PRODUCT_API, "readOnePublic", form);
    if (JSONP.status) {
        let starsHTML = ''; // Variable to store the HTML of the stars

        // Generate stars based on the rating
        const fullStars = Math.floor(JSONP.dataset.calificacion); // Number of full stars - Math floor returns the first number, it doesn't matter the numbers after the point
        const decimalPart = JSONP.dataset.calificacion - fullStars; // Decimal part of the rating

        for (let i = 0; i < fullStars; i++) {
            starsHTML += "<i class='bx bxs-star'></i>"; // Add full star
        }

        if (decimalPart >= 0.5) {
            starsHTML += "<i class='bx bxs-star-half'></i>"; // Add half star
        }

        const remainingStars = 5 - fullStars - Math.round(decimalPart); // Number of remaining stars - Math round for normal rounding

        for (let i = 0; i < remainingStars; i++) {
            starsHTML += "<i class='bx bx-star'></i>"; // Add empty star
        }

        PRODUCT_TITLE.textContent = JSONP.dataset.nombre_producto;
        document.getElementById("price_product").textContent =
            "$" + JSONP.dataset.precio_producto;
        document.getElementById("category_product").textContent =
            JSONP.dataset.nombre_categoria;
        document.getElementById("description_product").textContent =
            JSONP.dataset.descripcion_producto;
        document.getElementById("brand_product").textContent =
            JSONP.dataset.nombre_modelo;
        document.getElementById("status_product").textContent =
            JSONP.dataset.estado_producto;
        document.getElementById("img_principal").src = "../../api/images/products/" + JSONP.dataset.imagen_principal;
        document.getElementById("valoration").innerHTML += `                        
    <p class="red" id="stars">${JSONP.dataset.calificacion} ${starsHTML} </p>
    <p> ${JSONP.dataset.valo} (costumers reviews)</p>`;
        document.getElementById('product_exits').max = JSONP.dataset.existencias;
        document.getElementById('product_exits').min = 0;
        console.log(JSONP.dataset.existencias);
    }
}

async function productImgs(form) {
    PRODUCT_IMGS.innerHTML = "";
    const JSON = await dataFetch(PRODUCT_API, "readProductImgsPublic", form);
    if (JSON.status) {
        JSON.dataset.forEach((row) => {
            PRODUCT_IMGS.innerHTML += `
      <img class="images" src="../../api/images/products/${row.nombre_archivo_imagen}" alt="img">`;
        });

        //Change principal img src when the user click a secondary img
        const principalImg = document.getElementById('img_principal');
        const images = document.querySelectorAll('.otherimages .images');

        // Add a click event handler to each secondary image
        images.forEach((image) => {
            image.addEventListener('click', () => {
                // Get the source of the clicked secondary image
                const newSrc = image.getAttribute('src');

                // Swap the source between the main image and the secondary image
                const currentSrc = principalImg.getAttribute('src');
                principalImg.setAttribute('src', newSrc);
                image.setAttribute('src', currentSrc);

            });
        });
    }
}

async function productReviews(form) {
    REVIEWS.innerHTML = "";
    const JSON = await dataFetch(PRODUCT_API, "productReview", form);
    if (JSON.status) {
        JSON.dataset.forEach((row) => {

            let starsHTML = ''; // Variable to store the HTML of the stars
            // Generate stars based on the rating
            const fullStars = Math.floor(row.calificacion_producto); // Number of full stars - Math floor returns the first number, it doesn't matter the numbers after the point
            const remainingStars = 5 - fullStars;

            for (let i = 0; i < fullStars; i++) {
                starsHTML += "<i class='bx bxs-star'></i>"; // Add full star
            }

            for (let i = 0; i < remainingStars; i++) {
                starsHTML += "<i class='bx bx-star'></i>"; // Add empty star
            }

            REVIEWS.innerHTML += `                    <div class="reviews">
            <div class="top_review">
                <p id="name_client">${row.client_name}</p>
                <p id="date_coment">${row.fecha_comentario}</p>
            </div>
            <div class="comentary-data">
                <p class="coment"></p>
                <div class="data">
                    <p id="comentary">${row.comentario}</p>
                    <div class="valoration" id='valorations'>
                    ${row.calificacion_producto} ${starsHTML}
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
            let starsHTML = ''; // Variable to store the HTML of the stars

            // Generate stars based on the rating
            const fullStars = Math.floor(row.calificacion); // Number of full stars - Math floor returns the first number, it doesn't matter the numbers after the point
            const decimalPart = row.calificacion - fullStars; // Decimal part of the rating

            for (let i = 0; i < fullStars; i++) {
                starsHTML += "<i class='bx bxs-star'></i>"; // Add full star
            }

            if (decimalPart >= 0.5) {
                starsHTML += "<i class='bx bxs-star-half'></i>"; // Add half star
            }

            const remainingStars = 5 - fullStars - Math.round(decimalPart); // Number of remaining stars - Math round for normal rounding

            for (let i = 0; i < remainingStars; i++) {
                starsHTML += "<i class='bx bx-star'></i>"; // Add empty star
            }
            PRODUCTS_RELATED.innerHTML += `
            <div class="col">
            <div class="card">
                <img src="${SERVER_URL}images/products/${row.imagen_principal}" class="imagen_product">
                <div class="card-body">
                    <h5 class="card-title">${row.nombre_producto}</h5>
                    <p class="card-text">${starsHTML}
                        <span>$${row.precio_producto}</span>
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
