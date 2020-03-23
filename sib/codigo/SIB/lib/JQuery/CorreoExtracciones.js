
$(document).ready(function () {

    $('#btnCrearMsjExtracciones').click(function () {
        $("#metodo").val("crear");
        $('#mdCorreoExtracciones').modal({});
        return false;
    });

    $('#btnEditarMsjExtracciones').click(function () {
        $("#metodo").val("modificar");
        $('#mdCorreoExtracciones').modal({});
        return false;
    });

    $('#btnFormCorreoExtracciones').click(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarCorreoPredeterminado.php",
            data: $("#formCorreoExtracciones").serialize(),
            success: function (data) {
                $('#btnFormCorreoExtracciones').css('display', 'none');
                $('#btnCancelar').css('display', 'none');
                $('#btnAceptar').css('display', '');
                $("#contenidoMdCorreoExtracciones").html(data);
            },
            error: function (msg) {
                console.log(msg);
                $('#btnFormCorreoExtracciones').css('display', 'none');
                $('#btnCancelar').css('display', 'none');
                $('#btnAceptar').css('display', '');
                $("#contenidoMdCorreoExtracciones").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

    /* CUANDOS SE MUESTRA EL RESULTADO SE CIERRA EL MODAL Y ACTUALIZA LA PAGINA */

    $('#btnAceptar').click(function () {
        $('#mdCorreoExtracciones').modal('toggle');
        location.reload();
    });


    $("#seleccionarTodos").change(function () {
        if ($(this).is(':checked')) {
            $("input[name='cbCorreos[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='cbCorreos[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });


    $("#nombre").change(function () {
        var nombre = $(this).val();
        if (nombre.length > 9) {
            $("#nombre").css("border", "");
        } else {
            $("#nombre").css("border", "1px solid red");
        }
    });

    $("#asunto").change(function () {
        var asunto = $(this).val();
        if (asunto.length > 9) {
            $("#asunto").css("border", "");
        } else {
            $("#asunto").css("border", "1px solid red");
        }
    });

    $("#mensaje").change(function () {
        var mensaje = $(this).val();
        if (mensaje.length > 29) {
            $("#mensaje").css("border", "");
        } else {
            $("#mensaje").css("border", "1px solid red");
        }
    });

});

