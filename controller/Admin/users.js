const myModal = document.getElementById('myModal')
const myInput = document.getElementById('myInput')
let guapo='Que pex'

myModal.addEventListener('shown.bs.modal', () => {
  myInput.focus()
})
async function filltable(form=null){
  (form) ? action = 'search' : action = 'readAll';
}
const openCreate=()=>{
  filltable(guapo,'readAll','Status')
}