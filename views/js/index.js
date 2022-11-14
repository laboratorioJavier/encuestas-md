const HOST = "../controllers/empresa.php";


function buscarRif() {
  var rif = $("#rif_empresa").val();
  if (rif.trim() == "") {
    
    alert('Debe ingresar un valor válido para el RIF de la Empresa');
  
    $("#rif_empresa").focus();
    return;
  }
  $.get({
    url: HOST,
    dataType: 'json',
    data: { mode: 'buscarEmpresa', rif: rif.trim() },
    success: function (resp) {

      if (resp.encontro) {
        var empresa = resp.data;
        $("#nombre_empresa").val(empresa.nombre);
        $("#nombre_empresa").prop('disabled', true);
        $(`#rubro option[value="${empresa.id_rubro}"]`).prop('selected', true);
        $(`#rubro`).prop('disabled', true);
      } else {
        alert(`El RIF '${rif}' no se encuentra como una empresa registrada en nuestra base de datos. Puede proceder a registrarlo`);
        $("#nombre_empresa").val("");
        $("#nombre_empresa").prop('disabled', false);
        $(`#rubro option[value=""]`).prop('selected', true);
        $(`#rubro`).prop('disabled', false);
      }
    }
  });
}

function reiniciarEmpresa() {
  $("#nombre_empresa").prop('disabled', true);
  $("#nombre_empresa").val("");
  $(`#rubro`).prop('disabled', true);
  $(`#rubro option[value=""]`).prop('selected', true);
  $("#buscarRIF").toggleClass('btn-primary btn-danger');
  $("#buscarRIF").attr('onclick', 'buscarRif()');
  $("#buscarRIF").text('Buscar');
  $("#rif_empresa").prop('disabled', false);
}

// VALIDANDO FORMULARIO DE REGISTRO

var form = document.getElementById('formContacto');
var nombre = document.getElementById('nombre_representante');
var correo = document.getElementById('email');
var telefono_ = document.getElementById('telefono');
var cargo_ = document.getElementById('cargo');
var rif_empresa_ = document.getElementById('rif_empresa');
var empresa_ = document.getElementById('nombre_empresa');
var rubro_empresa = document.getElementById('rubro');

form.addEventListener('submit', e => {
  e.preventDefault();

  enviarDatos();
});

function enviarDatos() {

  var form = $("#formContacto").serializeArray();
  var expRegLetras=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
  var expRegCorreo=/^([A-Za-z0-9_.-]+)@([da-z.-]+).([a-z.]{2,7})$/;  
  var expRegNumeros=/^\d{11}$/;

  for (var input of form) {

    // VALIDANDO NOMBRE

    if (nombre.value.trim() == "") {
      setErrorFor(nombre, 'No puede dejar el nombre en blanco.');
      nombre.focus();
      return false;
    } /*else */
    if (!expRegLetras.exec(nombre.value.trim())){
      setErrorFor(nombre, 'El campo nombre solo admite letras y espacios *');
      return false;
    } /*else {
      setSuccessFor(nombre);
    }*/
    if(!nombre.value.trim() == ""){
      setSuccessFor(nombre);
    }
    
    // VALIDANDO EMAIL
    
    if (correo.value.trim() == "") {
      setErrorFor(correo, 'No puede dejar el email en blanco.');
      return false;

    } /*else */
    if(!expRegCorreo.exec(correo.value.trim())){
      setErrorFor(correo, 'El campo correo no tiene el formato correcto *');
      return false;
    } /*else {
      setSuccessFor(email);
    }*/
    if(!correo.value.trim() == ""){
      setSuccessFor(email);
    }

    // VALIDANDO TELÉFONO 

    if (telefono_.value.trim() == "") {
      setErrorFor(telefono_, 'No puede dejar el teléfono en blanco.');
      return false;
    } /*else*/
    if(!expRegNumeros.exec(telefono_.value.trim())){
      setErrorFor(telefono_, 'El campo teléfono no tiene el formato correcto *');
      return false;
    } /*else {
      setSuccessFor(telefono);
    }*/
    if (!telefono_.value.trim() == "") {
      setSuccessFor(telefono);
    }

    // VALIDANDO CARGO
      
    if(cargo_.value.trim() == "") {
      setErrorFor(cargo_, 'No puede dejar el cargo en blanco.');
      return false;
    
    } /*else*/ 
    if(!expRegLetras.exec(cargo_.value.trim())){
      setErrorFor(cargo_, 'El campo cargo admite letras y espacios *');
      return false;
    } /*else {
      setSuccessFor(cargo);
    }*/
    if(!cargo_.value.trim() == "") {
      setSuccessFor(cargo);
    }

    // VALIDANDO RIF DE LA EMPRESA
    if(rif_empresa_.value.trim() == ""){
      setErrorFor(rif_empresa_, 'No puede dejar el rif en blanco.');
      return false;
    } /*else {
      setSuccessFor(rif_empresa_);
    }*/
    if(!rif_empresa_.value.trim() == ""){
      setSuccessFor(rif_empresa_);
    }

    if(empresa_.value.trim()==""){
      setErrorFor(empresa_, 'No puede dejar el nombre en blanco.');
      return false;
    } /*else {
      setSuccessFor(empresa_);
    }*/
    if(!empresa_.value.trim()==""){
      setSuccessFor(empresa_);
    }

    if(rubro_empresa.value.trim()==""){
      setErrorFor(rubro_empresa, 'No puede dejar el rubro en blanco.');
      return false;
    } /*else {
      setSuccessFor(rubro_empresa);
    }*/
    if(!rubro_empresa.value.trim()==""){
      setSuccessFor(rubro_empresa);
    }
    
   
      $('<input />').attr('type', 'hidden')
      .attr('name', input.name)
      .attr('value', input.value)
      .appendTo('#formContacto'); 
 
  }
  $('<input />').attr('type', 'hidden')
  .attr('name', 'mode')
  .attr('value', 'registrarRepresentante')
  .appendTo('#formContacto');
  $("#formContacto").submit();
}

/*

var form = $("#formContacto").serializeArray();
  $('#formContacto :disabled[name]').each(function () { 
    form.push({ name: this.name, value: $(this).val() });
  });
  for (var input of form) {
    if (input.value.trim() == "") {
      alert("Debe completar el siguiente campo: " + $(`label[for='${input.name}']`).text());
      $(`input[name='${input.name}']`).focus();
      $("#formContacto input[type='hidden']").remove();
      return;
    }
    $('<input />').attr('type', 'hidden')
      .attr('name', input.name)
      .attr('value', input.value.trim())
      .appendTo('#formContacto');
  }
  $('<input />').attr('type', 'hidden')
    .attr('name', 'mode')
    .attr('value', 'registrarRepresentante')
    .appendTo('#formContacto');
  $("#formContacto").submit();
*/

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