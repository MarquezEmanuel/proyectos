/* 
 * Crear aplicacion.
 */
$(document).ready(function () {

    /**
     * Carga el formulario de busqueda cuando se presiona el boton "Buscar" que 
     * aparece en la pantalla de creacion. 
     */
    $('#btnVolver').click(function () {
        location.reload();
    });

    /*
     * Realiza la creacion del registro. El resultado se carga en el div resultado.
     */
    $('#formCrearAplicacion').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PCrear.php",
            data: $("#formCrearAplicacion").serialize(),
            success: function (data) {
                $('#resultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearAplicacion")[0].reset();
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

    /* Carga las gernecias en el seleccionador. */

    $('select#gerencia').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../Gerencia/Vista/PSeleccionar.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

});