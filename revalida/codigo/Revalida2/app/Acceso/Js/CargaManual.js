/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    /**
     * Carga el formulario de busqueda cuando se presiona el boton "Buscar" que 
     * aparece en la pantalla de creacion. 
     */
    $('#btnVolver').click(function () {
        location.reload();
    });

    $("#btnCargaIndividual").click(function (e) {
        e.preventDefault();
        var nombreAplicacion = $("#idAplicacion").text();
        $("#nombreAplicacion").val(nombreAplicacion);
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCargaManual.php",
            data: $("#formCargaManual").serialize(),
            cache: false,
            success: function (data) {
                $('#resultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCargaManual")[0].reset();
                    $("select#idAplicacion").val('').trigger('change');
                }
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $('#resultado').html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: $("#resultado").offset().top}, '1250');
            }
        });
    });


    /**
     * Envia el formulario para que se procese un archivo del lado del servidor.
     */
    $("#btnCargaArchivo").click(function (e) {
        e.preventDefault();
        var extension = $('#archivo').val().split('.').pop().toLowerCase();
        if (extension === "xls") {
            var nombreAplicacion = $("#idAplicacion").text();
            $("#nombreAplicacion").val(nombreAplicacion);
            var formData = new FormData(document.getElementById("formCargaManual"));
            formData.append("dato", "valor");
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./PCargaArchivo.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#resultado').html(data[0]['resultado']);
                    if (data[0]['exito'] === true) {
                        $("#formCargaManual")[0].reset();
                        $("select#idAplicacion").val('').trigger('change');
                        $('.custom-file-label').html("XLS");
                    }
                },
                error: function (data) {
                    console.log(data);
                    var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                    var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                    $('#resultado').html(div);
                },
                complete: function () {
                    $('html, body').animate({scrollTop: $("#resultado").offset().top}, '1250');
                }
            });
        } else {
            var men = '<b>Seleccione un archivo con extensión XLS</b>';
            var div = '<div class="alert alert-warning text-center" role="alert">' + men + '</div>';
            $('#resultado').html(div);
        }
    });

    $("select#idAplicacion").change(function () {
        var nombreAplicacion = $("#idAplicacion option:selected").text().toUpperCase();
        switch (nombreAplicacion) {
            case 'IDEAR':
                habilitarCarga(false, true);
                break;
            case 'SWIFT':
                habilitarCarga(true, false);
                break;
            default:
                habilitarCarga(true, true);
                break;
        }
    });


    $("input[type='file']").change(function (e) {
        var nombreArchivo = e.target.files[0].name;
        $('.custom-file-label').html(nombreArchivo);
    });

    /* Carga las aplicaciones en el seleccionador. */

    $('select#idAplicacion').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../Aplicacion/Vista/PSeleccionar.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, base: 'ARCHIVO'};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });


    /**
     * Se encarga de habilitar o deshabilitar los campos que corresponden a la
     * carga individual de accesos o a la carga mediante archivo.
     * @param {boolean} individual 
     * @param {boolean} archivo 
     */
    function habilitarCarga(individual, archivo) {
        $("#legajo").prop("disabled", individual);
        $("#nombre").prop("disabled", individual);
        $("#perfil").prop("disabled", individual);
        $("#estado").prop("disabled", individual);
        $("#estado").prop("disabled", individual);
        $("#btnCargaIndividual").prop("disabled", individual);
        $("#archivo").prop("disabled", archivo);
        $("#btnCargaArchivo").prop("disabled", archivo);
    }

});

