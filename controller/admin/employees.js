const EMPLOYEE_API = 'bussines/dashboard/employee.php';
const MODAL_TITLE = document.getElementById('exampleModalLabel');
const SAVE_FORM = document.getElementById('save-form');
const TBODY_ROWS = document.getElementById('tbody-rows');
const SEARCH_FORM = document.getElementById('form-search');
const SWITCH_STATE_EMPLOYEE=document.getElementById('flexSwitchCheckChecked')

document.addEventListener('DOMContentLoaded', () => {
    fillTable();
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
                            <button class="edit" id="editbtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="updateEmployee(${row.id_empleado})">
                                <i class="bx bxs-edit"></i>
                            </button>
                            <button class="delete" id="deletebtn" onclick="deleteEmployee(${row.id_empleado})">
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

SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(EMPLOYEE_API, action, FORM);
    if (JSON.status) {
        fillTable();
        sweetAlert(1, JSON.message, true);
        Clean();
        document.getElementById('btnclose').click();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
})

const Clean = () => {
    document.getElementById('id').value = '';
    document.getElementById('Employee_name').value = '';
    document.getElementById('Employee_lastname').value = '';
    document.getElementById('Employee_dui').value = '';
    document.getElementById('Employee_phone').value = '';
    document.getElementById('Employee_email').value = '';
    document.getElementById('Employee_date').value = '';
    document.getElementById('Employee_address').value = '';
}

SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    fillTable(FORM);
})

function createEmployee() {
    MODAL_TITLE.textContent = 'CREATE EMPLOYEE';
    fillSelect(EMPLOYEE_API, 'readTypes', 'types');
    document.getElementById('update').style.display = 'none';
    document.getElementById('adduser').style.display = 'block';
    document.getElementById('clean').style.display = 'block';
}
async function updateEmployee(id) {
    const FORM = new FormData();
    FORM.append('id', id);
    const JSON = await dataFetch(EMPLOYEE_API, 'readOne', FORM);
    if (JSON.status) {
        MODAL_TITLE.textContent = 'UPDATE EMPLOYEE';
        document.getElementById('update').style.display = 'block';
        document.getElementById('adduser').style.display = 'none';
        document.getElementById('clean').style.display = 'none';
        document.getElementById('id').value = JSON.dataset.id_empleado;
        document.getElementById('Employee_name').value = JSON.dataset.nombre_empleado;
        document.getElementById('Employee_lastname').value = JSON.dataset.apellido_empleado;
        document.getElementById('Employee_dui').value = JSON.dataset.dui_empleado;
        document.getElementById('Employee_email').value = JSON.dataset.correo_empleado;
        document.getElementById('Employee_phone').value = JSON.dataset.telefono_empleado;
        document.getElementById('Employee_date').value = JSON.dataset.nacimiento_empleado;
        document.getElementById('Employee_address').value = JSON.dataset.direccion_empleado;
        if (JSON.dataset.estado_empleado) {
            document.getElementById('flexSwitchCheckDefault').checked=true;
        }else{
            document.getElementById('flexSwitchCheckDefault').checked=false;
        }
        fillSelect(EMPLOYEE_API, 'readTypes', 'types', JSON.dataset.id_tipo_empleado);
    }

}
async function deleteEmployee(id) {
    const RESPONSE = await confirmAction('Do you want to delete this employee?')
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