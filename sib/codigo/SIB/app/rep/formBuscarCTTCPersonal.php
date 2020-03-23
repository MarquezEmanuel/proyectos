<?php
/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';

/* OBTIENE LA FECHA ACTUAL PARA CARGAR EL FORMULARIO */

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m");
?>
<div id="contenido">
    <div class="card-header">
        <h4 class="text-center p-4">BUSCAR CTTC PERSONAL (MAYORES A 13 SMVM)</h4>
        <div class="container">
            <form method="POST" name="formBuscarCTTC" id="formBuscarCTTC">
                <div class="form-group row">
                    <div class="col">
                        <label class="mr-sm-2" title="Campo no obligatorio">* Mes:</label> 
                        <input type="month" class="form-control" value="<?= $actual; ?>" max="<?= $actual; ?>"
                               id="mes" name="mes" title="Mes a consultar" required>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo no obligatorio">Marca:</label> 
                        <select class="form-control" id="marca" name="marca"
                                title="Marca de tarjeta de credito">
                            <option value="TODAS">Todas</option>
                            <option value="VISA">VISA</option>
                            <option value="MASTERCARD">MASTERCARD</option>
                        </select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2" title="Campo no obligatorio">Nro de documento:</label> 
                        <input type="text" class="form-control"
                               id="documento" name="documento" maxlength="15"
                               title="Numero de documento" placeholder="Numero de documento">
                    </div>

                    <div class="col">
                        <label class="mr-sm-2" title="Campo obligatorio">Nro de cuenta:</label> 
                        <input type="text" class="form-control"
                               id="cuenta" name="cuenta" maxlength="15"
                               title="Numero de cuenta" placeholder="Numero de cuenta">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" 
                                   id="btnBuscarCTTC" name="btnBuscarCTTC" 
                                   title="Realizar busqueda" value="Buscar">
                            <a href="formBuscarCTTCPersonal.php">
                                <input type="button" class="btn btn-outline-secondary"
                                       title="Actualizar pagina" value="Cancelar">
                            </a>
                            <a href="regimenTC.php">
                                <input type="button" class="btn btn-outline-secondary" 
                                       title="Regresar a opciones de Regimen TC" value="Volver">
                            </a>
                        </div>
                    </div>
                </div>  
            </form>
        </div>
    </div>
</div>
<div id="contenido2" name="contenido2" class="container mt-4"></div>
<div class="modal fade" id="ModalBorrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">CONFIRME LA OPERACIÓN</h4>
            </div>
            <div class="modal-body" id="cuerpoModalBorrar">
                <div class="form-row">
                    <b><p id="datosTransacciones" name="datosTransacciones"></p></b>
                    <p>&nbsp;Presione <b>GUARDAR</b> para efectuar la operación.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" 
                        name="btnCancelarEliminacion" id="btnCancelarEliminacion"
                        data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-dark"
                        name="btnBorrar" id="btnBorrar">
                    <i class="far fa-save"></i> GUARDAR</button>
                <input type='submit' class='btn btn-outline-secondary' 
                       style="display: none;"
                       name="btnRefrescarPantalla" id="btnRefrescarPantalla" value='Aceptar'>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdProcesando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">CTTC PERSONAL</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info text-center" role="alert">Procesando transacciones</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" charset="utf8">
    $(document).ready(function () {

        realizarBusqueda();

        $("#contenido2").on('click', '#btnBorrarCTTC', function () {
            var cantidad = contarTransacciones();
            if (cantidad > 0) {
                $("#datosTransacciones").text("Transacciones seleccionadas (" + cantidad + "):");
                $("#resultado").empty();
                $("#ModalBorrar").modal({backdrop: 'static', keyboard: false});
            } else {
                var men = '<b>Seleccione al menos una transacción para eliminar</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#resultado").html(div);
            }
        });

        $("#contenido2").on('click', '#btnGenerarXML', function () {
            var cantidad = contarTransacciones();
            if (cantidad > 0) {
                $('#mdProcesando').modal({});
                $.ajax({
                    type: "POST",
                    url: "procesarGenerarCTTCPersonal.php",
                    data: $("#formProcesarBuscarCTTC").serialize(),
                    success: function (data) {
                        $("#contenido2").empty();
                        $("#contenido").html(data);
                    },
                    error: function (data) {
                        console.log(data);
                        var men = '<b>Error al procesar la petición</b>';
                        var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                        $("#contenido2").html(div);
                        $('#mdProcesando').modal("toggle");
                    },
                    complete: function () {
                        setTimeout(function () {
                            $('#mdProcesando').modal("toggle");
                        }, 1000);
                    }
                });
            } else {
                var men = '<b>Seleccione al menos una transacción para generar XML</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#resultado").html(div);
            }
        });

        $("#btnBorrar").click(function () {
            $.ajax({
                type: "POST",
                url: "./procesarBorrarCTTCPersonal.php",
                data: $("#formBloqueados").serialize(),
                success: function (data) {
                    $('#cuerpoModalBorrar').html(data);
                    $('#btnCancelarEliminacion').hide();
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

        $("#formBuscarCTTC").submit(function (e) {
            e.preventDefault();
            realizarBusqueda();
        });

        $('#btnRefrescarPantalla').click(function () {
            location.reload();
        });

    });

    function contarTransacciones() {
        var cantidad = 0;
        $("input[name='transacciones[]']").each(function () {
            if ($(this).is(':checked')) {
                cantidad = cantidad + 1;
            }
        });
        return cantidad;
    }

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./procesarBuscarCTTCPersonal.php",
            data: $("#formBuscarCTTC").serialize(),
            success: function (data) {
                $('#contenido2').html(data);
                $('#tbCTTC').dataTable({
                    dom: 'Brtip',
                    responsive: true,
                    pageLength: 20,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'CTTC_PERSONAL'}
                    ],
                    language: {url: "/lib/js/Spanish.json"}
                });
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#contenido2").html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: $("#contenido2").offset().top}, '1250');
            }
        });
    }
</script>