

$(document).ready(function () {
    
    $("#contenido").on("click", "button.detallesSolicitudWF", function () {
        var id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesPlazoVencido80.php",
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

