
/* 
 * Modificar gerencia.
 */
$(document).ready(function () {

    var formOriginal = $("#formModificarGerencia").serialize();

    /*
     * Habilita el boton de modificacion cuando se detenctan cambios en el
     * formulario original.
     */
    $("#formModificarGerencia").change(function () {
        var formModificado = $("#formModificarGerencia").serialize();
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

    $('#formModificarGerencia').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificar.php",
            data: $("#formModificarGerencia").serialize(),
            success: function (data) {
                $('#resultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarGerencia').find('input, textarea, select').prop('disabled', true);
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

    $('select#delegado').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../Usuario/Vista/PSeleccionarDelegadoGerencia.php",
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

    /* Carga las gernecias en el seleccionador. */

    $('select#subdelegado').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../Usuario/Vista/PSeleccionarSubdelegadoGerencia.php",
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