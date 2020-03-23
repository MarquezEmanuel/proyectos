<?php
include_once '../conf/BDConexion.php';
require_once './menuSucursal.php';

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
                               id="fechaInicio" name="fechaInicio" required>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha de fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" value="<?= $fechaHoy; ?>" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" 
                                   id="btnBuscar" name="btnBuscar" 
                                   value="Buscar" class="btn btn-bsc mt-4">
                            <a href="inicioSucursal.php">
                                <input type="button" class="btn btn-dark" id="" name="" value="Volver">
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div id="contenido2" name="contenido2"></div>
</div>
<script type="text/javascript" charset="utf8">
    $(document).ready(function () {

        realizarBusqueda();

        $("#formBuscarBloqueados").submit(function (evento) {
            evento.preventDefault();
            $("#peticion").val("true");
            realizarBusqueda();
        });
    });

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
