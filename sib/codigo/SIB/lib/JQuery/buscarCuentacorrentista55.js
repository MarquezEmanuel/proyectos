/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCuenta", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuenta55.php",
            data: $("#formBuscarCuenta").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cuenta').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentacorrentistas inhabilitados'
                        },
                        {   extend: 'pdfHtml5',
                            title: 'Cuentacorrentistas inhabilitados',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10]}
                
                        },
                        {   extend: 'print',
                            title: 'Cuentacorrentistas inhabilitados'
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
    
    $("#contenido2").on("click", "img.detallesCuenta", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuenta55.php",
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
    
    $("#contenido").on("click", "img.detallesCuenta2", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuenta55.php",
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

