<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX

$sucursal = $_POST['sucursal'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

if (isset($fechaInicio) && $fechaInicio != null) {
    $fechaInicio = date("ymd", strtotime($fechaInicio));
}
if (isset($fechaFin) && $fechaFin != null) {
    $fechaFin = date("ymd", strtotime($fechaFin));
}

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select TCDE TIPOTRAN, TFROM CTADESDE, TTO CTAHACIA, TOACCT NROCTAHACIA, FROMACCT NROCTADESDE, PANCARD TARJETA, TRANDAT FECHA, HORA,
            case 
                  when typcl_cbol = '00' then '25'
                  else typcl_cbol                                                  
            end CHEQUES
	from [BSCBASES4].[TRXLINK].[dbo].[CHEQUERAS]
	WHERE CONVERT(datetime,RTRIM(LTRIM(TRANDAT)), 112) BETWEEN CONVERT(datetime,RIGHT('000000'+rtrim(ltrim('$fechaInicio')),6), 112) 
	AND CONVERT(datetime,RIGHT('000000'+rtrim(ltrim('$fechaFin')),6), 112)";

if (isset($sucursal) && $sucursal != null) {
    $query = $query . " AND SUBSTRING(RTRIM(LTRIM(TOACCT)),1,2) = RIGHT('00'+rtrim(ltrim($sucursal)),2)" ;
} 
// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_canje' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Transaccion</th>
											<th>Cta Desde</th>
											<th>Cta Hacia</th>
											<th>Nro Cta Desde</th>
											<th>Nro Cta Hasta</th>
											<th>Nro Tarjeta</th>
											<th>Fecha</th>
											<th style='display:none;'>Hora</th>
											<th>Cheques</th>
											<th>Denominacion</th>
											<th>Cliente</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$cuenta = $row['NROCTAHACIA'];
			$query = "select CCU_OFICI,CCUNUMCUE,CCUDIGVER,CNO_COMER,CNO_CUENT from openquery(M4000SF,'select CCU_OFICI,CCUNUMCUE,CCUDIGVER,CNO_COMER,CNO_CUENT from sfb_acmol WHERE 
			(LPAD(CCU_OFICI, 2, ''0'')||LPAD(CCUNUMCUE, 6, ''0'')||CCUDIGVER) IN ($cuenta)')";
			$result2 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
			$row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
			$denominacion = utf8_encode($row2['CNO_COMER']);
			$cliente = utf8_encode($row2['CNO_CUENT']);
            $print = $print . "
                <tr>
                <td>{$row['TIPOTRAN']}</td>
                <td>{$row['CTADESDE']}</td>    
                <td>{$row['CTAHACIA']}</td>
                <td>{$cuenta}</td>
				<td>{$row['NROCTADESDE']}</td>
				<td>{$row['TARJETA']}</td>
				<td>{$row['FECHA']}</td>
				<td style='display:none;'>{$row['HORA']}</td>
				<td>{$row['CHEQUES']}</td>
				<td>{$denominacion}</td>
				<td>{$cliente}</td>
                </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    // OCURRIO UN ERROR 
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $print;


