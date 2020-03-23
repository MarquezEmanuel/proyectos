/* 
 * Modificar usuario.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarUsuario").serialize();

    /*
     * Habilita el boton de modificacion cuando se detenctan cambios en el
     * formulario original.
     */
    $("#formModificarUsuario").change(function () {
        var formModificado = $("#formModificarUsuario").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificar").prop("disabled", habilitar);
    });

    /**
     * Carga el formulario de busqueda cuando se presiona el boton "Buscar" que 
     * aparece en la pantalla de creacion. 
     */
    $('#btnVolver').click(function () {
        location.reload();
    });

    $('#formModificarUsuario').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificar.php",
            data: $("#formModificarUsuario").serialize(),
            success: function (data) {
                $('#resultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarUsuario').find('input, textarea, select').prop('disabled', true);
                }
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#resultado").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#resultado").offset().top}, '1250');
            }
        });
    });

    /* Carga las gernecias en el seleccionador. */

    $('select#gerencia').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../Gerencia/Vista/PSeleccionar.php",
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

    /* Carga los roles en el seleccionador. */

    $('select#rol').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../Rol/Vista/PSeleccionar.php",
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
