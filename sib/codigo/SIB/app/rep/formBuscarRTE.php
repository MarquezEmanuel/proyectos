<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';

/* OBTIENE LA FECHA ACTUAL PARA CARGAR EL FORMULARIO */

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");

$fechaInicio = (isset($_SESSION['fechaInicioRTE'])) ? $_SESSION['fechaInicioRTE'] : "";

?>
<div class="card-header" id="FormBuscarRTE">
    <div id="contenido">
        <h4 class="text-center p-4">BUSCAR RTE</h4>
        <div class="container">
            <form method="POST" name="formBuscarRTE" id="formBuscarRTE">
                <div class="form-group row">
                    <div class="col">
                        <label class="mr-sm-2" title="Campo no obligatorio">Apellido sujeto vinculado:</label> 
                        <input type="text" class="form-control"
                               id="apellido" name="apellido" 
                               maxlength="50" value=""
                               title="Apellido del sujeto vinculado" placeholder="Apellido del sujeto vinculado">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo obligatorio">* Fecha de inicio:</label> 
                        <input type="date" class="form-control"
                               id="fechaInicio" name="fechaInicio" min="2019-04-01" max="<?= $actual ?>" value="<?= $fechaInicio ?>"
                               title="Fecha de inicio para la consulta" required>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo obligatorio">* Fecha de fin:</label> 
                        <input type="date" class="form-control"
                               id="fechaFin" value="<?= $actual ?>"
                               name="fechaFin" min="2019-04-02" max="<?= $actual ?>"
                               title="Fecha de fin para la consulta" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" id="btnBuscarRTE" name="btnBuscarRTE" value="Buscar">
                            <a href="formBuscarRTE.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                            <a href="inicioRTE.php"><input type="button" class="btn btn-outline-secondary" value="Volver"></a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2"></div>
    <script>
	

$(document).ready(function () {

    $("#formBuscarRTE").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarBuscarRTE.php",
            data: $("#formBuscarRTE").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tablaRTE').DataTable({
                    dom: 'Bfrtip',
                    paging: false,
                    responsive: true,
                    scrollX: true,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Reporte de Transacciones en Efectivo'
                        }, {
                            extend: 'pdfHtml5',
                            title: 'Reporte de Transacciones en Efectivo',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]}
                        }
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

    $("#contenido2").on("change", "#seleccionarTodos", function () {
        if ($(this).is(':checked')) {
            $("input[name='transacciones[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='transacciones[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });

    $("#contenido2").on("click", "#btnBorrarRTE", function (e) {
		var mensaje = confirm("¿Quiere eliminar el RTE?");
//Detectamos si el usuario acepto el mensaje
if (mensaje) {
e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad > 0) {
            $.ajax({
                type: "POST",
                url: "procesarBorrarRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione al menos un registro para borrar</div>');
            $('#mdAdvertencia').modal({});
        }
}
//Detectamos si el usuario denegó el mensaje
else {
alert("¡Eliminacion cancelada!");
}
    });

    $("#contenido2").on("click", "#btnModificarRTE", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad === 1) {
            $.ajax({
                type: "POST",
                url: "formModificarRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").empty();
                    $("#mdAdvertencia").remove();
                    $("#mdProcesando").remove();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione solo un registro para modificar</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    $("#contenido2").on("click", "#btnDetalleRTE", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad === 1) {
            $.ajax({
                type: "POST",
                url: "formDetalleRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").empty();
                    $("#mdAdvertencia").remove();
                    $("#mdProcesando").remove();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la peticiÃ³n </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione solo un registro para ver detalle</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    $("#contenido2").on("click", "#btnAgregarVinculado", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad === 1) {
            $.ajax({
                type: "POST",
                url: "formVincularRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").remove();
                    $("#mdAdvertencia").remove();
                    $("#mdProcesando").remove();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione solo un registro para agregar vinculado</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    $("#contenido2").on("click", "#btnGenerarXML", function (e) {
        e.preventDefault();
        var cantidad = contarTransacciones();
        if (cantidad > 0) {
            $('#mdProcesando').modal({});
            $.ajax({
                type: "POST",
                url: "procesarGenerarRTE.php",
                data: $("#formProcesarBuscarRTE").serialize(),
                success: function (data) {
                    $("#contenido2").empty();
                    $("#contenido").html(data);
                },
                error: function (data) {
                    console.log(data);
                    $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                    $('#mdProcesando').modal("toggle");
                },
                complete: function () {
                    setTimeout(function () {
                        $('#mdProcesando').modal("toggle");
                    }, 1000);
                }
            });
        } else {
            $("#mensaje").html('<div class="alert alert-warning text-center" role="alert">Seleccione al menos un registro para generar XML</div>');
            $('#mdAdvertencia').modal({});
        }
    });

    /* CUENTA LA CANTIDAD DE REGISTROS QUE SE HAN SELECCIONADO DESDE LA TABLA */

    function contarTransacciones() {
        var cantidad = 0;
        $("input[name='transacciones[]']").each(function () {
            if ($(this).is(':checked')) {
                cantidad = cantidad + 1;
            }
        });
        return cantidad;
    }

    /* LLEVA AL TOPE DE LA PANTALLA */

    $("#contenido2").on("click", "#btnTop", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 1250);
        return false;
    });


    $("#contenido").on("click", "#btnTopDetalleRTE", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 1250);
        return false;
    });

    $("#contenido").on("click", "#btnContinuarModificandoRTE", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "formModificarRTE.php",
            data: $("#formContinuarModRTE").serialize(),
            success: function (data) {
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido2").empty();
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });

});


	</script>
</div>
<div class="modal fade" id="mdAdvertencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">REPORTE DE TRANSACCIONES EN EFECTIVO</h4>
            </div>
            <div class="modal-body" id="mensaje"></div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdProcesando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">REPORTE DE TRANSACCIONES EN EFECTIVO</h4>
            </div>
            <div class="modal-body" id="mensaje">
                <div class="alert alert-info text-center" role="alert">Procesando transacciones</div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</body>

</html>