<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");
$primerDia = date('Y-m-d', mktime(0,0,0, date("m"), 1, date("Y")));

?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Consumos</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMoraTarjetas" name="formBuscarMoraTarjetas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Tipo de Tarjeta:</label> 
                        <select name="tipo[]" id="tipo" class="form-control mb-2" title="Tipo de tarjeta">
						<option value="MC">Master</option>
						<option value="VS">Visa</option>
						</select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="Numero de Cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Rubro:</label> <br>
                        <input type="number" class="form-control" 
                               id="rubro" name="rubro"
                               placeholder="Rubro Comercio">
                    </div>
                </div>
                <br>
				<div class="row">
					<div class="col">
                        <label class="mr-sm-2">Desde:</label> 
                        <input type="date" class="form-control" 
                               id="desde" name="desde"
                               placeholder="DD/MM/AAAA" title="Fecha Desde"
							   value="<?= $primerDia ?>">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Hasta:</label> 
                        <input type="date" class="form-control" 
                               id="hasta" name="hasta" 
                               placeholder="DD/MM/AAAA" title="Fecha Hasta"
							   value="<?= $actual ?>">
                    </div>
					<div class="col">
                        <label class="mr-sm-2">Transaccion:</label> 
                        <select name="transaccion[]" id="transaccion" class="form-control mb-2" title="Codigo de Transaccion">
						<option value="consumo">Consumos/Extracciones</option>
						<option value="costo">Costo Financiero</option>
						</select>
                    </div>
				</div>
				<br><br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMoraTarjetas" name="btnBuscarMoraTarjetas" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="consumos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
                            title: 'Consumo'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMoraTarjetas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarConsumos.php",
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
                            title: 'Consumo'
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

