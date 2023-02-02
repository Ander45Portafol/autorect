let formularioLogin = document.querySelector(".formulario");
let formularioResgistro = document.querySelector(".formRegistrer");

const changepanelRegistrer = () => {
  formularioResgistro.style.display = "block";
  formularioLogin.style.display = "none";
};
const changepanelLogin = () => {
  alert("Su cuenta ha sido Creada");
  formularioResgistro.style.display = "none";
  formularioLogin.style.display = "block";
};