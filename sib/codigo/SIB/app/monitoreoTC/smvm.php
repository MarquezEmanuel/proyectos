<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

$sql = "SELECT *,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [bd_sib].[dbo].[SMVM]";
$modifica = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
$row = sqlsrv_fetch_array($modifica);
$fecha = isset($row['fechaActualizacion']) ? $row['fechaActualizacion']->format('d/m/Y') : "";
$saldo = $row['saldo2'];
date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");
require_once './header.php';
?>

<div class="card-header">
    <h4 class="text-center p-4"><u>SMVM</u></h4>
    <div id="contenido" class="container">
        
        <form id="formAltaCliente" name="formAltaCliente" method="POST">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la cuenta" 
                        style="font-size: 1.1em; font-weight: bold;">Datos Guardados</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               placeholder="Monto cargado" 
                               title="Sucursal" value="<?= $saldo;?>" readonly="readonly">
                    </div>
				</div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               placeholder="Fecha de carga" 
							   id="fechaAnterior" name="fechaAnterior" 
                               title="Cuenta" value="<?= $fecha;?>" readonly="readonly">
                    </div>
                </div>
            </fieldset>
            <br>
			<fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la cuenta" 
                        style="font-size: 1.1em; font-weight: bold;">Datos Actuales</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="monto" name="monto" 
                               placeholder="Monto SMVM" 
                               title="Monot" required>
                    </div>
				</div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                    <div class="col">
                        <input type="date" class="form-control"
                               id="fecha" name="fecha" 
                               placeholder="Fecha" 
                               title="Fecha" value="<?= $actual ?>" readonly="readonly">
                    </div>
                </div>
            </fieldset>
			<br>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <input type="submit" class="btn btn-dark" id="btnCrearCuentaComitente" name="btnCrearCuentaComitente" value="Guardar">
						&nbsp;&nbsp;
                        <a href="regimen.php"><input type="button" class="btn btn-dark" value="Cancelar"></a>
                    </div>
                </div>
            </div>   
        </form>
    </div>
    <div id="contenido2"></div>
</div>  
<script>
$(document).ready(function () {
	
$('#formAltaCliente').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarSMVM.php",
            data: $("#formAltaCliente").serialize(),
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").html(data);
            },
            error: function (msg) {
                console.log(msg);
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
});
</script> 
</html>