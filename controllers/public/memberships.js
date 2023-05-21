const MEMBERSHIP_API = 'bussines/public/memberships.php';
const MEMBERSHIP_SECTION = document.getElementById('memb-row');
const MODAL_SECTION = document.getElementById('modals');

document.addEventListener('DOMContentLoaded', async () => {
    fillMemberships();
    fillModals();
})

async function fillMemberships() {
    const JSON = await dataFetch(MEMBERSHIP_API, 'readPay');
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            MEMBERSHIP_SECTION.innerHTML += `    
            <div class="memb-col col-lg-6 col-sm-12">
                    <div class="card">
                        <h5 class="card-header">${row.tipo_membresia}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 price-top">
                                    <h1 class="price">$${row.precio_membresia_int}</h1>
                                </div>
                                <div class="col-7 desp-price">
                                    <p class="text-price">a single payment</p>
                                    <p class="text-price">per user</p>
                                </div>
                            </div>
                            <div class="row benefits-row">
                                <div class="col-12">
                                    <h5>Discounts and other benefits</h5>
                                </div>
                                <div class="col-12">
                                    <button onclick="getUser('#modal${row.tipo_membresia}')"> Get started </button>
                                </div>
                            </div>
                            <div class="row features-row">
                                <div class="col-12">
                                    <h5>Features</h5>
                                </div>
                                <div class="col-12">
                                    <p>${row.descripcion_membresia}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        })
    }
}

async function fillModals() {
    const JSON = await dataFetch(MEMBERSHIP_API, 'readPay');
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            MODAL_SECTION.innerHTML += `    
            <!-- Modal -->
                <div class="modal fade" id="modal${row.tipo_membresia}" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="modal${row.tipo_membresia}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modal${row.tipo_membresia}Label">Confirm purchase</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="img-purchase-col col-lg-6 col-sm-12">
                                        <img src="../../api/images/memberships/${row.imagen_membresia}" alt="${row.tipo_membresia}">
                                    </div>
                                    <hr>
                                    <div class="info-purchase-col col-lg-6 col-sm-12">
                                        <div class="separator"></div>
                                        <div class="content">
                                            <p>Product: <span>${row.tipo_membresia} membership</span></p>
                                            <p>Quantity: <span>1</span></p>
                                            <p>Price: <span>${row.precio_membresia}</span></p>
                                            <p>Subtotal: <span>${row.precio_membresia}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-m modal-footer text-left">
                                <p>Whole Purchase Price: <span> ${row.precio_membresia} </span></p>
                                <button type="button" class="btn-confirm" onclick="updateMembership(${row.id_tipo_membresia})">Confirm purchase</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        })

    }
}

var client_id = 0;
var client_membership = 0;

async function updateMembership(type_id){
    const FORM = new FormData();
    FORM.append('id_tipo_membresia', type_id);
    FORM.append('id_cliente', client_id);

    const actual = await dataFetch(USER_API, 'readActualMembership', FORM);
    client_membership = actual.dataset.id_tipo_membresia;

    if(type_id == client_membership){
        sweetAlert(2,'You already belong to that membership',false);
    }else{
        const RESPONSE=await confirmAction('Confirm purchase?');
        if(RESPONSE){
            const JSON = await dataFetch(USER_API, 'updateMembership', FORM);
            if (JSON.status) {
                modal.hide();
                sweetAlert(5,JSON.message,false);
            }else{
                sweetAlert(2,JSON.exception,false);
            }
        }
    }
}

var modal;

async function getUser(id) {
    modal = new bootstrap.Modal(id);
    const JSON = await dataFetch(USER_API, 'getUser');

    if (!JSON.session) {
        sweetAlert(3, 'To buy a membership, you need to log in', false);
        return 0;
    }else{
        modal.show();
        client_id = JSON.id;
        client_membership = JSON.membership;
    }
}
