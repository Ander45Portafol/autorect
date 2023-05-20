const SIDEBAR=document.querySelector('aside');

document.addEventListener('DOMContentLoaded',()=>{
SIDEBAR.innerHTML=`
<div class="offcanvas-body">
    <div class="user-info">
        <img src="../../resources/images/perfil.svg" alt="Kendrick Kumar">
        <h3>Kendrick Kumar</h3>
        <h4>Client</h4>
    </div>
    <div class="options-container">
        <button><i class='bx bx-menu'></i>User information</button>
        <button><i class='bx bxs-cart'></i>Product History</button>
        <button><i class='bx bxs-cog'></i>Configuration</button>
    </div>
</div>`;
})