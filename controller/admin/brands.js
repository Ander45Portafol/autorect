//Constant to the API
const BRANDS_API = 'bussines/dashboard/brands.php';
//Constant to the table
const TBODY_ROWS = document.getElementById('tbody-rows');
//Constant to the form
const FORMU = document.getElementById('save-form-B');
//Constant to the model title
const MODAL_TITLE = document.getElementById('modal-title');
//Constant to the search form
const SEARCH_F = document.getElementById('form-search');

//Event to fill the table
document.addEventListener('DOMContentLoaded', () => {
    fillTable()
})

//Function to clean the form
const Clean = () => {
    document.getElementById('id').value = '';
    document.getElementById('brandname').value = '';
}

//Event to create or update a brand
FORMU.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(FORMU);
    const JSON = await dataFetch(BRANDS_API, action, FORM);
    if (JSON.status) {
        fillTable();
        Clean();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
})

//Event to search brands
SEARCH_F.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_F);
    fillTable(FORM);
})

//Function to fill the table
async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    (form) ? action = 'search' : action = 'readAll'
    const JSON = await dataFetch(BRANDS_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_marca}</td>
                    <td>${row.nombre_marca}</td>
                    <td><img src="${SERVER_URL}images/brands/${row.logo_marca}" class="image_product"></td>
                    <td class="action-btn">
                        <div class="actions">
                            <button type="button" class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="updateBrand(${row.id_marca})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="deleteBrand(${row.id_marca})">
                                <i class="bx bxs-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        })
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

//Function to prepare the form when the create button is clicked
function createBrand() {
    MODAL_TITLE.textContent = 'CREATE BRAND';
    document.getElementById('update').style.display = 'none';
    document.getElementById('adduser').style.display = 'block';
    document.getElementById('clean').style.display = 'block';
    document.getElementById('file').required=true;
}

//Function to prepare the form when the update button is clicked
async function updateBrand(id) {
    const FORM = new FormData();
    FORM.append('id', id);
    const JSON = await dataFetch(BRANDS_API, 'readOne', FORM);
    if (JSON.status) {
        MODAL_TITLE.textContent = 'UPDATE BRAND';
        document.getElementById('update').style.display = 'block';
        document.getElementById('adduser').style.display = 'none';
        document.getElementById('clean').style.display = 'none';
        document.getElementById('file').required=false;
        document.getElementById('id').value = JSON.dataset.id_marca;
        document.getElementById('brandname').value = JSON.dataset.nombre_marca;
    }
}

//Function to delete a brand
async function deleteBrand(id) {
    const RESPONSE = await confirmAction('Do you want to delete this brand?');
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_marca', id);
        const JSON = await dataFetch(BRANDS_API, 'delete', FORM);
        if (JSON.status) {
            fillTable();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, true);
        }
    }
}