/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarPersonal").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarPersonal").change(function () {
        var formModificado = $("#formModificarPersonal").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarPersonal").prop("disabled", habilitar);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarPersonal').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificarPersonal.php",
            data: $("#formModificarPersonal").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarPersonal').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarPersonal").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionResultado").html(div);
            }
        });
    });

    $('select#departamento').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "../../gerencias/vistas/PSeleccionarDepartamento.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

});
