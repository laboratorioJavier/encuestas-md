'use strict'
//sessionStorage.host = "sales-by-clients-controller";
//const HOST = sessionStorage.host;


$(document).ready(function () {



      
    $('#tabla_empresas').append(
        `<tfoot>
        <tr>
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
    if ($.fn.DataTable.isDataTable("#tabla_empresas")) {
        $('#tabla_empresas').DataTable().clear().destroy();
    }
    


    $("#tabla_empresas").DataTable({
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
                title: 'Reporte de Contactos',
                message: ' Listado con  información de representantes de empresas registrados  al ' + new Date().toISOString().split("T")[0],  
               
            },
            {
                extend: 'pdfHtml5',
                title: 'Reporte de Contactos',
                message: ' Listado con  información de representantes de empresas registrados  al ' + new Date().toISOString().split("T")[0],  
                footer:true
               
            },
            {
                extend: 'csvHtml5',
                title: 'Reporte de Contactos',
                
               
            }
        ]
    })
   
 
});