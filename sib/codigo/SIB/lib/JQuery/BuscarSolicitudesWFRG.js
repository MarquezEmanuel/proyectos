

$(document).ready(function () {

    $("#contenido").on("click", "#btnBuscarSolicitudes", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarSolicitudesWFRG.php",
            data: $("#formBuscarSolicitudesWF").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_solicitudes').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 20,
                    buttons: [
                        {extend: 'excelHtml5',
                            title: 'Solicitudes de workflow'
                        },
                        {extend: 'pdfHtml5',
                            title: 'Solicitudes de workflow',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5]}

                        },
                        {extend: 'print',
                            title: 'Solicitudes de workflow'
                        }
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


    $("#contenido2").on("click", "button.detallesSolicitudWF", function () {
        var id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesSolicitudesWFRG.php",
            data: "seleccionado=" + id,
            success: function (data) {
                $("#contenido").html(data);
                $("#contenido2").empty();
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
    
    $("#contenido").on("click", "button.detallesSolicitudWF", function () {
        var id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesSolicitudesWFRG.php",
            data: "seleccionado=" + id,
            success: function (data) {
                $("#contenido").html(data);
                $("#contenido2").empty();
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

});

