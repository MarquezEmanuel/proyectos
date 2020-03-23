<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$id = $_POST['seleccionado'];
$sql = "SELECT * FROM [10pmcred] WHERE id =" . $id;
$modifica = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
$row = sqlsrv_fetch_array($modifica);
$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
$fecha = date("Y-m-d", strtotime($fecha));

?>

<div class="card-header">
    <h4 class="text-center p-4"><u>MODIFICACION</u></h4>
    <div id="contenido" class="container">
        
        <form id="formAltaCliente" name="formAltaCliente" method="POST">
		<input type="hidden" id="id" name="id" value="<?= $row['id'] ?>">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la cuenta" 
                        style="font-size: 1.1em; font-weight: bold;">Datos de la Operacion</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                    <div class="col">
                        <input type="date" class="form-control"
                               id="fecha" name="fecha" value="<?= $fecha;?>"
							   required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Moneda:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="moneda" name="moneda" 
                               placeholder="Moneda" 
                               title="Moneda" value="<?= $row['moneda'];?>"
							   required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de Operacion:</label> 
                    <div class="col">
                        <select class="form-control" id="operacion" name="operacion" title="tipo de operacion">
                            <option value="debito">Debito</option>
                            <option value="credito">Credito</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Causal:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="causal" name="causal"
                               placeholder="Numero de causal" 
                               title="Numero de causal" value="<?= $row['causal'];?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de Cuenta:</label> 
					<div class="col">
                        <select class="form-control" id="tipoCuenta" name="tipoCuenta" title="tipo de cuenta">
                            <option value="cc">Cuenta Corriente</option>
                            <option value="ca">Caja de Ahorro</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Numero de Cuenta:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="cuenta" name="cuenta"
                               placeholder="Numero de cuenta" 
                               title="Numero de cuenta" value="<?= $row['numeroCuenta'];?>" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Sucursal de la Cuenta:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               id="sucursal" name="sucursal"
                               placeholder="Sucursal" 
                               title="Sucursal" value="<?= $row['sucursal'];?>" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Digito de la Cuenta:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="digito" name="digito"
                               placeholder="Digito" 
                               title="Digito" value="<?= $row['digito'];?>" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Importe:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="importe" name="importe"
                               placeholder="Importe" 
                               title="Importe" value="<?= $row['importe'];?>" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Rubro de la Cuenta:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               id="rubro" name="rubro"
                               placeholder="Rubro de la cuenta" 
                               title="Rubro de cuenta" value="<?= $row['rubro'];?>" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Numero de Documento:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="documento" name="documento"
                               placeholder="Documento" 
                               title="Documento" value="<?= $row['documento'];?>" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Oficina de origen:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="oficina" name="oficina"
                               placeholder="Oficina / Banco" 
                               title="Oficina / Banco" value="<?= $row['oficina'];?>" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Razon de la operacion:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               id="razon" name="razon"
                               placeholder="Razon de la operacion" 
                               title="Razon de la operacion" value="<?= $row['razon'];?>" required>
                    </div>
                </div>
            </fieldset>
            <br>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <input type="submit" class="btn btn-dark" id="btnCrearCuentaComitente" name="btnCrearCuentaComitente" value="Guardar">
						&nbsp;&nbsp;
                        <a href="inicio.php"><input type="button" class="btn btn-dark" value="Cancelar"></a>
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
            url: "procesarModificacionPMCRED.php",
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