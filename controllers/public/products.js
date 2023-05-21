const PRODUCT_API = 'bussines/public/products.php'; // API endpoint for products
const PRODUCT = document.getElementById('cards_container'); // HTML element to display products
const SEARCH_PRODUCT = document.getElementById('search-product'); // Search form

// When the DOM is loaded, execute the initialization functions
document.addEventListener('DOMContentLoaded', async () => {
    FillProduct();
    categoriesFilter();
    priceFilter();
    yearsFilter();
});

// Event listener for the search product form submission
SEARCH_PRODUCT.addEventListener('submit', async (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_PRODUCT);
    FillProduct(FORM);
});

// Function to search for products based on the form data
async function searchProduct() {
    const FORM = new FormData(SEARCH_PRODUCT);
    FillProduct(FORM);
}

// Function to fetch and display products based on the form data
async function FillProduct(form = null) {
    const action = form ? 'search' : 'readAll'; // Determine the action based on whether a form is provided or not

    // Fetch product data from the API
    const JSON = await dataFetch(PRODUCT_API, action, form);

    if (JSON.status) {
        PRODUCT.innerHTML = '';
        JSON.dataset.forEach(row => {
            const url = `product_details.html?id=${row.id_producto}&categoria=${row.id_categoria}`;
            console.log(url);
            PRODUCT.innerHTML += `
                <div class="col">
                    <div class="card">
                        <img src="${SERVER_URL}images/products/${row.imagen_principal}" class="imagen_product">
                        <div class="card-body">
                            <h5 class="card-title">${row.nombre_producto}</h5>
                            <p class="card-text">
                                <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                                <span>${row.precio_producto}</span>
                                <a href="${url}" class="button" type="button"><i class='bx bxs-cart'></i></a>
                            </p>
                        </div>
                    </div>
                </div>`;
        });
    }
}

// Get the categories section in the HTML
const CATEGORIES_SECTION = document.getElementById('list-categories');

// Fetch categories filter data and update the UI
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
        });
    }
}

// Get the categories section in the HTML
const PRICE_SECTION = document.getElementById('price-section');

// Fetch price filter data and update the UI
async function priceFilter() {
    const JSON = await dataFetch(PRODUCT_API, 'priceFilter');
    if (JSON.status) {
        const row = JSON.dataset[0];

        // Update the HTML content of PRICE_SECTION with dynamic values
        PRICE_SECTION.innerHTML = `
            <label for="priceRangeLeft" class="form-label lab">All prices</label>
            <input type="range" class="form-range" id="priceRange" name="priceRange" min="0" max="${row.maxi}" value="0">
            <label for="priceRangeRight" class="form-label lab lab2" id="max-price">$${row.maxi}.00</label>
            <p id="selectedValue">All prices</p>
        `;

        // Get references to UI elements
        const priceRangeInput = document.getElementById('priceRange');
        const maxPrice = document.getElementById('max-price');
        const selectedValueText = document.getElementById('selectedValue');

        // Add an event listener to update the selected value text based on the price range input
        priceRangeInput.addEventListener("input", function() {
            if (priceRangeInput.value == 0) {
                selectedValueText.textContent = "Value: All prices";
            } else if (maxPrice.innerText == ("$" + priceRangeInput.value + ".00")) {
                selectedValueText.textContent = "Value: $" + priceRangeInput.value + ".00";
            } else {
                selectedValueText.textContent = "Value: $" + priceRangeInput.value + ".00 - " + maxPrice.innerText;
            }
        });
    }
}

// Get the YEARS_SECTION element
const YEARS_SECTION = document.getElementById('years-list');

// Fetch years filter data and update the UI
async function yearsFilter() {
    const JSON = await dataFetch(PRODUCT_API, 'yearsFilter');
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            // Append HTML content to YEARS_SECTION for each year
            YEARS_SECTION.innerHTML += ` 
            <li class="years-item list-group-item d-flex justify-content-between align-items-center">
                <input class="form-check-input" type="radio" id="input${row.anio}" value="${row.anio}" name="modelYear">
                ${row.anio}
            <span class="years-count counter badge rounded-pill">${row.num}</span>
            </li>
            `;
        });
    }
}

// Get the FORM element
const FORM = document.getElementById('filters');

// Add a submit event listener to the form
FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    const FORMDATA = new FormData(FORM);

    const JSON = await dataFetch(PRODUCT_API, 'filterSearch', FORMDATA);

    if (JSON.status) {
        PRODUCT.innerHTML = '';
        JSON.dataset.forEach(row => {
            // Create the URL for the product details page
            const url = `product_details.html?id=${row.id_producto}&categoria=${row.id_categoria}`;
            console.log(url); // Comment: Logging the URL for debugging purposes

            // Append HTML content to the PRODUCT element
            PRODUCT.innerHTML += `
                <div class="col">
                    <div class="card">
                        <img src="${SERVER_URL}images/products/${row.imagen_principal}" class="imagen_product">
                        <div class="card-body">
                            <h5 class="card-title">${row.nombre_producto}</h5>
                            <p class="card-text">
                                <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                                <span>${row.precio_producto}</span>
                                <a href="${url}" onclick="probar(${url})" class="button" type="button"><i class='bx bxs-cart'></i></a>
                            </p>
                        </div>
                    </div>
                </div>`;
        });
    } else {
        sweetAlert(3, 'There are no products to show', false); // Alert the user that there are no products to show
        FillProduct(); // Fill the products 
        cleanForm(); // Reset the form
    }
});

//Reset the form
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
