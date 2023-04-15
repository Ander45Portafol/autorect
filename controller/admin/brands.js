const TBODY_ROWS = document.getElementById('tbody-rows');
const BRANDS_API = 'bussines/dashboard/brands.php';

document.addEventListener('DOMContentLoaded', () => {
    fillTable()
})

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
                    <td>${row.logo_marca}</td>
                    <td>
                        <div class="actions">
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="updateCategory(${row.id_marca})">
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