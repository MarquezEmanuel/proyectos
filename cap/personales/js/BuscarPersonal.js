/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    realizarBusqueda();

    $('#formBuscarPersonal').submit(function (event) {
        event.preventDefault();
        $("#peticion").val("true");
        realizarBusqueda();
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idPersonal = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./FModificarPersonal.php",
            data: "idPersonal=" + idPersonal,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#seccionInferior').on('click', '.baja', function () {
        $("#mcefTitulo").html("<i class='fas fa-trash'></i> CONFIRME LA BAJA DEL PERSONAL");
        $("#mcefAccion").val("BAJA");
        $("#mcefIdPersonal").val($(this).attr("name"));
        $("#mcefNombre").text($(this).parents("tr").find("td").eq(0).html() + ": ");
        $("#ModalCambioEstadoPersonal").modal({backdrop: 'static', keyboard: false});
    });

    /* ABRE EL MODAL PARA CONFIRMAR EL ALTA */

    $('#seccionInferior').on('click', '.alta', function () {
        $("#mcefTitulo").html("<i class='fas fa-plus-circle'></i> CONFIRME EL ALTA DEL PERSONAL");
        $("#mcefAccion").val("ALTA");
        $("#mcefIdPersonal").val($(this).attr("name"));
        $("#mcefNombre").val($(this).parents("tr").find("td").eq(0).html());
        $("#ModalCambioEstadoPersonal").modal({backdrop: 'static', keyboard: false});
    });

    /* ENVIA LA OPERACION Y MUESTRA EL RESULTADO EN EL MODAL */

    $('#btnCambiarEstadoPersonal').click(function () {
        $.ajax({
            type: "POST",
            url: "./PCambiarEstadoPersonal.php",
            data: $("#formCambiarEstadoPersonal").serialize(),
            success: function (data) {
                $('#mcefCuerpo').html(data);
                $('#btnCambiarEstadoPersonal').hide();
                $('#btnCancelarCambiarEstado').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#mcefCuerpo").html(div);
            }
        });
    });

    /* ACTUALIZA LA PANTALLA LUEGO DE HACER EL ALTA O BAJA */

    $('#btnRefrescarPantalla').click(function () {
        location.reload();
    });

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscarPersonal.php",
            data: $("#formBuscarPersonal").serialize(),
            success: function (data) {
                $('#seccionInferior').html(data);
                $('#tbPersonales').dataTable({
                    lengthChange: false
                });
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
    }

});

