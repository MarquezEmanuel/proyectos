<?php

require_once '../conf/Constants.php';
include_once '../conf/BDConexion.php';

session_start();

$directorio = opendir(URL_Conta);
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (!is_dir($archivo))//verificamos si es o no un directorio
    {
		if(substr($archivo,0,9) == "conta_0".str_pad($_SESSION['sucursal'], 2, "0", STR_PAD_LEFT)){
		$print = $print . "
				<input class='form-control mb-2' id='sucursal' name='sucursal' value='".$archivo."' readonly='readonly'></input>";
		}
    }
}

require_once './menuSucursal.php';
?>
<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Conta - Sucursales</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarCanje" name="formBuscarCanje" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="col-sm-2 col-form-label">Sucursal:</label> 
                        <div class="col" >
								<?=$print; ?>
							</div>
                    </div>
                    <div class="col">
                        <label class="col-sm-2 col-form-label">Saldo:</label>
                        <div class="col" >
                            <input type="text" id="monto" name="monto" class="form-control mb-2" placeholder="Saldo Actual: ej. 100.00">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCanje" name="btnBuscarCanje" value="Calcular" class="btn btn-bsc mt-4">
							&nbsp;
							<a href="archivosConta.php"><input type="button" class="btn btn-dark" id="" name="" value="Archivos Generados"></a>
                            &nbsp;
                            <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
	
	</div>
</div>

<div class="modal fade" id="mdCargando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/cargandoGSUC.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>
</body>
<script>
$(document).ready(function () {
	
	 $("#contenido2").on("click", "button.detallesSaldos", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesConta.php",
            data: "seleccionado="+idcanje,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCanje", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarConta.php",
            data: $("#formBuscarCanje").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_canje').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Altas Chequeras'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
			complete: function() {
					setTimeout(function(){
						$('#mdCargando').modal('hide');
					},1000)		
				},
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la peticiĂ³n </div>');
            }
        });
        return false;
    });
    
});
</script>
</html>