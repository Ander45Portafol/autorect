const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
const SERVER_URL = "http://localhost/autorect/api/";

async function dataFetch(filename, action, form = null) {
  const OPTIONS = new Object();
  if (form) {
    OPTIONS.method = "post";
    OPTIONS.body = form;
  } else {
    OPTIONS.method = "get";
  }
  try {
    const PATH = new URL(SERVER_URL + filename);
    PATH.searchParams.append("action", action);
    const RESPONSE = await fetch(PATH.href, OPTIONS);
    return RESPONSE.json();
  } catch (error) {
    console.log(error);
  }
}

function confirmAction(message) {
  return swal({
    title: 'Warning',
    text: message,
    icon: 'warning',
    closeOnCLickOutSide: false,
    CloseOnEsc: false,
    buttons: {
      cancel: {
        text: 'No',
        value: false,
        visible: true,
        className: 'red accent-1'
      },
      confirm: {
        text: 'Sí',
        value: true,
        visible: true,
        className: 'grey darken-1'
      }
    }
  })
}

async function logOut() {
  // Se muestra un mensaje de confirmacion y se captura la respuesta en una constante
  const RESPONSE = await confirmAction('Are you sure you want log out?')
  // Se verifica la respuesta del mensaje
  if (RESPONSE) {
    // Peticion para eliminar la sesion.
    const JSON = await dataFetch(USER_API, 'logOut')
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepcion.
    if (JSON.status) {
      sweetAlert(1, JSON.message, true, 'index.html')
    } else {
      sweetAlert(2, JSON.exception, false)
    }
  }
}

function sweetAlert(type, text, timer, url = null) {
  // Se compara el tipo de mensaje a mostrar
  switch (type) {
    case 1:
      title = "Success";
      icon = "success";
      break;
    case 2:
      title = "Error";
      icon = "error";
      break;
    case 3:
      title = "Warning";
      icon = "warning";
      break;
    case 4:
      title = "Info";
      icon = "info";
      break;
    default:
      break;
  }
  // Se define un objeto con las opciones principales para el mensaje.
  let options = {
    title: title,
    text: text,
    icon: icon,
    closeOnClickOutside: false,
    closeOnEsc: false,
    button: {
      text: "Ok",
      className: "cyan",
    },
  };
  // Se verifica el uso de temporizador.
  timer ? (options.timer = 3000) : (options.timer = null);
  // Se muestra el mensaje. Requiere la librería sweetalert para funcionar.
  swal(options).then(() => {
    if (url) {
      // Se direcciona a la página web indicada.
      location.href = url;
    }
  });
}

async function fillSelect(filename, action, select, selected = null) {
  const JSON = await dataFetch(filename, action)
  let content = '';
  if (JSON.status) {
    content += '<option disable selected>Select something</option>'
    JSON.dataset.forEach(row => {
      value = Object.values(row)[0]
      text = Object.values(row)[1]
      if (value != selected) {
        content += `<option value="${value}">${text}</option>`
      } else {
        content += `<option value="${value}" selected>${text}</option>`
      }
    })
  } else {
    content += '<option>No data to show</option>'
  }
  document.getElementById(select).innerHTML = content
}