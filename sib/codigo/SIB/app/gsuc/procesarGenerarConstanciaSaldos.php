<?php

//agrega libreria tcpdf
require_once '../../lib/tcpdf-6.3.1/tcpdf.php';
require_once '../conf/Constants.php';
include_once '../conf/BDConexion.php';

session_start();
$usuario = trim($_SESSION['legajo']);
// date_default_timezone_set('America/Argentina/Buenos_Aires');
// $month = date('m', strtotime('-1 month'));
      // $day = date("d", mktime(0,0,0, $month+1, 0, date('Y')));
	  // if($month == 12){
		  // $fecha = date('d/m/Y', mktime(0,0,0, $month, $day, date('Y', strtotime('-1 year'))));
		  // $fecha2 = date('d/m/y', mktime(0,0,0, $month, $day, date('Y', strtotime('-1 year'))));
	  // } else{
		  // $fecha = date('d/m/Y', mktime(0,0,0, $month, $day, date('Y')));
		  // $fecha2 = date('d/m/y', mktime(0,0,0, $month, $day, date('Y')));
	  // }	  
	  // $fecha2 = str_replace("/","",$fecha2);
$fecha2 = $_POST['fechaInicio'];
$fecha3 = $_POST['fechaFin'];
$fecha = substr($fecha2,0,2) . "/" . substr($fecha2,2,2) . "/20" . substr($fecha2,4,2);
$enviados = 0;
if (isset($_POST['cbCorreos'])) {
    $correos = $_POST['cbCorreos'];
    foreach ($correos as $correo) {
		if($fecha3){
			$queryCorreo = "select *, convert(varchar,cast((SALDO_AYER-CREDITO + DEBITO) as money),1) AS CALCULO
			from openquery(M4000SF,'SELECT MOL.CCU_OFICI SUCURSAL,
											   MOL.CCUNUMCUE CUENTA, 
											   MOL.CCUDIGVER DIGITO, 
											   MOL.CNO_CUENT NOMBRE,
                                               MOL.CSATOTAYE SALDO_AYER, 
                                               MOL.CSATOTHOY SALDO_HOY, 
                                               (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO,
                                               (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO
                                        FROM SFB_ACMOL MOL
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''".$fecha2."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (".$correo.") AND ARE_VALOR <= (to_date(lpad(''".$fecha3."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                                     GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''".$fecha2."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))  and dcodebcre = 2 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (".$correo.") AND ARE_VALOR <= (to_date(lpad(''".$fecha3."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                                      GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN 
                                        (".$correo.") ')";
		} else{
		$queryCorreo = "select *, convert(varchar,cast((SALDO_AYER-CREDITO + DEBITO) as money),1) AS CALCULO
	from openquery(M4000SF,'SELECT MOL.CCU_OFICI SUCURSAL,
											   MOL.CCUNUMCUE CUENTA, 
											   MOL.CCUDIGVER DIGITO, 
											   MOL.CNO_CUENT NOMBRE,
                                               MOL.CSATOTAYE SALDO_AYER, 
                                               MOL.CSATOTHOY SALDO_HOY, 
                                               (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO,
                                               (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO
                                        FROM SFB_ACMOL MOL
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''".$fecha2."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (".$correo.")
                                                     GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''".$fecha2."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))  and dcodebcre = 2 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (".$correo.")
                                                      GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN 
                                        (".$correo.") ')";
		}
		$resultCorreo = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCorreo);
		if ($resultCorreo) {
			if (sqlsrv_has_rows($resultCorreo)) {
				$row = sqlsrv_fetch_array($resultCorreo, SQLSRV_FETCH_ASSOC);
					$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
					$pdf->SetMargins(20, 25, 20);
					$pdf->SetHeaderMargin(55);
					$pdf->setPrintHeader(false);
					$pdf->SetCreator('Banco Santa Cruz');
					$pdf->SetAuthor('Banco Santa Cruz');
					$pdf->SetTitle('CONSTANCIA DE SALDO');
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
					$pdf->SetFont('times', '', 14);

					$sucursal = $row['SUCURSAL'];
					$cuenta = $row['CUENTA'];
					$cuentas = $cuenta."/".$row['DIGITO'];
					$saldo = $row['CALCULO'];
					$nombre = str_replace("/", "", $row['NOMBRE']);
					$nombre = str_replace("'", "", $nombre);
					$archivo = URL_ConstanciaSaldo . "\\" . date("d_m_Y") . "_" . $cuenta . "_" . str_replace(" ", "_", $nombre) . "_".$usuario.".pdf";

					$pdf->AddPage();
					$html = '
					<img src="../../lib/img/constanciaSaldo-banco.jpg" style="height:40px; width:210px;"><br/><br/>
					<span style="font-size: 1.3em; font-weight:bold; text-align:center;">CONSTANCIA DE SALDO</span>
					<div><hr></div>
					<span style="font-size:0.9em;"><b>CUENTA CORRIENTE Sucursal: ' . $sucursal . ' Cuenta ' . $cuentas . '</b></span><br/>
					<span style="font-size:0.9em"><b>DEL SECTOR PÚBLICO NO FINANCIERO PROVINCIAL</b></span><br/>
					<span style="font-size:0.9em"><b>TITULADA: </b></span><span style="font-size:0.8em"><b>' . $nombre . '</b></span><br/>
					<span style="font-size:0.9em"><b>PRESENTA UN SALDO DE $' . $saldo . ' AL ' . $fecha . ' (S.E.U.O.)</b></span><br/><br/>
					<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
					<div style="text-align:right">
						<img src="../../lib/img/'.$usuario.'.png" style="height:110px; width:140px;">
					</div>';
					$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

					$pdf->Output($archivo, 'F');
					
					$enviados++;
			} else {
				$resultado = '<div class="alert alert-danger text-center" role="alert">No se obtuvo un mensaje predeterminado para el reporte (' . $reporte . ')</div>';
			}
		} else {
				Log::escribirError("[Error al realizar la consulta de mensaje para correos electronicos del reporte][QUERY: $queryCorreo]");
				$resultado = '<div class="alert alert-danger text-center" role="alert">Error al realizar la consulta de mensaje para el reporte</div>';
			}		
				
            }
            $resultado = '<div class="alert alert-success text-center" role="alert">Total de archivos generados correctamente: ' . $enviados . ' </div>';
            $form = '<div class="col">
                    <div class="text-center">
                        <a href="buscarConstanciaSaldos.php"><button class="btn btn-dark">Volver</button></a>
						&nbsp;
						<a href="descargarSaldos.php"><input type="button" class="btn btn-dark" value="Descargar"></a>
                    </div>
                </div>';
} else {
    $resultado = '<div class="alert alert-danger text-center" role="alert">No se recibieron los correos electronicos seleccionados</div>';
}


require_once './header.php';
?>
<div class="container">
    <div class="card-header">
        <div class="center">
            <h3 class="text-center"><u>Constancia de saldos</u></h3>
        </div>
        <div class="mb-4 mt-4" id="resultado"><?= $resultado; ?></div>
        <div class="mb-4 mt-4">
            <?= $form ?>
        </div>
    </div>
</div>