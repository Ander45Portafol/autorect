const ORDER_DETAIL_API='bussines/dashboard/order_detail.php';
const TBODY_ROWS=document.getElementById('tbody_rows');

document.addEventListener('DOMContentLoaded', ()=>{
    fillTable();
})

async function fillTable(form=null){
    TBODY_ROWS.innerHTML='';
    (form)?action='search':action='readAll';
    const JSON= await dataFetch(ORDER_DETAIL_API,action,form);
    if (JSON.status) {
        JSON.dataset.forEach(row=>{
            TBODY_ROWS.innerHTML+=`
                <tr>
                    <td>${row.id_detalle_pedido}</td>
                    <td>${row.cantidad_producto}</td>
                    <td>${row.precio_producto}</td>
                    <td>${row.id_pedido}</td>
                    <td>${row.nombre_producto}</td>
                </tr>
            `;
        })
    }else{
        sweetAlert(4,JSON.exception,true);
    }
}