<?php
/* INICIALIZA LA SESION */
session_start();

require_once './header.php';
?>

<div class="card-header">
    <h4 class="text-center p-4">CREAR PMCRED - PMDEB</h4>
    <div id="contenido" class="container">       
        <form id="formAltaCliente" name="formAltaCliente" method="POST">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la cuenta" 
                        style="font-size: 1.1em; font-weight: bold;">Operacion</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                    <div class="col">
                        <input type="date" class="form-control"
                               id="fecha" name="fecha" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Moneda:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="moneda" name="moneda" 
                               placeholder="Moneda" 
                               title="Moneda" required>
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
                               title="Numero de causal" min="1"
							   max="999" maxlength="3" required>
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
                               title="Numero de cuenta" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Sucursal de la Cuenta:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               id="sucursal" name="sucursal"
                               placeholder="Sucursal de la Cuenta" 
                               title="Sucursal de la Cuenta" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Digito de la Cuenta:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="digito" name="digito"
                               placeholder="Digito" 
                               title="Digito" min="0"
							   max="9" maxlength="1" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Importe:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="importe" name="importe"
                               placeholder="Importe" 
                               title="Importe" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Sucursal de origen:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="oficina" name="oficina"
                               placeholder="Sucursal de Origen" 
                               title="Sucursal de Origen" required>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="">* Numero de Documento:</label> 
                    <div class="col">
                        <input type="number" class="form-control"
                               id="documento" name="documento"
                               placeholder="Documento" 
                               title="Documento">
                    </div>
					<label class="col-sm-2 col-form-label" title="Campo obligatorio">* Razon de la operacion:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               id="razon" name="razon"
                               placeholder="Razon de la operacion" 
                               title="Razon de la operacion" required>
                    </div>
                </div>
            </fieldset>
            <br>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <input type="submit" class="btn btn-dark" id="btnCrearCuentaComitente" name="btnCrearCuentaComitente" value="Guardar">
						&nbsp;
                        <a href="modificaElimina.php"><input type="button" class="btn btn-dark" value="Modificar / Eliminar"></a>
						&nbsp;
						<a href="inicio.php"><input type="button" class="btn btn-dark" value="Salir"></a>
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
            url: "procesarCreacion.php",
            data: $("#formAltaCliente").serialize(),
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").html(data);
            },
            error: function (msg) {
                console.log(msg);
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la peticiĂ³n </div>');
            }
        });
    });
	
});
</script> 
</html>