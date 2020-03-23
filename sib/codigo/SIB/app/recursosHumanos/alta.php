<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

require_once './header.php';
?>

<div class="card-header">
    <h4 class="text-center p-4"><u>ALTA</u></h4>
    <div id="contenido" class="container">
        
        <form id="formAltaCliente" name="formAltaCliente" method="POST">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la cuenta" 
                        style="font-size: 1.1em; font-weight: bold;">Datos de Empleado</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre y Apellido:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               id="nombre" name="nombre" 
                               placeholder="Nombre y Apellido del empleado" 
                               title="Nombre y Apellido" required>
                    </div>
				</div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIL:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="cuil" name="cuil" 
                               placeholder="CUIL del empleado" 
                               title="CUIL" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Legajo:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="legajo" name="legajo" 
                               placeholder="Legajo del empleado" 
                               title="Legajo" required>
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
            url: "procesarAlta.php",
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