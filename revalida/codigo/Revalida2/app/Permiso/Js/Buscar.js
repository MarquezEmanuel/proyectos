/* 
 * Buscar permiso.
 */
$(document).ready(function () {

    realizarBusqueda();

    /**
     * Realiza la busqueda de los permisos cuando se envia el formulario de busqueda.
     * El resultado se carga en la seccion inferior.
     */
    $('#formBuscarPermiso').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    /**
     * Carga el formulario de modificacion cuando se hace click sobre el boton en
     * la tabla. El formulario se carga en el div superior o se muestra el error 
     * en el div inferior.
     */
    $('#inferior').on('click', '.editar', function () {
        var id = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./Modificar.php",
            data: "id=" + id,
            success: function (data) {
                $("#inferior").empty();
                $('#superior').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#inferior").html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: $("#superior").offset().top}, '1250');
            }
        });
    });

});

function realizarBusqueda() {
    $.ajax({
        type: "POST",
        url: "./PBuscar.php",
        data: $("#formBuscarPermiso").serialize(),
        beforeSend: function () {
            $('#ModalCargando').modal({show: true, backdrop: 'static'});
        },
        success: function (data) {
            $('#inferior').html(data);
            $('#tbPermisos').dataTable({
                lengthChange: false,
                language: {url: "../../../lib/JQuery/Spanish.json"}
            });
        },
        error: function (data) {
            console.log(data);
            var men = '<b>No se procesó la petición (Informe al administrador)</b>';
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $("#inferior").html(div);
        },
        complete: function () {
            setTimeout(function () {
                $('#ModalCargando').modal('hide');
            }, 1000);
            $('html,body').animate({scrollTop: $("#inferior").offset().top}, '1250');
        }
    });
}
