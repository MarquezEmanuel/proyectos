<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';


?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Maestro de Cuentas</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMoraTarjetas" name="formBuscarMoraTarjetas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Tipo de Cuenta:</label> 
                        <select name="tipo[]" id="tipo" class="form-control mb-2" title="Tipo de Cuenta">
						<option value="MC">Master</option>
						<option value="VS">Visa</option>
						</select>
                    </div>
					<div class="col">
                        <label class="mr-sm-2">Estado de Cuenta:</label> 
                        <select name="estado[]" id="estado" class="form-control mb-2" title="Estado de la Cuenta">
						<option value="activa">Activa</option>
						<option value="inactiva">Inactiva</option>
						</select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="Numero de Cuenta">
                    </div>
                </div>
                <br>
				<div class="row">
					<div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Sucursal" title="Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Denominacion:</label> 
                        <input type="text" class="form-control" 
                               id="denominacion" name="denominacion" 
                               placeholder="Denominacion" title="Denominacion">
                    </div>
				</div>
				<br><br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMoraTarjetas" name="btnBuscarMoraTarjetas" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="cuentas.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">

	</div>
</div>
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/espera.gif" class="img-fluid" alt="Responsive image" background="" width="400" height="400">
                </div>
        </div>
</div>
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_MoraTarjetas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Maestro de Cuentas'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMoraTarjetas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuentas.php",
            data: $("#formBuscarMoraTarjetas").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_MoraTarjetas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Maestro de Cuentas'
                        },
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
        return false;
    });
    
});

</script>
</html>

