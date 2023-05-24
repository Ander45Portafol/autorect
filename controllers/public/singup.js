//Path to the API
const USER_API = 'bussines/public/clients.php';

//Get HTML element for the data register
const SIGNUP_FORM=document.getElementById('data-registrer');

//Event listener to singup
SIGNUP_FORM.addEventListener('submit',async (event)=>{
    event.preventDefault();
    const FORM =new FormData(SIGNUP_FORM);
    const JSON=await dataFetch(USER_API, 'signup',FORM)
    if (JSON.status) {
        sweetAlert(1, JSON.message, true, 'login_public.html');
    } else {
        sweetAlert(2, JSON.exception, false);
    }
})