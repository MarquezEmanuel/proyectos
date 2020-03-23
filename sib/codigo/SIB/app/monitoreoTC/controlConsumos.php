<?php
/* INICIALIZA LA SESION */
session_start();

require_once './header.php';
?>
    <div class="card-header">
        <div id="contenido">
            <br><div class="row">
                <div class="col">
                    <div class="text-center">
                        <h4><u>Control de consumos</u></h4>
                    </div>
                </div>
            </div>
            <br>
            <div id="centro" class="container">
                <form id="formBuscarEmpleado" name="formBuscarEmpleado" method="POST">
                    <div class="row">
                        <div class="col">
                            <label class="mr-sm-2">Tarjeta:</label> 
                            <select name="tarjeta[]" id="tarjeta" class="form-control mb-2" title="Tipo de tarjeta">
								<option value="MC">Master</option>
								<option value="VS">Visa</option>
							</select>
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Control:</label> 
                            <select name="control[]" id="control" class="form-control mb-2" title="Control de consumos">
								<option value="0">Todos</option>
								<option value="13">Mayores a 13 SMVM</option>
								<option value="50">Mayores a 50 SMVM</option>
							</select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <input type="submit" class="btn btn-dark" id="btnBuscar" name="btnBuscar" value="Buscar" class="btn btn-bsc mt-4">
								&nbsp;&nbsp;
                                <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                            </div>
                        </div>
                    </div><br>
                </form>
            </div>
        </div>
        <div id="contenido2" name="contenido2"></div>

    </div>
	
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/espera.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>

</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarControlConsumos.php",
            data: $("#formBuscarEmpleado").serialize(),
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
                            title: 'PMCRED'
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

