<?php
include_once '../conf/BDConexion.php';
require_once './menu.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaHoy = date("Y-m-d");
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Clientes bloqueados en IVR</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarBloqueados" name="formBuscarBloqueados" method="POST">
                <input type="hidden" name="peticion" id="peticion">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Documento:</label> 
                        <input type="number" class="form-control" 
                               id="documento" name="documento" min="1" maxlength="13"
                               placeholder="Nro de documento" title="Nro de documento">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha de inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha de fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" value="<?= $fechaHoy; ?>">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" 
                                   id="btnBuscar" name="btnBuscar" 
                                   value="Buscar" class="btn btn-bsc mt-4">
                            <a href="inicio.php">
                                <input type="button" class="btn btn-dark" id="" name="" value="Volver">
                            </a>
                            <input type='button' class='btn btn-danger' 
                                   id='btnEliminarBloqueados' name='btnEliminarBloqueados' 
                                   title="Eliminar elementos seleccionados"
                                   value='ELIMINAR'>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2" class="mt-4 mb-4"></div>
    <div class="modal fade" id="ModalBorrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">CONFIRME LA OPERACIÓN</h4>
                </div>
                <div class="modal-body" id="cuerpoModalBorrar">
                    <div class="form-row">
                        <b><p id="datosBloqueo" name="datosAcceso"></p></b>
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
</div>
<script type="text/javascript" charset="utf8">
    $(document).ready(function () {

        realizarBusqueda();

        $("#formBuscarBloqueados").submit(function (evento) {
            evento.preventDefault();
            $("#peticion").val("true");
            realizarBusqueda();
        });

        $('#btnEliminarBloqueados').click(function () {
            var cantidad = contarBloqueados();
            if (cantidad > 0) {
                $("#datosBloqueo").text("Bloqueos seleccionados (" + cantidad + "):");
                $("#resultado").empty();
                $("#ModalBorrar").modal({backdrop: 'static', keyboard: false});
            } else {
                var men = '<b>Seleccione al menos un cliente para eliminar bloqueo</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#resultado").html(div);
            }
        });

        $("#btnBorrar").click(function () {
            $.ajax({
                type: "POST",
                url: "./procesarBorrarClientesBloquadosIVR.php",
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

        /* ACTUALIZA LA PANTALLA LUEGO DE HACER EL ALTA O BAJA */

        $('#btnRefrescarPantalla').click(function () {
            location.reload();
        });

    });

    function contarBloqueados() {
        var cantidad = 0;
        $("input[name='bloqueados[]']").each(function () {
            if ($(this).is(':checked')) {
                cantidad = cantidad + 1;
            }
        });
        return cantidad;
    }

    function realizarBusqueda() {
        $.ajax({
            type: "POST",
            url: "./procesarBuscarClientesBloqueadosIVR.php",
            data: $("#formBuscarBloqueados").serialize(),
            success: function (data) {
                $('#contenido2').html(data);
                $('#tbBloqueados').dataTable({
                    dom: 'Brtip',
                    responsive: true,
                    pageLength: 20,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Clientes bloqueados en IVR'}
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
