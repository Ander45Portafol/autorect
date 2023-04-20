const EMPLOYEE_API = 'bussines/dashboard/employee.php';
const MODAL_TITLE = document.getElementById('modal-title');
const SAVE_FORM = document.getElementById('save-form');
const TBODY_ROWS = document.getElementById('tbody-rows');
const SEARCH_FORM = document.getElementById('form-search');

document.addEventListener('DOMContentLoaded', () => {
    fillTable();
})

SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(EMPLOYEE_API, action, FORM);
    if (JSON.status) {
        fillTable();
        sweetAlert(1, JSON.message, true);
        LimpiarCampos();
        document.getElementById('btnclose').click();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
})

async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    (form) ? action = 'search' : action = 'readAll'
    const JSON = await dataFetch(EMPLOYEE_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.id_empleado}</td>
                    <td>${row.nombre_empleado}</td>
                    <td>${row.apellido_empleado}</td>
                    <td>${row.dui_empleado}</td>
                    <td>${row.correo_empleado}</td>
                    <td>${row.telefono_empleado}</td>
                    <td>${row.estado_empleado}</td>
                    <td>${row.id_tipo_empleado}</td>
                    <td>
                        <div class="actions">
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="updateCategory(${row.id_empleado})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="DeleteEmployee(${row.id_empleado})">
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

const Clean = () => {
    document.getElementById('id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';
}

function createCategory() {
    MODAL_TITLE.textContent = 'CREATE CATEGORY';
    document.getElementById('update').style.display = 'none';
    document.getElementById('addcategory').style.display = 'block';
    document.getElementById('clean').style.display = 'block';
}
async function updateCategory(id) {
    const FORM = new FormData();
    FORM.append('id', id);
    const JSON = await dataFetch(CATEGORY_API, 'readOne', FORM);
    if (JSON.status) {
        MODAL_TITLE.textContent = 'UPDATE CATEGORY';
        document.getElementById('update').style.display = 'block';
        document.getElementById('addcategory').style.display = 'none';
        document.getElementById('clean').style.display = 'none';
        document.getElementById('id').value = JSON.dataset.id_categoria;
        document.getElementById('name').value = JSON.dataset.nombre_categoria;
        document.getElementById('description').value = JSON.dataset.descripcion_categoria;
    }

}
async function DeleteEmployee(id) {
    const RESPONSE = await confirmAction('¿Desea eliminar el empleado de forma permanente?')
    if (RESPONSE) {
        const FORM = new FormData()
        FORM.append('id_empleado', id)
        const JSON = await dataFetch(EMPLOYEE_API, 'delete', FORM)
        if (JSON.status) {
            fillTable()
            sweetAlert(1, JSON.message, true)
        } else {
            sweetAlert(2, JSON.exception, false)
        }
    }
}