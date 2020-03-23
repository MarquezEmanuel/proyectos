<?php
/* INICIALIZA LA SESION */
session_start();

require_once './header.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual =  date("d-m-Y");
	$actual = strtotime ( '-1 day' , strtotime ( $actual ) ) ;
	$actual = date ( 'd-m-Y' , $actual );
	
	function dia() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(debe as money),1) AS debe2,convert(varchar,cast(haber as money),1) AS haber2,convert(varchar,cast(montoSFB as money),1) AS montoSFB2 FROM [9conciliacionContable] WHERE fechaActualizacion between '$actual' and '$actualfinal'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
	$sumaSCB = $sumaSFB = 0;
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$sumaSCB = $sumaSCB + $row['debe'];
				$sumaSFB = $sumaSFB + $row['haber'];
                $html = $html . "
                    <tr>
                    <td>{$row['sucursalDestino']}</td>
                    <td>{$row['tipoAsiento']}</td>    
                    <td>{$row['numeroAsiento']}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['debe2']}</td>
					<td>{$row['haber2']}</td>
					<td>{$row['montoSFB2']}</td>
					<td>{$row['origen']}</td>
					<td>{$row['causal']}</td>
                    </tr>";
            }
			$resta = $sumaSCB - $sumaSFB;
			$sumaSCB = number_format($sumaSCB, 2, ',', '.');
			$sumaSFB = number_format($sumaSFB, 2, ',', '.');
			$resta = number_format($resta, 2, ',', '.');
			$html = $html . "
					<tfoot>
					<tr>

						<th>Total SCB: {$sumaSCB} -- Total SFB: {$sumaSFB} -- Diferencia: {$resta}</th>
					</tr>
					</tfoot>
			";
        } else {
            $html = $html . "<tr> <td COLSPAN=9>No hay conciliaciones con diferencias en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=9>No hay conciliaciones con diferencias en la fecha</td></tr>";
    }
    return $html;
}
?>
    <div class="card-header">
        <div id="contenido">
            <br><div class="row">
                <div class="col">
                    <div class="text-center">
                        <h4><u>CONCILIACION  <?php echo $actual;?></u></h4>
                    </div>
                </div>
            </div>
            <br>
            <a href="buscarConciliacion.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicio.php"><input type="button" class="btn btn-dark" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='conciliacion' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#144c75;color:white;'>
                                    <tr>
                                        <th>SCB-Sucursal Origen</th>
                                        <th>SCB-Tipo Asiento</th>
                                        <th>SCB-Numero Asiento</th>
                                        <th>SCB-Descripcion</th>
                                        <th>SCB-Debe</th>
										<th>SFB-Haber</th>
										<th>SFB-Monto</th>
										<th>SFB-Origen</th>
										<th>SFB-Causal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo dia();
                                    ?>
                                </tbody>
                            </table>
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

</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#conciliacion').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 500,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Conciliacion Contable'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
	
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarBaja.php",
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
                            title: 'Conciliacion'
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
    
    $("#contenido2").on("click", "img.detallesCobranzasTC", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "procesarBaja.php",
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
	
	/*MODIFICAR USUARIO*/
	
	
	$("#contenido2").on("click", "img.modificarUsuario", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "modificacion.php",
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

