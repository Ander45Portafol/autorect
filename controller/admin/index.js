// Constante para establecer el formulario de primer usuario.
const SINGUP_FORM=document.getElementById('sign_up')
// Constante para establecer el formulario de login.
const LOGIN_FORM=document.getElementById('form_login')

// Metodo manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async ()=>{
    // Peticion para consultar  los usuarios registrados
    const JSON=await dataFetch(USER_API,'readUsers')
    // Se comprueba si existe una sesion, de lo contrario se sigue con el flujo normal.
    if (JSON.session) {
        //Se direcciona a la pagina web del dashboard
        location.href='admin.html'
    }else if (JSON.status) {
        // Se muestra el formulari para iniciar sesion.
        sweetAlert(4,JSON.message,true)
    }else{
        // Se muestra el formulario par registrar el primer usuario
        sweetAlert(4,JSON.exception,true)
    }
})

// Metodo manejador de eventos para cuando se envia el formulario de inicio de sesion
LOGIN_FORM.addEventListener('submit', async(event)=>{
    //Se evita recargar la pagina web despues de enviar el formulario
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM=new FormData(LOGIN_FORM)
    //peticion para iniciar sesion.
    const JSON=await dataFetch(USER_API,'login',FORM)       	
    //Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con le excepcion.
    if (JSON.status) {
        sweetAlert(1,JSON.message,true,'admin.html')
    }else{
        sweetAlert(2,JSON.exception,false)
    }
})