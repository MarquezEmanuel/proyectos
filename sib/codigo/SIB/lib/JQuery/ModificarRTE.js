/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#formModificarRTE').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarModificarRTE.php",
            data: $("#formModificarRTE").serialize(),
            success: function (data) {
                $("#contenido").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

    $('#datos').on("change", "select.tipop", function () {
        var numero = $(this).parent().parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Persona Jurídica") {
            $('.nombres' + numero).prop("disabled", "true");
            $('.tipodoc' + numero).prop("disabled", "true");
            $('.dni' + numero).prop("disabled", "true");
        } else {
            $('.nombres' + numero).prop("disabled", "");
            $('.tipodoc' + numero).prop("disabled", "");
            $('.dni' + numero).prop("disabled", "");
        }
    });

    $("#contenido").on("click", ".removerSujeto", function (e) {
        e.preventDefault();
        var idSujeto = $(this).attr("name");
        $("#idSujeto").val(idSujeto);
        $("#mdBorrarSujeto").modal({});
    });

    /* SE CONFIRMA LA ELIMINACION DEL SUJETO VINCULADO */

    $("#contenido").on("click", "#btnBorrarSujeto", function (e) {
        e.preventDefault();
        var idSujeto = $("#idSujeto").val();
        $.ajax({
            type: "POST",
            url: "procesarBorrarSujetoRTE.php",
            data: "idSujeto="+idSujeto,
            success: function (data) {
                $('#btnBorrarSujeto').css('display', 'none');
                $('#btnMdCancelar').css('display', 'none');
                $('#btnMdAceptar').css('display', '');
                $("#mensaje").html(data);
            },
            error: function () {
                $('#btnBorrarSujeto').css('display', 'none');
                $('#btnMdCancelar').css('display', 'none');
                $('#btnMdAceptar').css('display', '');
                $("#mensaje").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

    /* CIERRA EL MODAL CON EL RESULTADO DE LA ELIMINACION Y ACTUALIZA */

    $("#contenido").on("click", "#btnMdAceptar", function (e) {
        e.preventDefault();
        $("#mdBorrarSujeto").modal("toggle");
        setTimeout(function () {
            location.reload();
        }, 500);
    });


    /* LLEVA AL TOPE DE LA PANTALLA */

    $("#contenido").on("click", "#btnTopModificarRTE", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 1250);
        return false;
    });

});