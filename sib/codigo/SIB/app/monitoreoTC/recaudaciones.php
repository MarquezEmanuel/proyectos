<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
$actual = date("Y-m-d");

function busca(){
$hoy = date("d/m/y");
$hoy = str_replace("/","",$hoy);
$sql = "select * from openquery(M4000SF,'
SELECT                                                                    RCO_SERVI ENTE,
                                                                                 RCOSUBENT SUB_ENTE,
                                                                                 TFE_PAGO F_COBRO,
                                                                                 TFE_VENCI VTO1,
                                                                                 SCO_IDENT CLIENTE_SFB,
                                                                                 ACO_CONCE CONCEPTO,
                                                                                 ACU_OFICI SUC,
                                                                                 ACUNUMCUE CTA,
                                                                                 RNU_COMPO ABONADO,
                                                                                 TVA_MOVIM IMPORTE,
                                                                                 CASE 
                                                                                 WHEN RREINFSMO=0 THEN ''Sin Enviar''
                                                                                 ELSE TO_CHAR((to_date(''010157'', ''ddmmrrrr'') + RREINFSMO))
                                                                                 END ENVIO_SMARTOPEN,
                                                                                 ''TOTAL'' COBRANZA
                                                                                 FROM SFB_REAFA
                                                                                 WHERE 
                                                                                 
                                                                                 RCO_SERVI IN (500,501)
                                                                                 AND RFEULPAPA = 0
                                                                                 AND DNO_TERMI = ''R32''
                                                                                 AND RSEESTREG = ''CC''
                                                                                 AND RREINFSMO = (to_date(lpad( ".$hoy." ,6,''0''),''ddmmrrrr'')- TO_DATE(''010157'',''ddmmrrrr'')) 
                                                                                 
union all

SELECT 
                                                                                 RCO_SERVI ,
                                                                                 RCOSUBENT ,
                                                                                 RFE_PROCE ,
                                                                                 TFE_VENCI ,
                                                                                 SCO_IDENT ,
                                                                                 ACO_CONCE ,
                                                                                 ACU_OFICI ,
                                                                                 ACUNUMCUE ,
                                                                                 RNU_COMPO ,
                                                                                 RVA_IMPDEB  ,
                                                                                 CASE 
                                                                                 WHEN RREINFSMO=0 THEN ''Sin Enviar''
                                                                                 ELSE TO_CHAR((to_date(''010157'', ''ddmmrrrr'') + RREINFSMO))
                                                                                 END ENVIO_SMARTOPEN,
                                                                                 ''PARCIAL'' COBRANZA
                                                                                 FROM SFB_REAHP 
                                                                                 WHERE 
                                                                                 RCO_SERVI IN (500,501)
                                                                                 AND MOT_COBRO = '' ''
                                                AND RREINFSMO = (to_date(lpad( ".$hoy." ,6,''0''),''ddmmrrrr'')- TO_DATE(''010157'',''ddmmrrrr''))                                                                            
                                                                                 ') where ENVIO_SMARTOPEN = 'Sin Enviar'
	";
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
	if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Ente</th>
                                            <th>Sub-Ente</th>
                                            <th>Fecha Cobro</th>
                                            <th>Vencimiento</th>
                                            <th>Cliente</th>
                                            <th>Concepto</th>
                                            <th>Sucursal</th>
                                            <th>Cuenta</th>
                                            <th>Abonado</th>
                                            <th>Monto</th>
                                            <th>Envio SMARTOPEN</th>
                                            <th>Cobranza</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
                <td>{$row['ENTE']}</td>
                <td>{$row['SUB_ENTE']}</td>
                <td>{$row['F_COBRO']}</td>
                <td>{$row['F_COBRO']}</td>
                <td>{$row['CLIENTE_SFB']}</td>
                <td>{$row['CONCEPTO']}</td>
                <td>{$row['SUC']}</td>
                <td>{$row['CTA']}</td>
                <td>{$row['ABONADO']}</td>
                <td>{$row['IMPORTE']}</td>
                <td>{$row['ENVIO_SMARTOPEN']}</td>
                <td>{$row['COBRANZA']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table>";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron recaudaciones sin informar en la fecha</div>';
    }
} 
echo $print;
}


?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Recaudaciones SFB</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMoraTarjetas" name="formBuscarMoraTarjetas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Recaudaciones:</label> 
                        <select name="tipo[]" id="tipo" class="form-control mb-2" title="Tipo de tarjeta">
						<option value="informada">Informada</option>
						<option value="sin informar">Sin Informar</option>
						</select>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="Numero de Cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> <br>
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de sucursal">
                    </div>
                </div>
                <br>
				<div class="row">
					<div class="col">
                        <label class="mr-sm-2">Fecha:</label> 
                        <input type="date" class="form-control" 
                               id="fecha" name="fecha"
                               placeholder="DD/MM/AAAA" title="Fecha"
							   value="<?= $actual ?>" required>
                    </div>
					<div class="col">
                        <label class="mr-sm-2">Cobranza:</label> 
                        <select name="cobranza[]" id="cobranza" class="form-control mb-2" title="cobranza">
						<option value="todas">Todas</option>
						<option value="parcial">Parcial</option>
						<option value="completa">Completa</option>
						</select>
                    </div>
				</div>
				<br><br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarMoraTarjetas" name="btnBuscarMoraTarjetas" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="recaudaciones.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
                            title: 'Cobranzas Unificado'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMoraTarjetas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarRecaudaciones.php",
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
                            title: 'Cobranzas Unificado'
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

