/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
            url: "./CargaManual.php",
            success: function (data) {
                $("#inferior").empty();
                $("#contenedor").empty();
                $('#contenedor').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#inferior").html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: $("#contenedor").offset().top}, '1250');
            }
        });
    });

    //ESTE METODO AJAX SE VA A EJECUTAR CUANDO SE APRIETE EL BOTON BUSCAR

    $('#formBuscarAccesoUsuario').submit(function (event) {
        event.preventDefault();
        $("#peticion").val('true');
        realizarBusqueda();
    });


    $('#inferior').on('click', '.editar', function () {
        var id = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./Modificar.php",
            data: "id=" + id,
            success: function (data) {
                $("#inferior").empty();
                $('#contenedor').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#inferior").html(div);
            },
            complete: function () {
                $('html,body').animate({scrollTop: $("#contenedor").offset().top}, '1250');
            }
        });
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('#inferior').on('click', '.borrar', function () {
        $("#idAcceso").val($(this).attr("name"));
        var legajo = $(this).parents("tr").find("td").eq(0).html();
        var nombre = $(this).parents("tr").find("td").eq(1).html();
        $("#datosAcceso").text(legajo + " / " + nombre + ": ");
        $("#datosUsuario").val(legajo + " / " + nombre);
        $("#ModalBorrar").modal({backdrop: 'static', keyboard: false});
    });

    $("#btnBorrar").click(function () {
        var id = $("#idAcceso").val();
        var datos = $("#datosUsuario").val();
        $.ajax({
            type: "POST",
            url: "./PBorrar.php",
            data: "id=" + id + "&datos=" + datos,
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnEliminacion').hide();
                $('#btnBorrar').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#cuerpoModalBorrar").html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: $("#cuerpoModalBorrar").offset().top}, '1250');
            }
        });
    });

    /* ACTUALIZA LA PANTALLA LUEGO DE HACER EL ALTA O BAJA */

    $('#btnRefrescarPantalla').click(function () {
        location.reload();
    });


    //ESTA FUNCION SE VA A EJECUTAR DE MANERA AUTOMATICA CUANDO INGRESES A ACCESOS

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./PBuscar.php",
            data: $("#formBuscarAccesoUsuario").serialize(),
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $('#inferior').html(data);
                $('#tbAccesos').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'REVALIDA_ACCESOS_DE_USUARIO'
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

});
