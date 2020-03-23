
$(document).ready(function () {
    
    $("#formVincularRTE").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarVincularRTE.php",
            data: $("#formVincularRTE").serialize(),
            success: function (data) {
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
    
    $('#tipop').change(function () {
        var tipop = $(this).val();
        if (tipop === "Persona Jurídica") {
            $('#nombres').prop("readonly", "true");
            $('#tipodoc').prop("disabled", "true");
            $('#dni').prop("readonly", "true");
        } else {
            $('#nombres').prop("readonly", "");
            $('#tipodoc').prop("disabled", "");
            $('#dni').prop("readonly", "");
        }
    });
    
});
