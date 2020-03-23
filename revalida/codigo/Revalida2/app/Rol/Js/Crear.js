/* 
 * Crear rol.
 */
$(document).ready(function () {

    /**
     * Carga el formulario de busqueda cuando se presiona el boton "Buscar" que 
     * aparece en la pantalla de creacion. 
     */
    $('#btnVolver').click(function () {
        location.reload();
    });

    $('#formCrearRol').submit(function (evento) {
        evento.preventDefault();
        var cantidad = $('input[name="permisos[]"]:checked').length;
        if (cantidad > 0) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./PCrear.php",
                data: $("#formCrearRol").serialize(),
                success: function (data) {
                    $('#resultado').html(data[0]['resultado']);
                    if (data[0]['exito'] === true) {
                        $("#formCrearRol")[0].reset();
                    }
                },
                error: function (data) {
                    console.log(data);
                    var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                    var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                    $('#resultado').html(div);
                },
                complete: function () {
                    $('html,body').animate({scrollTop: $("#resultado").offset().top}, '1250');
                }
            });
        } else {
            var men = '<b>Seleccione al menos un permiso</b>';
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $('#resultado').html(div);
            $('html,body').animate({scrollTop: $("#resultado").offset().top}, '1250');
        }
    });

    /** Selecciona todos los permisos que se encuentran listados en la tabla. */
    $('#cbTodosPermisos').change(function () {
        var habilitar = ($(this).is(':checked')) ? true : false;
        $("input[name='permisos[]']").each(function () {
            $(this).prop('checked', habilitar);
        });
    });


});

