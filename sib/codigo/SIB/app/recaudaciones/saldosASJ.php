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
                        <h4><u>Saldos ASJ</u>
						<button type='button' class='btn btn-outline-info' id='info' name='info' title='INFO' data-toggle='modal' data-target='#infos'> 
							<img src='../../lib/img/info.png' width='25' height='25'>
						</button>
						</h4>
                    </div>
                </div>
            </div>
            <br>
            <div id="centro" class="container">
                <form id="formBuscarEmpleado" name="formBuscarEmpleado" method="POST">
                    <div class="row">
                        <div class="col">
                            <label class="mr-sm-2">Sucursal:</label> 
                            <input type="number" class="form-control" id="sucursal" name="sucursal" placeholder="Sucursal de Cuenta">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Cuenta:</label> 
                            <input type="number" class="form-control" id="cuenta" name="cuenta" placeholder="Numero de Cuenta">
                        </div>
						<div class="col">
                            <label class="mr-sm-2">Digito:</label> 
                            <input type="number" class="form-control" id="digito" name="digito" placeholder="Digito de Cuenta">
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
					<img src="../../lib/img/ajax-loader.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>

<div class="modal fade" id="infos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">SALDOS ASJ</h4>
            </div>
            <div class="modal-body" id="mensaje">
				<em align="center">En esta pantalla se muestran todos los saldos de las cuentas ASJ cargadas.</em>
				<br><br>
				<em align="center">Una vez buscadas se pueden exportar en formato excel.</em>
			</div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
            </div>
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
            url: "procesarSaldosASJ.php",
            data: $("#formBuscarEmpleado").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
			},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Movimientos',
							 customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
 
                // Loop over the cells in column `C`
                $('row c[r^="E"]', sheet).each( function () {
                    // Get the value
                    if ( $('is t', this).val() <= 0 ) {
                        $(this).attr( 's', '20' );
                    }
                });
            
            }
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

