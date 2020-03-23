/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */

$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */

    $("#contenido").on("click", "#btnBuscarExtracciones", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarExtracciones55.php",
            data: $("#formBuscarExtracciones").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_extracciones').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 20,
                    buttons: [
                        {extend: 'excelHtml5',
                            title: 'Extracciones por caja'
                        },
                        {extend: 'pdfHtml5',
                            title: 'Extracciones por caja',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]}

                        },
                        {extend: 'print',
                            title: 'Extracciones por caja'
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

    $("#contenido2").on("click", "img.detallesExtracciones", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesExtracciones55.php",
            data: "seleccionado=" + idcuenta,
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

    $("#contenido").on("click", "img.detallesExtracciones2", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesExtracciones55.php",
            data: "seleccionado=" + idcuenta,
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



