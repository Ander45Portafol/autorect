const MAIL = 'helpers/email.php';
const CONTACT_API = 'bussines/public/contacts.php';

const idInput = document.getElementById("idinput");
const nameInput = document.getElementById("nameinput");
const emailInput = document.getElementById("emailinput");
const messageInput = document.getElementById("messageinput");
const btnsubmit = document.getElementById("btn-submit");
const formInfo = document.getElementById("contact_form");

var session = 0;


async function getUser(){
    const JSON = await dataFetch(USER_API, 'getUser');

    if (!JSON.session) {
        sweetAlert(3,'To send us a message, you need to log in',false);
        session = 0;
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    const JSON = await dataFetch(USER_API, 'getUser');
    
    if(JSON.status){
        idInput.value = JSON.id;
        nameInput.value = JSON.fullname;

        session = 1;
    }
});

nameInput.addEventListener('focus', () => {
    if(session == 0){
        getUser();
    }
});

emailInput.addEventListener('focus', () => {
    if(session == 0){
        getUser();
    }
});

messageInput.addEventListener('focus', () => {
    if(session == 0){
        getUser();
    }
});

formInfo.addEventListener('submit', async (event) => {
    event.preventDefault();
    
    const FORM = new FormData(formInfo);
    const JSON = await dataFetch(CONTACT_API, "sendMail", FORM);

    if (JSON.status && JSON.mail == 1) {
        sweetAlert(1, 'Email sent successfully', false);
        emailInput.value = '';
        messageInput.value = '';
    } else if(JSON.status && JSON.mail == 0){
        sweetAlert(3, 'Record saved, but mail could not be sent', false);
    } else{
        sweetAlert(2, JSON.exception, false);
    }
});