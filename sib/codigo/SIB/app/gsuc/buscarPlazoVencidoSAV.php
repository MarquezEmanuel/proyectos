<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Plazo Vencido en SAV</u></h3>
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
                        <label class="mr-sm-2">Dias de atraso:</label> 
                        <input type="number" class="form-control" 
                               id="dias" name="dias"
                               placeholder="Dias de atraso">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de atraso:</label> <br>
                        <input type="radio" name="signoDias" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoDias" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoDias" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCanje" name="btnBuscarCanje" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarPlazoVencidoSAV.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
	
	$('#tb_buscar_canje').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Plazo Vencido SAV'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCanje", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarPlazoVencidoSAV.php",
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
                            title: 'Plazo Vencido SAV'
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


