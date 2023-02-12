const divnavbar=document.querySelector(".navbar")
const btnabrir=document.querySelector(".btn")
const btnback=document.querySelector(".btnback")

const compactnav=()=>{
  divnavbar.style.width= " 15%";
 btnabrir.style.display="none"
 btnback.style.display="block"
}
const backnav=()=>{
    divnavbar.style.width="6%"
    btnback.style.display="none"
    btnabrir.style.display="block"
}
const btnedit=()=>{
  prompt("Hola mundo")
}
const btndelete=()=>{
  prompt("eliminando")
}