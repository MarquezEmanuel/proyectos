/*
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR ESTADOS.
 */
$(document).ready(function () {

    /* INICIALIZA DATATABLES PARA LA TABLA DE ESTADOS */

    $('#tablaEstados').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'excel',
            {extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                text: 'PDF'
            }
        ],
        language: {url: "/lib/js/Spanish.json"
        }
    });

    /* MODAL PARA CARGAR ESTADO */

    $('#btnNuevoEstado').click(function () {
        $('#mdCargarEstado').modal({});
        return false;
    });
    
    /* CONFIRMA LA OPERACION DE ALTA. REALIZA LAS VALIDACIONES Y MUESTRA RESULTADO */

    $('#btnCargarEstado').click(function () {
        var nombre = $("#nombreEstado").val();
        var descripcion = $("#descripcion").val();
        if (nombre.length > 0 && descripcion.length > 0) {
            $.ajax({
                type: "POST",
                url: "procesarCargarEstado.php",
                data: $("#formCargarEstado").serialize(),
                success: function (data) {
                    $("#contenido").empty();
                    $("#contenido2").html(data);
                },
                error: function () {
                    $("#contenido").empty();
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
            $('#mdCargarEstado').modal('toggle');
            return false;

        } else {
            if (!(nombre.length > 0)) {
                $("#nombreEstado").css("border", "1px solid red");
            } else {
                $("#nombreEstado").css("border", "");
            }
            if (!(descripcion.length > 0)) {
                $("#descripcion").css("border", "1px solid red");
            } else {
                $("#descripcion").css("border", "");
            }
        }

    });
    
    /* CANCELA EL ALTA DEL ESTADO. LIMPIA EL FORMULARIO Y OCULTA EL MODAL */

    $('#btnCancelarCarga').click(function () {
        $("#nombreEstado").css("border", "");
        $("#descripcion").css("border", "");
        $('#mdCargarEstado').modal('toggle');
    });

    /* MODAL PARA BORRAR ESTADOS */

    $('form.borrarEstado').submit(function () {
        var idestado = $(this).attr("name");
        $("#seleccionado").val(idestado);
        $('#mdBorrar').modal({});
        return false;
    });

    /* CARGA EL FORMULARIO PARA MODIFICAR ESTADO EN CONTENIDO */

    $('img.modificarEstado').click(function () {
        var idestado = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formModificarEstado.php",
            data: "idestado="+idestado,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
    
    /* CANCELA LA ELIMINACION DEL ESTADO. OCULTA EL MODAL */

    $('#btnCancelarEliminacion').click(function () {
        $('#mdBorrar').modal('toggle');
    });
    
    /* CONFIRMA LA ELIMINACION. PROCESA LA PETICION Y MUESTRA EL RESULTADO */
    
    $('#btnConfirmarEliminacion').click(function () {
        var idestado = $("#seleccionado").val();
        $.ajax({
            type: "POST",
            url: "procesarBorrarEstado.php",
            data: "idestado="+idestado,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        $('#mdBorrar').modal('toggle');
        return false;
    });

});
