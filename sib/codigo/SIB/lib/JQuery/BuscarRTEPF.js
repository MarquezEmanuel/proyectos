$(document).ready(function () {

    $('#tablaRTE').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            {   extend: 'excelHtml5',
                title: 'Reporte de Transacciones en Efectivo',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]}
            },
            {   extend: 'pdfHtml5',
                pageSize: 'LEGAL',
                title: 'Reportes de Transacciones en Efectivo',
                text: 'PDF',
                exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]}
            }
        ],
        language: {url: "/lib/js/Spanish.json"
        }
    });

    $('img.modificarRTE').click(function () {
        var idOperacion = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formModificarRTEPF.php",
            data: "idOperacion=" + idOperacion,
            success: function (data) {
                $("#FormBuscarRTE").empty();
                $("#FormBuscarRTE").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

    $('img.borrarRTE').click(function () {
        var idOperacion = $(this).attr("name");
        $("#seleccionado").val(idOperacion);
        $('#mdBorrar').modal({});
    });

    $('#btnConfirmarEliminacion').click(function () {
        var idOperacion = $("#seleccionado").val();
        $.ajax({
            type: "POST",
            url: "procesarBorrarRTEPF.php",
            data: "idOperacion=" + idOperacion,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        $('#mdBorrar').modal('toggle');
        return false;
    });

});