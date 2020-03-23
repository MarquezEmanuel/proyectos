/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCuota", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuotas20.php",
            data: $("#formBuscarCuotas").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cuotas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Prestamos con cuenta asociada'
                        },
                        {   extend: 'pdfHtml5',
                            title: 'Prestamos con cuenta asociada',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 6, 8, 11, 12, 13, 14, 15, 16, 17, 18, 19]}
                
                        },
                        {   extend: 'print',
                            title: 'Prestamos con cuenta asociada'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido2").on("click", "img.detallesCuotas", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuotas20.php",
            data: "seleccionado="+idcuotas,
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
    
    $("#contenido").on("click", "img.detallesCuotas2", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuotas20.php",
            data: "seleccionado="+idcuotas,
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




