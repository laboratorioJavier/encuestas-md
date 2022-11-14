'use strict'
//sessionStorage.host = "sales-by-clients-controller";
//const HOST = sessionStorage.host;

$(document).ready(function () {
/*
    // AVISO DE INICIO DE SESIÓN

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: 'success',
        title: 'Se ha iniciado la sesión con éxito'
      })
*/
    $('#tabla_encuestas').append(
        `<tfoot>
        <tr>
            <td></td> 
            <td></td> 
            <td></td>
            <td></td> 
            <td></td> 
            <td></td> 
            <td></td> 
            <td></td> 
            <td></td>   
            
        </tr>
            </tfoot>   

        `);
    if ($.fn.DataTable.isDataTable("#tabla_encuestas")) {
        $('#tabla_encuestas').DataTable().clear().destroy();
    }
    


    $("#tabla_encuestas").DataTable({
        language: {
            "decimal": "",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "infoFiltered": "(filtrado de _MAX_ entradas totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se han encontrado registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        responsive: true,
        dom: 'Bfrtip',
                buttons: [
            {
                extend: 'excelHtml5',
                title: 'Reporte de Encuestas',
                message: ' Información detallada  sobre las encuestas realizadas al ' + new Date().toISOString().split("T")[0],  
               
            },
            {
                extend: 'pdfHtml5',
                title: 'Reporte de Encuestas',
                orientation: 'landscape',
                message: ' Información  detallada  sobre las encuestas realizadas  al ' + new Date().toISOString().split("T")[0],  
                footer:true
               
            },
            {
                extend: 'csvHtml5',
                title: 'Reporte de Encuestas',
                
               
            }
        ]
    }).columns('.fecha').order('desc').draw();
   
 
});