//constant to use the container at the SING UP form 
const SINGUP_FORM=document.getElementById('sign_up')
//constant to use the formulary at the SING UP form 
const FORM_SIGNUP=document.getElementById('contained-signup')
//constant to use the container at the LOGIN form 
const LOGIN_FORM=document.getElementById('form_login')
//constant to use the formulary at the LOGIN form 
const APARECER_LOGIN=document.getElementById('contained-login')
//This event is to charger the elements in the page
document.addEventListener('DOMContentLoaded', async ()=>{
    //This variable is to validate if users exits
    const JSON=await dataFetch(USER_API,'readUsers')
    //Validate if session is started else the SING UP form is visible
    if (JSON.session) {
        location.href='admin.html'
    }else if (JSON.status) {
        sweetAlert(4,JSON.message,true)
    }else{
        //The SING UP form is visible
        APARECER_LOGIN.style.display='none'
        FORM_SIGNUP.style.display='block'
        sweetAlert(4,JSON.exception,true)
    }
})

//This event is to send the datas at validate if the credencials are corrects
LOGIN_FORM.addEventListener('submit', async(event)=>{
    //This event is used to don't recharger the website
    event.preventDefault();
    //Constant like object with the formulary datas
    const FORM=new FormData(LOGIN_FORM)
    //Send at the API that action is to do
    const JSON=await dataFetch(USER_API,'login',FORM)       	
    //Is validate if the answer at the API is to be OK, or not
    if (JSON.status) {
        sweetAlert(1,JSON.message,true,'admin.html')
    }else{
        sweetAlert(2,JSON.exception,false)
    }
})