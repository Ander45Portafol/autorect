const PRODUCT_API = 'bussines/public/products.php';
const PRODUCT = document.getElementById('cards_container');
const SEARCH_PRODUCT = document.getElementById('search-product');

document.addEventListener('DOMContentLoaded', async () => {
    FillProduct();
    categoriesFilter();
    priceFilter();
    yearsFilter();
})
SEARCH_PRODUCT.addEventListener('submit', async (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_PRODUCT);
    FillProduct(FORM);
})

async function searchProduct(){
    const FORM = new FormData(SEARCH_PRODUCT);
    FillProduct(FORM);
}

async function FillProduct(form = null) {
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(PRODUCT_API, action, form);
    if (JSON.status) {
        PRODUCT.innerHTML = '';
        JSON.dataset.forEach(row => {
            url = `product_details.html?id=${row.id_producto}&categoria=${row.id_categoria}`;
            console.log(url);
            PRODUCT.innerHTML += `                    <div class="col">
            <div class="card">
                <img src="${SERVER_URL}images/products/${row.imagen_principal}" class="imagen_product">
                <div class="card-body">
                    <h5 class="card-title">${row.nombre_producto}</h5>
                    <p class="card-text"><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
                            class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                        <span>${row.precio_producto}</span>
                        <a href="${url}" onclick="probar(${url})" class="button" type="button"><i
                                class='bx bxs-cart'></i></a>
                    </p>
                </div>
            </div>
        </div>`;
        });
    }
}

const CATEGORIES_SECTION = document.getElementById('list-categories');

async function categoriesFilter() {
    const JSON = await dataFetch(PRODUCT_API, 'categoriesFilter');
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            CATEGORIES_SECTION.innerHTML += ` 
            <li class="categories-item list-group-item d-flex justify-content-between align-items-center">
                <input class="form-check-input" type="radio" id="input${row.nombre_categoria}" value="${row.id_categoria}" name="categoryID">
                ${row.nombre_categoria}
                <span class="categories-count counter badge rounded-pill">${row.num}</span>
            </li>
            `;
        }
        )
    }
}

const PRICE_SECTION = document.getElementById('price-section');

async function priceFilter() {
    const JSON = await dataFetch(PRODUCT_API, 'priceFilter');
    if (JSON.status) {
        const row = JSON.dataset[0];

        PRICE_SECTION.innerHTML = ` 
        <label for="priceRangeLeft" class="form-label lab">All prices</label>
        <input type="range" class="form-range" id="priceRange" name="priceRange" min="0" max="${row.maxi}" value="0">
        <label for="priceRangeRight" class="form-label lab lab2">$${row.maxi}.00</label>
        <p id="selectedValue">All prices</p>
        `

        const priceRangeInput = document.getElementById('priceRange');
        const selectedValueText = document.getElementById('selectedValue');

        priceRangeInput.addEventListener("input", function() {
        if(priceRangeInput.value == 0){
            selectedValueText.textContent = "Value: All prices";
        }else{
            selectedValueText.textContent = "Value: $" + priceRangeInput.value + ".00";
        }
        })
    }
}

const YEARS_SECTION = document.getElementById('years-list');

async function yearsFilter(){
    const JSON=await dataFetch(PRODUCT_API,'yearsFilter');
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            YEARS_SECTION.innerHTML += ` 
            <li class="years-item list-group-item d-flex justify-content-between align-items-center">
                <input class="form-check-input" type="radio" id="input${row.anio}" value="${row.anio}" name="modelYear">
                ${row.anio}
            <span class="years-count counter badge rounded-pill">${row.num}</span>
            </li>
            `;
        }
    )}
}

const FORM = document.getElementById('filters');

FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    const FORMDATA = new FormData(FORM);

    const JSON = await dataFetch(PRODUCT_API, 'filterSearch', FORMDATA);

    if (JSON.status) {
        PRODUCT.innerHTML = '';
        JSON.dataset.forEach(row => {
            url = `product_details.html?id=${row.id_producto}&categoria=${row.id_categoria}`;
            console.log(url);
            PRODUCT.innerHTML += `                    <div class="col">
            <div class="card">
                <img src="${SERVER_URL}images/products/${row.imagen_principal}" class="imagen_product">
                <div class="card-body">
                    <h5 class="card-title">${row.nombre_producto}</h5>
                    <p class="card-text"><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i
                            class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                        <span>${row.precio_producto}</span>
                        <a href="${url}" onclick="probar(${url})" class="button" type="button"><i
                                class='bx bxs-cart'></i></a>
                    </p>
                </div>
            </div>
        </div>`;
        });
    }else{
        sweetAlert(3, 'There is no products to show', false);
        FillProduct();
        cleanForm();
    }

    for (const pair of FORMDATA.entries()) {
        console.log(pair[0] + ':', pair[1]);
    }
})

function cleanForm() {
    var elements = FORM.elements;
  
    for (var i = 0; i < elements.length; i++) {
      var element = elements[i];
  
      switch (element.type) {
        case "range":
          element.value = 0;
          document.getElementById('selectedValue').textContent = "Value: All prices";
        break;

        case "radio":
          element.checked = false;
          break;
      }
    }
  }
  