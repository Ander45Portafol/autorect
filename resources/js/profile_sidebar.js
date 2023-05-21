const SIDEBAR=document.querySelector('aside');
const PARAMS = new URLSearchParams(location.search);
const USER_API = 'bussines/public/clients.php';

document.addEventListener('DOMContentLoaded',async ()=>{
    const FORM = new FormData();
    FORM.append("id_cliente", PARAMS.get("id"));
    const JSON=await dataFetch(USER_API,'readOne',FORM);
    if (JSON.status) {
        url = `product_history.html?id=${JSON.dataset.id_cliente}`;
        urlprofile=`profile.html?id=${JSON.dataset.id_cliente}`;
        SIDEBAR.innerHTML=`
<div class="offcanvas-body">
    <div class="user-info">
        <img src="../../resources/images/perfil.svg" alt="Kendrick Kumar">
        <h3>${JSON.dataset.usuario_cliente}</h3>
        <h4>Client</h4>
    </div>
    <div class="options-container">
        <a href=${urlprofile}><i class='bx bx-menu'></i>User information</a>
        <a href="${url}"><i class='bx bxs-cart'></i>Product History</a>
        <a href=""><i class='bx bxs-cog'></i>Configuration</a>
    </div>
</div>`;
    }else{
        console.log(PARAMS.get("id"));
    }
})