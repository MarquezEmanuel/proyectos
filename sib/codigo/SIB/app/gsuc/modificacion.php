<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();


$id = $_POST['seleccionado'];
$sql = "SELECT * FROM [3cuentasConstanciaSaldo] WHERE id =" . $id;
$modifica = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
$row = sqlsrv_fetch_array($modifica);


?>

<div class="card-header">
    <h4 class="text-center p-4"><u>MODIFICACION</u></h4>
    <div id="contenido3" class="container">
        
        <form id="formAltaCliente" name="formAltaCliente" method="POST">
		<input type="hidden" id="id" name="id" value="<?= $row['id'] ?>">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la cuenta" 
                        style="font-size: 1.1em; font-weight: bold;">Datos de la Cuenta</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Sucursal:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="sucursal" name="sucursal" 
                               placeholder="Sucursal" 
                               title="Sucursal" value="<?= $row['sucursal'];?>" >
                    </div>
				</div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Cuenta:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="cuenta" name="cuenta" 
                               placeholder="Cuenta" 
                               title="Cuenta" value="<?= $row['cuenta'];?>">
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Digito:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="digito" name="digito" 
                               placeholder="Digito" 
                               title="Digito" value="<?= $row['digito'];?>">
                    </div>
                </div>
            </fieldset>
            <br>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <input type="submit" class="btn btn-dark" id="btnCrearCuentaComitente" name="btnCrearCuentaComitente" value="Guardar">
						&nbsp;&nbsp;
                        <a href="constanciaSaldos.php"><input type="button" class="btn btn-dark" value="Cancelar"></a>
                    </div>
                </div>
            </div>   
        </form>
    </div>
    <div id="contenido2"></div>
</div> 
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
$('#formAltaCliente').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "procesarModificacion.php",
            data: $("#formAltaCliente").serialize(),
            success: function (data) {
				$("#contenido3").empty();
                $("#contenido2").html(data);
            },
            error: function (msg) {
                console.log(msg);
				$("#contenido3").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
});
</script> 
</html>