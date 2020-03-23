<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");
$primerDia = date('Y-m-d', mktime(0,0,0, date("m"), 1, date("Y")));

/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Altas de Chequeras</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarCanje" name="formBuscarCanje" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="sucursal" title="sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Desde:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio" value ="<?=$primerDia?>"
                               placeholder="DD/MM/AAAA" title="Fecha Desde">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Hasta:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" value ="<?=$actual?>"
                               placeholder="DD/MM/AAAA" title="Fecha Hasta">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCanje" name="btnBuscarCanje" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarChequeras.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="altaChequeras.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
	<?php

	?>
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
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCanje", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarChequeras.php",
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
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
});
</script>
</html>


