const FORM_SESSION=document.getElementById('formlogin');

FORM_SESSION.addEventListener('submit', async (event)=>{
    event.preventDefault();
    const FORM=new FormData(FORM_SESSION);
    const JSON =await dataFetch(USER_API,'login',FORM);
    if (JSON.status) {
        sweetAlert(1,JSON.message,true,'index.html');
    }else{
        sweetAlert(2,JSON.exception,false);
    }
})