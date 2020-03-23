/* 
 * Modificar servicio.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarServicio").serialize();

    /*
     * Habilita el boton de modificacion cuando se detenctan cambios en el
     * formulario original.
     */
    $("#formModificarServicio").change(function () {
        var formModificado = $("#formModificarServicio").serialize();
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

    $('#formModificarServicio').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificar.php",
            data: $("#formModificarServicio").serialize(),
            success: function (data) {
                $('#resultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarServicio').find('input, textarea, select').prop('disabled', true);
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

});
