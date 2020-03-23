<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$cuenta = $_POST['cuenta'];
$tipo = $_POST['tipo'];
$fecha = $_POST['fecha'];
$transaccion = $_POST['cobranza'];

$fecha = date("d/m/y", strtotime($fecha));
$fecha = str_replace("/","",$fecha);

if($tipo[0] == 'informada'){
	$tip = "ENVIO_SMARTOPEN != 'Sin Enviar'";
} else{
	$tip = "ENVIO_SMARTOPEN = 'Sin Enviar'";
}
if($transaccion[0] == 'parcial'){
	$trans = "COBRANZA = 'PARCIAL' AND ";
}else{
	if($transaccion[0] == 'completa'){
		$trans = "COBRANZA = 'TOTAL' AND ";
	} else{
		$trans = "";
	}
}
$query = "select * from openquery(M4000SF,'
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
                                                                                 AND RREINFSMO = (to_date(lpad( ".$fecha." ,6,''0''),''ddmmrrrr'')- TO_DATE(''010157'',''ddmmrrrr'')) 
                                                                                 
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
                                                AND RREINFSMO = (to_date(lpad( ".$fecha." ,6,''0''),''ddmmrrrr'')- TO_DATE(''010157'',''ddmmrrrr''))                                                                            
                                                                                 ') where ".$trans."".$tip."
	";
  if (isset($sucursal) && $sucursal != null) {
    $query = $query . " AND SUC = " . $sucursal;
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND CTA = " . $cuenta;
	}
} else {
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND CTA = " . $cuenta;
	}
}
//VISA CONSULTA



// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);


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
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para los filtros ingresados</div>';
    }
} 


echo $print;


