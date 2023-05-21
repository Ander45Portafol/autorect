
const PRODUCTS = document.getElementById('list_product');
const PRODUCTS_API = 'bussines/public/products.php';
document.addEventListener('DOMContentLoaded', () => {
    const FORM = new FormData();
    FORM.append("id_cliente", PARAMS.get("id"));
    productHistory(FORM);
})

async function validateComments(id_detalle) {
    const FORM = new FormData();
    FORM.append("id_detalle", id_detalle);
    const JSONC = await dataFetch(PRODUCTS_API, 'validateComments', FORM);
    if (JSONC.dataset === false) {
        document.getElementById('button2').style.display='none';
    }
}
async function productHistory(form) {
    const JSON = await dataFetch(PRODUCTS_API, 'hsitoryProduct', form);
    if (JSON.status) {
        JSON.dataset.forEach((row) => {
            if (row.id_estado_pedido === 4) {
                PRODUCTS.innerHTML += `                   <li class="list-group-item">
                                <div>
                                <img src="../../resources/images/lambo_ejem.svg" alt="">
                                <div class="info">
                                    <h1>${row.nombre_producto}</h1>
                                    <h5>Hola</h5>
                                </div>
                                </div>
                                <div>
                                    <button type="button" id="button1" class="btn btn-primary">
                                    <i class='bx bxs-trash'></i>
                                    </button>
                                    <button type="button" id="button2" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <i class='bx bxs-comment' ></i>
                                    </button>
                                </div>
                            </li>`;
                            validateComments(row.id_detalle_pedido);
            } else {
                PRODUCTS.innerHTML += `                   <li class="list-group-item">
                    <img src="../../resources/images/lambo_ejem.svg" alt="">
                    <div class="info">
                        <h1>${row.nombre_producto}</h1>
                        <h5>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim fugit, quasi laboriosam
                            provident consequuntur fugiat quibusdam, at, obcaecati cumque sint possimus odio
                            mollitia voluptate veniam molestias maxime eligendi veritatis quidem!</h5>
                    </div>
                </li>`;
            }
        });
    }
}