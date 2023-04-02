const MODEL_API = 'bussines/dashboard/models.php';
const CATEGORIA_API = 'businnes/dashboard/category.php';

const SEARCH_FORM = document.getElementById('search-form');

const SAVE_FORM = document.getElementById('save-form');

const MODAL_TITLE = document.getElementById('modal-title');

const TBODY_ROWS = document.getElementById('tbody-rows');

const RECORDS = document.getElementById('records');

const OPTIONS = {
    dismissible: false
}

M.Modal.init(document.querySelectorAll('.modal'), OPTIONS);

const SAVE_MODAL = M.Modal.getInstance(document.getElementById('save-modal'));

document.addEventListener('DOMContentLoaded', () => {
    fillTable();
});

SEARCH_FORM.addEventListener('submit', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    fillTable(FORM);
});

SAVE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    (ducment.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(MODEL_API, action, FORM);
    if (JSON.status) {
        fillTable();
        SAVE_MODAL.close();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';

    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(MODEL_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            (row.nombre_modelo) ? icon = 'visibility' : icon = 'visibility_off';
            TBODY_ROWS.innerHTML += `
            <tr>
                    <td>${row.nombre_modelo}</td>
                    <td>${row.anio_modelo}</td>
                    <td>${row.id_marca}</td>
                    <td><i class="material-icons">${icon}</i></td>
                    <td>
                        <a onclick="openUpdate(${row.id_modelo})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                            <i class="material-icons">mode_edit</i>
                        </a>
                        <a onclick="openDelete(${row.id_modelo})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            `;
        });

        M.MaterialBox.init(documeent.querySelectorAll('.materialboxed'));
        M.tooltip.init(document.querySelectorAll('.tooltipped'));
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

function openCreate() {
    SAVE_MODAL.open();
    SAVE_FORM.reset();
    MODAL_TITLE.textContent = 'REGISTER MODEL';
    fillSelect(CATEGORIA_API, 'readAll', 'categoria');
}

async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id', id);
    const JSON = await dataFetch(MODEL_API, 'readOne', FORM);
    if (JSON.status) {
        SAVE_MODAL.open();
        SAVE_FORM.reset();
        MODAL_TITLE.textContent = 'UPDATE MODEL';
        document.getElementById('id').value = JSON.dataset.id_modelo;
        document.getElementById('nombre_modelo').value = JSON.dataset.nombre_modelo;
        document.getElementById('id_marca').value = JSON.dataset.id_marca;
        fillSelect(CATEGORIA_API, 'readAll', 'categoria', JSON.dataset.id_categoria);
        M.updateTextFields();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    const RESPONSE = await confirmAction('Are you sure you want to delete this model?');
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_modelo', id);
        const JSON = await dataFetch(MODEL_API, 'delete', FORM);
        if (JSON.status) {
            fillTable();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}