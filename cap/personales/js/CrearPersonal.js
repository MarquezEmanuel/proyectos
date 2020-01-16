/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    $('#formCrearPersonal').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCrearPersonal.php",
            data: $("#formCrearPersonal").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearPersonal")[0].reset();
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
