/* 
 * Modificar rol.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarRol").serialize();

    /*
     * Habilita el boton de modificacion cuando se detenctan cambios en el
     * formulario original.
     */
    $("#formModificarRol").change(function () {
        var formModificado = $("#formModificarRol").serialize();
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

    /** Selecciona todos los permisos que se encuentran listados en la tabla. */

    $('#cbTodosPermisos').change(function () {
        var habilitar = ($(this).is(':checked')) ? true : false;
        $("input[name='permisos[]']").each(function () {
            $(this).prop('checked', habilitar);
        });
    });

    $('#formModificarRol').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./PModificar.php",
            data: $("#formModificarRol").serialize(),
            success: function (data) {
                $('#resultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarRol').find('input, textarea, select').prop('disabled', true);
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
