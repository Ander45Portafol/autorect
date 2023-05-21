const CONTACT_API = 'bussines/public/contacts.php'; // Path to contact API

const idInput = document.getElementById("idinput"); // Input field for ID
const nameInput = document.getElementById("nameinput"); // Input field for name
const emailInput = document.getElementById("emailinput"); // Input field for email
const messageInput = document.getElementById("messageinput"); // Input field for message
const btnsubmit = document.getElementById("btn-submit"); // Submit button
const formInfo = document.getElementById("contact_form"); // Contact form element

var session = 0; // Session variable

//Function to check the user data
async function getUser(){
    const JSON = await dataFetch(USER_API, 'getUser'); // Fetch user data from API

    if (!JSON.session) {
        sweetAlert(3,'To send us a message, you need to log in',false); // Display alert for user to log in
        session = 0; // Set session variable to 0
    }
}

//Event listener to fill the client name when the DOM is loaded
document.addEventListener('DOMContentLoaded', async () => {
    const JSON = await dataFetch(USER_API, 'getUser'); // Fetch user data from API when DOM is loaded
    
    if(JSON.status){
        idInput.value = JSON.id; // Set value of ID input field from user data
        nameInput.value = JSON.fullname; // Set value of name input field from user data

        session = 1; // Set session variable to 1
    }
});

//Function to check if the user logged in
nameInput.addEventListener('focus', () => {
    if(session == 0){
        getUser(); 
    }
});

//Function to check if the user logged in
emailInput.addEventListener('focus', () => {
    if(session == 0){
        getUser(); 
    }
});

//Function to check if the user logged in
messageInput.addEventListener('focus', () => {
    if(session == 0){
        getUser(); 
    }
});

//Event listener to send the email
formInfo.addEventListener('submit', async (event) => {
    event.preventDefault(); // Prevent form submission
    
    const FORM = new FormData(formInfo); // Create a new form data object with the formInfo
    
    // Send mail using contact API
    const JSON = await dataFetch(CONTACT_API, "sendMail", FORM);

    if (JSON.status && JSON.mail == 1) {
        sweetAlert(1, 'Email sent successfully', false); // Display success alert if mail is sent successfully
        emailInput.value = ''; // Clear email input field
        messageInput.value = ''; // Clear message input field
    } else if(JSON.status && JSON.mail == 0){
        sweetAlert(3, 'Record saved, but mail could not be sent', false); // Display alert if mail could not be sent
    } else{
        sweetAlert(2, JSON.exception, false); // Display alert for any other exceptions
    }
});
