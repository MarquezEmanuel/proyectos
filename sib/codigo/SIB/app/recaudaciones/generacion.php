<?php
/* INICIALIZA LA SESION */
session_start();

require_once './header.php';

/* OBTIENE LA FECHA ACTUAL PARA CARGAR EL FORMULARIO */



?>
<div class="card-header" id="FormBuscarRTE">
    <div id="contenido">
        <h3 class="text-center">
		<u>Generar PMCRED - PMDEB</u>
		<button type='button' class='btn btn-outline-info' id='info' name='info' title='INFO' data-toggle='modal' data-target='#infos'> 
            <img src='../../lib/img/info.png' width='25' height='25'>
        </button>
		</h3>
        <div class="container">
            <form method="POST" name="formBuscarRTE" id="formBuscarRTE">
			<br>
                <div class="form-group row">
                    <div class="col">
                        <label class="mr-sm-2" title="Campo no obligatorio">Fecha:</label> 
                        <input type="date" class="form-control" 
                               id="fecha" name="fecha">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo obligatorio">Operacion:</label> 
                        <select class="form-control" id="operacion" name="operacion" title="tipo de operacion">
                            <option value="debito">Debito</option>
                            <option value="credito">Credito</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo obligatorio">Cuenta:</label> 
                        <input type="text" class="form-control"
                               id="cuenta" name="cuenta"
                               placeholder="Numero de cuenta">
                    </div>
                </div>
				<br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarRTE" name="btnBuscarRTE" value="Buscar">
							&nbsp;
                            <a href="inicio.php"><input type="button" class="btn btn-dark" value="Cancelar"></a>
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
            url: "procesarBuscarGeneracion.php",
            data: $("#formBuscarRTE").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
			},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tablaRTE').DataTable({
                    dom: 'Brtip',
                    paging: false,
                    responsive: true,
                    scrollX: true,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Casos PMCRED - PMDEB'
                        }
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
			complete: function() {
					setTimeout(function(){
						$('#mdProcesando').modal('hide');
					},1000)		
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
                url: "procesarGenerarGeneracion.php",
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
            $("#mensaje").html('<div class="alert alert-danger text-center" role="alert">Seleccione al menos un registro para generar PMCRED_DEB</div>');
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
                <h4 class="modal-title text-center" id="myModalLabel">CLIENTES FALLECIDOS CON CUENTA ANSES</h4>
            </div>
            <div class="modal-body" id="mensaje"></div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/cargando.gif" class="img-fluid" alt="Responsive image" background="" width="750" height="750">
                </div>
        </div>
</div>

<div class="modal fade" id="infos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">PMCRED - PMDEB</h4>
            </div>
            <div class="modal-body" id="mensaje">
				<em align="center">Este reporte busca todos los PMCRED - PMDEB que se hayan creado.</em>
				<br><br>
				<em align="center">A partir de los mismos se puede generar el archivo PMCRED - PMDEB para debitar el saldo.</em>
			</div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
            </div>
        </div>
    </div>
</div>

</body>

</html>