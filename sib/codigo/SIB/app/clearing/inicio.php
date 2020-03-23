<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
//Cobro no aplicado

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#0a4b7a;color:white;'>
                                        <tr>
                                            <th>Fecha de Rechazo</th>
                                            <th>Numero de Cheque</th>
                                            <th style='display:none;'>Numero de Rechazo</th>
                                            <th>Monto</th>
                                            <th style='display:none;'>Numero de Motivo</th>
                                            <th>Motivo</th>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th style='display:none;'>Numero de Cliente</th>
                                            <th>Nombre de Cliente</th>
                                            <th style='display:none;'>Codigo de Estado</th>
											<th>Estado</th>
                                            <th style='display:none;'>Localidad</th>
											<th style='display:none;'>Direccion</th>
											<th style='display:none;'>Codigo Postal</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $motivo = utf8_encode($row['DESMOTIVO']);
			$nombre = utf8_encode($row['NOMCUENTA']);
			$localidad = utf8_encode($row['LOCALIDAD']);
			$direccion = utf8_encode($row['DIRECCION']);
            $print = $print . "
            <tr>
                <td>{$row['FECHARECHAZO']}</td>
                <td>{$row['NROCHEQUE']}</td>
                <td style='display:none;'>{$row['NRORECHAZO']}</td>
                <td>{$row['MONTO']}</td>
                <td style='display:none;'>{$row['NROMOTIVO']}</td>
                <td>{$motivo}</td>
                <td>{$row['SUCURSAL']}</td>
                <td style='display:none;'>{$row['CUENTA']}</td>
                <td style='display:none;'>{$row['DIGITO']}</td>
                <td style='display:none;'>{$row['NROCLIENTE']}</td>
                <td>{$nombre}</td>
                <td style='display:none;'>{$row['CODESTADO']}</td>
				<td>{$row['NOMESTADO']}</td>
                <td style='display:none;'>{$localidad}</td>
                <td style='display:none;'>{$direccion}</td>
				<td style='display:none;'>{$row['CODPOSTAL']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}
echo $print;
	}
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");
$primerDia = date('Y-m-d', mktime(0,0,0, date("m"), 1, date("Y")));

require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Libro de Cheques Rechazados</u></h3>
        <div id="centro" class="container">
            <form id="formBuscarCobranzasTC" name="formBuscarCobranzasTC" method="POST">
				<br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Numero de Cheque:</label> 
                        <input type="number" class="form-control" 
                               id="cheque" name="cheque"
                               placeholder="Numero de Cheque">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Desde:</label> 
                        <input type="date" class="form-control" id="desde" name="desde" value = "<?= $primerDia;?>">
                    </div>
					<div class="col">
                        <label class="mr-sm-2">Hasta:</label> 
                        <input type="date" class="form-control" id="hasta" name="hasta" value = "<?= $actual;?>">
                    </div>
                </div>
				<br><br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCobranzasTC" name="btnBuscarCobranzasTC" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="../procesarLogout.php"><input type="button" class="btn btn-dark" id="" name="" value="Salir"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
	<?php
        echo busca();
	?>
	</div>
</div>
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/cargando.gif" class="img-fluid" alt="Responsive image" background="" width="750" height="750">
                </div>
        </div>
</div>
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Libro de Cheques Rechazados'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCobranzasTC", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarChequesRechazados.php",
            data: $("#formBuscarCobranzasTC").serialize(),
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
                            title: 'Libro de Cheques Rechazados'
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
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "button.detallesCobranzasTC", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCheques.php",
            data: "seleccionado="+idcuotas,
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
});

</script>
</html>

