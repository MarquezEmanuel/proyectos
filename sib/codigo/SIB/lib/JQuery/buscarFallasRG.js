/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {
    
    $("#tableFallasRG").tablesorter();

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarFallas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarFallasRG.php",
            data: $("#formBuscarFallas").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_fallas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Fallas de caja - Sucursal Rio Gallegos'
                        },
                        {   extend: 'pdfHtml5',
                            title: 'Fallas de caja - Sucursal Rio Gallegos',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]}               
                        },
                        {   extend: 'print',
                            title: 'Fallas de caja - Sucursal Rio Gallegos'
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
    
    $("#contenido2").on("click", "img.detallesFallas", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesFallas.php",
            data: "seleccionado="+idcuenta,
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
    
    $("#contenido").on("click", "img.detallesFallas2", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesFallas.php",
            data: "seleccionado="+idcuenta,
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