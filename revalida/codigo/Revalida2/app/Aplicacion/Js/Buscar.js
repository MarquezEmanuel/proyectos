/* 
 * Buscar aplicacion.
 */

$(document).ready(function () {

    realizarBusqueda();

    /**
     * Carga el formulario de creacion cuando se presiona el boton "Crear" que 
     * aparece en la pantalla de busqueda. El formulario se carga en el div superior
     * o se muestra el error en el div inferior.
     * */
    $('#btnCrear').click(function () {
        $.ajax({
            type: "POST",
            url: "./Crear.php",
            success: function (data) {
                $("#inferior").empty();
                $("#superior").empty();
                $('#superior').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#inferior").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#superior").offset().top}, '1250');
            }
        });
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

    /**
     * Realiza la busqueda de los roles cuando se envia el formulario de busqueda.
     * El resultado se carga en la seccion inferior.
     */
    $('#formBuscarAplicacion').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

});

function realizarBusqueda() {
    $.ajax({
        type: "POST",
        url: "./PBuscar.php",
        data: $("#formBuscarAplicacion").serialize(),
        beforeSend: function () {
            $('#ModalCargando').modal({show: true, backdrop: 'static'});
        },
        success: function (data) {
            $('#inferior').html(data);
            $('#tbAplicaciones').dataTable({
                dom: 'Bfrtip',
                lengthChange: false,
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'REVALIDA_APLICACIONES'
                    }
                ],
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




