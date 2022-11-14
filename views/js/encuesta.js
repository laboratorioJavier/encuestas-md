const host = "../controllers/encuesta.php";
var pilares = {};
let opciones = [];
let nombre_representante = "";


function toggleIcon(e) {
  $(e.target)
    .prev('.panel-heading')
    .find(".more-less")
    .toggleClass('glyphicon-plus glyphicon-minus');
  // console.log(e);
}

// Retorna una copia de un objeto, para asignarla a otro objeto y manipularlo, sin alterar el original:
function copyObjectValuesToAnotherObject(object = {}) {
  var newObject = {};
  for (var key in object) {
    newObject[key] = object[key];
  }
  return newObject;
}


function inicializarPilares(pilaresArray) {
  for (var pilar of pilaresArray) {
    pilares[pilar.id] = copyObjectValuesToAnotherObject(pilar);
    pilares[pilar.id].niveles = {};
    for (var nivel of pilar.niveles) {
      pilares[pilar.id].niveles[nivel.id] = copyObjectValuesToAnotherObject(nivel);
    }
  }
}


function guardarDatosEmpresa(nombreRep) {
  nombre_representante = nombreRep;

  
}
$(document).ready(function () {

  

  swal("Bienvenido a Red PbM, un placer saludarte, " + nombre_representante);
 
  var form = $(".signup-form:not([data-id='5'])");
  form.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    labels: {
      previous: 'Anterior',
      next: 'Siguiente',
      finish: 'Ir a próximo pilar',
      current: ''
    },
    titleTemplate: '<h3 class="title">#title#</h3>',
    onFinished: function (event, currentIndex) {
      validarPilar(event);
    }
  });

  

  var form5 = $(".signup-form[data-id='5']");
  form5.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    labels: {
      previous: 'Anterior',
      next: 'Siguiente',
      finish: 'Finalizar encuesta',
      current: ''
    },
    titleTemplate: '<h3 class="title">#title#</h3>',
    onFinished: function (event, currentIndex) {
      validarPilar(event);
    }
  });

  $(".toggle-password").on('click', function () {

    $(this).toggleClass("zmdi-eye zmdi-eye-off");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  $('.panel-group').on('hidden.bs.collapse', function (e) {
    toggleIcon(e);
  });
  $('.panel-group').on('shown.bs.collapse', function (e) {
    toggleIcon(e);
    //$(this).children('.collapse:not()')
  });

  $('.panel-group').on('click', function (e) {
    e.stopPropagation(); // Para impedir que el usuario despliegue o repliegue el acordeón con un clic
  });

});


function validarPilar(event) {
  var idPilar = event.currentTarget.dataset.id;
  var checkboxes = $(`#collapse${idPilar} input[type="checkbox"]:checked`);
  if (checkboxes.length == 0) {
    alert(`Debe seleccionar al menos una opción de cualquiera de los niveles del pilar '${pilares[idPilar].titulo}'`);
    return;
  }
  $.each(checkboxes, function (index, check) {
    opciones.push(parseInt(check.value));
  });
  $(`#collapse${idPilar}`).collapse("toggle");
  if (idPilar < 5) {
    $(`#collapse${parseInt(idPilar) + 1}`).collapse("show");
    $('#tituloPilar').text(pilares[parseInt(idPilar) + 1].titulo);
    $('#descripcionPilar').text(pilares[parseInt(idPilar) + 1].descripcion);
  } else {
    $("#informacionContacto").removeClass("display-none");
  }
}

function enviarDatos() {
  $('<input />').attr('type', 'hidden')
    .attr('name', 'opciones')
    .attr('value', JSON.stringify(opciones))
    .appendTo('#formEncuesta');
  $('<input />').attr('type', 'hidden')
    .attr('name', 'mode')
    .attr('value', 'guardarRespuestas')
    .appendTo('#formEncuesta');
  $("#formEncuesta").submit();
}