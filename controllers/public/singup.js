const SIGNUP_FORM=document.getElementById('data-registrer');

document.addEventListener('DOMContentLoaded', () => {
    // LLamada a la función para asignar el token del reCAPTCHA al formulario.
    reCAPTCHA();
    // Constante tipo objeto para obtener la fecha y hora actual.
    const TODAY = new Date();
    // Se declara e inicializa una variable para guardar el día en formato de 2 dígitos.
    let day = ('0' + TODAY.getDate()).slice(-2);
    // Se declara e inicializa una variable para guardar el mes en formato de 2 dígitos.
    var month = ('0' + (TODAY.getMonth() + 1)).slice(-2);
    // Se declara e inicializa una variable para guardar el año con la mayoría de edad.
    let year = TODAY.getFullYear() - 18;
    // Se declara e inicializa una variable para establecer el formato de la fecha.
    let date = `${year}-${month}-${day}`;
    // Se asigna la fecha como valor máximo en el campo del formulario.
    document.getElementById('nacimiento').max = date;
});

SIGNUP_FORM.addEventListener('submit',async (event)=>{
    event.preventDefault();
    const FORM =new FormData(SIGNUP_FORM);
    const JSON=await dataFetch(USER_API, 'signup',FORM)
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'login.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
})

function reCAPTCHA() {
    // Método para generar el token del reCAPTCHA.
    grecaptcha.ready(() => {
        // Constante para guardar la llave pública del reCAPTCHA.
        const PUBLIC_KEY = '6LdBzLQUAAAAAJvH-aCUUJgliLOjLcmrHN06RFXT';
        // Se obtiene un token para la página web mediante la llave pública.
        grecaptcha.execute(PUBLIC_KEY, { action: 'homepage' }).then((token) => {
            // Se asigna el valor del token al campo oculto del formulario
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
}