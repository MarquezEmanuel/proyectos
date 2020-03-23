/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    var tipoTransaccion = $('#tipot').val();
    var provincia = $("#provincia").val();
    var localidad = $("#localidad").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();


    $('#formModificarRTE').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarModificarRTEPF.php",
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

    if (tipoTransaccion === "Extracción") {
        $("#provincia").prop("readonly", "true");
        $("#localidad").prop("readonly", "true");
        $("#calle").prop("readonly", "true");
        $("#numero").prop("readonly", "true");

    }

    $('#tipot').change(function () {
        var tipot = $(this).val();
        if (tipot === "Extracción") {
            $("#provincia").prop("readonly", "true");
            $("#localidad").prop("readonly", "true");
            $("#calle").prop("readonly", "true");
            $("#numero").prop("readonly", "true");
            $("#provincia").val("");
            $("#localidad").val("");
            $("#calle").val("");
            $("#numero").val("");
        } else {
            $("#provincia").prop("readonly", "");
            $("#localidad").prop("readonly", "");
            $("#calle").prop("readonly", "");
            $("#numero").prop("readonly", "");
            $("#provincia").val(provincia);
            $("#localidad").val(localidad);
            $("#calle").val(calle);
            $("#numero").val(numero);
        }
    });
    
    $('#datos').on("change", "select.tipop", function () {
        var numero = $(this).parent().parent().parent().attr("name");
        var tipop = $(this).val();
        if (tipop === "Persona Jurídica") {
            $('.nombres' + numero).prop("disabled", "true");
            $('.tipodoc' + numero).prop("disabled", "true");
            $('.dni' + numero).prop("disabled", "true");
        } else {
            $('.nombres' + numero).prop("readonly", "");
            $('.tipodoc' + numero).prop("disabled", "");
            $('.dni' + numero).prop("readonly", "");
        }

    });



});