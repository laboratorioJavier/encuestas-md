// VALIDANDO FORMULARIO DE LOGIN

const form = document.getElementById('formLogin');
const correo = document.getElementById('email');
const password = document.getElementById('password');

form.addEventListener('submit', e => {
  e.preventDefault();

  enviarDatos();
});

function enviarDatos() {

  var form = $("#formLogin").serializeArray();
 // var expRegLetras=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
 var expRegCorreo=/^([A-Za-z0-9_.-]+)@([da-z.-]+).([a-z.]{2,7})$/;  
 //var expRegNumeros=/^\d{9}$/;
  
  for (var input of form) {

     // VALIDANDO EMAIL

    if(correo.value.trim() == "") {
      setErrorFor(correo, 'No puede dejar el email en blanco.');
      return false;
    } 
    
    if(!expRegCorreo.exec(correo.value.trim())){
      setErrorFor(correo, 'El campo correo no tiene el formato correcto *');
      return false;
    } 
    
    if(!correo.value.trim() == ""){
      setSuccessFor(correo);
    }

    // VALIDANDO PASSWORD

    if (password.value.trim() == "") {
      setErrorFor(password, 'No puede dejar la contraseña en blanco.');
      return false;
    } 
    if(!password.value.trim() == ""){
      setSuccessFor(password);
    }

      $('<input />').attr('type', 'hidden')
      .attr('name', input.name)
      .attr('value', input.value)
      .appendTo('#formLogin');
  }

$('<input />').attr('type', 'hidden')
  .attr('name', 'mode')
  .attr('value', 'iniciarSesion')
  .appendTo('#formLogin');
$("#formLogin").submit();  
}

function setErrorFor(input, message) {
  const formControl = input.parentElement;
  const small = formControl.querySelector('small');
  formControl.className = 'col-xs-8 error';
  small.innerText = message;
}

function setSuccessFor(input) {
  const formControl = input.parentElement;
  formControl.className = 'col-xs-8 success'; 
}

