/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */

    $("#contenido").on("click", "#btnBuscarPagare", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarPagare25.php",
            data: $("#formBuscarPagare").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_pagare').DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {extend: 'excelHtml5',
                            title: 'Pagare no cargados en SAV'
                        },
                        {extend: 'pdfHtml5',
                            title: 'Pagare no cargados en SAV',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}

                        },
                        {extend: 'print',
                            title: 'Pagare no cargados en SAV'
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

    $("#contenido2").on("click", "img.detallesPagare", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesPagare25.php",
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

    $("#contenido").on("click", "img.detallesPagare2", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesPagare25.php",
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

