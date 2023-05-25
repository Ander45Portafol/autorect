const CLIENT = document.getElementById('contained'); // HTML element to display user data.

// When the DOM is loaded, execute the initialization functions
document.addEventListener('DOMContentLoaded', async () => {
    const FORM = new FormData();
    FORM.append('id_cliente', PARAMS.get("id"));
    // Fetch client data from the API
    const JSON = await dataFetch(USER_API, 'readOne', FORM);
    if (JSON.status) {
        CLIENT.innerHTML = `
                <div id="contained">
                <ul class="list-group">
                    <li class="list-group-item">Name: <span id="name_span" name="Name_Span">${JSON.dataset.nombre_cliente}</span></li>
                    <li class="list-group-item">Lastname: <span id="lastname_span" name="Lastname_Span">${JSON.dataset.apellido_cliente}</span>
                    </li>
                    <li class="list-group-item">DUI: <span id="dui_span" name="Dui_Span">${JSON.dataset.dui_cliente}</span></li>
                    <li class="list-group-item">E-mail: <span id="mail_span" name="Mail_Span">${JSON.dataset.correo_cliente}</span></li>
                    <li class="list-group-item">Phone-number: <span id="phone_span" name="Phone_Span">${JSON.dataset.telefono_cliente}</span>
                    </li>
                    <li class="list-group-item">Address: <span id="address_span" name="Address_Span">${JSON.dataset.direccion_cliente}</span></li>
                    <li class="list-group-item">Username: <span id="username_span" name="Username_Span">${JSON.dataset.usuario_cliente}</span>
                    </li>
                </ul>
            </div>`;
    }
});