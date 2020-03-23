
/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarGtia", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarGarantia.php",
            data: $("#formBuscarGtia").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_gtia').DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    scrollX: true,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Garantias'
                        },
                        {   extend: 'pdfHtml5',
                            title: 'Garantias',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 15]}
                
                        }
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
   
    /* CARGA EL FORMULARIO DE MODIFICACION DE GARANTIA EN EL DIV CONTENIDO */

    $("#contenido2").on("click", "img.modificarGtia", function () {
         var idgtia = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formModificarGarantia.php",
            data: "seleccionado="+idgtia,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
    
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido2").on("click", "img.detallesGtia", function () {
         var idgtia = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesGarantia.php",
            data: "seleccionado="+idgtia,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
    
    

});

