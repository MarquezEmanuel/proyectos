<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
//Clientes con prestamos y tarjetas

function clientesPrestamos() {
    $html = $html . '<tr><th><a href="clientesPrestamos.php" class="text-dark"><font size=4>Clientes con prestamos y tarjetas asociadas</font></a></th></tr>';
    return $html;
}

//PMCERD

function PMCRED() {
	$sql = "select count(*) cantidad
from openquery(M4000SF, 'SELECT AML.ANO_PROCE ARCHIVO,
                                                      TO_CHAR ( TO_DATE ( LPAD(AML.AFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
                                                      AML.ANU_LOTE LOTE,
                                                      AML.TNUDOCTRA NROLIQUIDACION,
                                                      AML.ACU_OFICI SUCURSAL,
                                                      AML.ACUNUMCUE CUENTA,
                                                      AML.ACUDIGVER DIGITO,
                                                      SUBSTR(AML.ATA_ERROR, 1, 4) ERROR,
                                                      MME.DNOMENSIS DESCRIPCION,
                                                      AML.TVA_MOVIM MONTO
                                        FROM SFB_AAAML AML
										INNER JOIN SFB_DAMCP MCP ON MCP.DRE_DAN1 <= AML.ARE_TRANS AND MCP.DCO_SUCUR4 = 9999
                                        INNER JOIN SFB_DAMME MME ON MME.DCOMENSIS = SUBSTR(AML.ATA_ERROR, 1, 4)
                                        WHERE (AML.ANO_PROCE = ''PmcredM.txt'' OR AML.ANO_PROCE = ''pmcreda.txt'' OR AML.ANO_PROCE = ''pmcredv.txt'') AND 
                                               AML.TCO_ERROR = ''ERR'' AND 
                                               AML.ACOESTREG = 9 
                                        ORDER BY ANO_PROCE') ERR
LEFT JOIN (select * from openquery([BSCBASES3], 'SELECT LIQ.ArgenLiquiNume NROLIQUIDACION,
                                                                                              LIQ.ArgenComerNume NROCOMERCIO,
                                                                                              COM.argencomerfantanombre NOMBRECOMERCIO,
                                                                                              COM.argencomercuitnume CUIT,
                                                                                              LIQ.AcreditaFecha FECHAACREDITACION
                                                                                 FROM [SmartOpen].[dbo].[ArgenLiqui] LIQ
                                                                                 INNER JOIN [SmartOpen].[dbo].[ArgenComer] COM ON COM.argencomernume = LIQ.ArgenComerNume
                                                                                 WHERE AcreditaFecha >= GETDATE()-15')) LIQ ON LIQ.NROLIQUIDACION = ERR.NROLIQUIDACION AND CAST(FECHAACREDITACION AS DATE) = CAST(FECHA AS DATE)
";
	
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad == 0) {
            $html = $html . '<tr><th><a href="buscarPMCRED.php" class="text-dark"><font size=4>Rechazos PMCRED</font></a></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="buscarPMCRED.php" class="text-dark"><font size=4>Rechazos PMCRED</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"> </font></a>&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<font size=6 class="text-danger" >' . $cantidad . '</font></th></tr>';
        }
    } else {
        $html = "$sql";
    }
    return $html;
}

//Clientes con prestamos y tarjetas

function duplicados() {
	$sql = "select count(*) cantidad from openquery([BSCBASES3], 'SELECT ''CREDENCIAL'' marca,
                                                                          AJU.CredenAjusNume nroAjuste,
                                                                          AJU.Cuenta cuenta, 
                                                                           SOC.plasti_nombre nombre,
                                                                          SOC.CUIT cuit,
                                                                          AJU.ConcepCodi codigo, 
                                                                           AJU.Impor importe,
                                                                          AJU.AjusFecha fecha
                                                              FROM [SmartOpen].[dbo].[CredenHistoAjus] AJU
                                                              INNER JOIN (SELECT Cuenta, 
                                                                                              ConcepCodi, 
                                                                                              Impor,
                                                                                              ROW_NUMBER() over (partition by Cuenta, ConcepCodi, Impor order by AjusFecha desc) orden
                                                                                 FROM [SmartOpen].[dbo].[CredenHistoAjus]
                                                                                 WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))) REP 
                                                                                 ON REP.Cuenta = AJU.Cuenta AND
                                                                                    REP.ConcepCodi = AJU.ConcepCodi AND
                                                                                    REP.Impor = AJU.Impor AND
                                                                                    REP.orden >= 2
                                                              INNER JOIN [SmartOpen].[dbo].[CredenSocios] SOC ON SOC.cuenta_nume = AJU.Cuenta
                                                              WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))
                                                              UNION ALL
                                                              SELECT ''VISA'' marca,
                                                                          AJU.VisaAjusNume nroAjuste,
                                                                          AJU.Cuenta cuenta,
                                                                          SOC.CuentaDeno nombre,
                                                                          REPLACE(LTRIM(REPLACE(REPLACE(SOC.CuitNume,''-'',''''),''0'','' '')),'' '',''0'') cuit,
                                                                          AJU.ConcepCodi codigo,
                                                                          AJU.Impor importe,
                                                                          AJU.AjusFecha fecha
                                                              FROM [SmartOpen].[dbo].[VisaHistoAjus] AJU
                                                              INNER JOIN (SELECT Cuenta,
                                                                                              ConcepCodi,
                                                                                              Impor,
                                                                                              ROW_NUMBER() over (partition by Cuenta, ConcepCodi, Impor order by AjusFecha desc) orden
                                                                                   FROM [SmartOpen].[dbo].[VisaHistoAjus]
                                                                                   WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))) REP
                                                                                   ON REP.Cuenta = AJU.Cuenta AND
                                                                                    REP.ConcepCodi = AJU.ConcepCodi AND
                                                                                    REP.Impor = AJU.Impor AND
                                                                                    REP.orden >= 2
                                                              INNER JOIN [SmartOpen].[dbo].[VisaSocios] SOC ON SOC.Cuenta = AJU.Cuenta
                                                              WHERE AjusFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)) AND AjusFecha <=  DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))')
";
	
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad == 0) {
            $html = $html . '<tr><th><a class="text-dark"><font size=4>Ajustes Duplicados</font></a></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="duplicados.php" class="text-dark"><font size=4>Ajustes Duplicados</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"> </font></a>&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<font size=6 class="text-danger" >' . $cantidad . '</font></th></tr>';
        }
    } else {
        $html = "$sql";
    }
    return $html;
}

//Padron

function padron() {
    $html = $html . '<tr><th><a href="padron.php" class="text-dark"><font size=4>Padron</font></a></th></tr>';
    return $html;
}

//Saldos a favor

function saldos() {
    $html = $html . '<tr><th><a href="saldos.php" class="text-dark"><font size=4>Saldos a favor</font></a></th></tr>';
    return $html;
}

//Reintegro sin ajuste

function reintegro() {
	$sql = "select count(*) cantidad from [7reintegroSinAjuste]";
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
	if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad == 0) {
            $html = $html . '<tr><th><a href="reintegro.php" class="text-dark"><font size=4>Reintegros sin Ajuste</font></a></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="reintegro.php" class="text-dark"><font size=4>Reintegros sin Ajuste</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"> </font></a>&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<font size=6 class="text-danger" >' . $cantidad . '</font></th></tr>';
        }
    } else {
        $html = "$sql";
    }
    return $html;
}


//Ajustes sin reintegro

function ajustes() {
	$sql = "select count(*) cantidad from [7ajusteSinReintegro]";
	$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
	if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad == 0) {
            $html = $html . '<tr><th><a href="ajustes.php" class="text-dark"><font size=4>Ajustes sin Reintegro</font></a></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="ajustes.php" class="text-dark"><font size=4>Ajustes sin Reintegro</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"> </font></a>&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<font size=6 class="text-danger" >' . $cantidad . '</font></th></tr>';
        }
    } else {
        $html = "$sql";
    }
    return $html;
}

//CONSUMOS

function consumos(){
	$html = $html . '<tr><th><a href="consumos.php" class="text-dark"><font size=4>Consumos</font></a></th></tr>';
    return $html;
}

//RECAUDACIONES SFB

function recaudaciones(){
	$hoy = date("d/m/y");
	$hoy = str_replace("/","",$hoy);
	$sql = "select count(ENVIO_SMARTOPEN) cantidad from openquery(M4000SF,'
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
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $filas["cantidad"];
        } else {
            $cantidad = 0;
        }
        if ($cantidad == 0) {
            $html = $html . '<tr><th><a href="recaudaciones.php" class="text-dark"><font size=4>Recaudaciones SFB</font></a></th></tr>';
        } else {
            $html = $html . '<tr><th><a href="recaudaciones.php" class="text-dark"><font size=4>Recaudaciones SFB</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"> </font></a>&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<font size=6 class="text-danger" >' . $cantidad . '</font></th></tr>';
        }
    } else {
        $html = "$sql";
    }
    return $html;
}

//MAESTRO DE CUENTAS

function cuentas(){
	$html = $html . '<tr><th><a href="cuentas.php" class="text-dark"><font size=4>Maestro de Cuentas</font></a></th></tr>';
    return $html;
}

//MAESTRO DE TARJETAS

function tarjetas(){
	$html = $html . '<tr><th><a href="tarjetas.php" class="text-dark"><font size=4>Maestro de Tarjetas</font></a></th></tr>';
    return $html;
}

//CONTROL SOBRE REGIMEN

function regimen(){
	$html = $html . '<tr><th><a href="regimen.php" class="text-dark"><font size=4>Control Regimen TC</font></a></th></tr>';
    return $html;
}

$_SESSION['buscar'] = null;

require_once './header.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <br>
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido1" class="col-lg-12 contenido1">
                        <div class="form-row align-items-center mx-auto">
                            <table class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style="width: 100%"/>
                                </colgroup>
                                <thead style='background-color:#1d6091;color:white;'>
                                    <tr>
                                        <th>Nombre de Reporte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                         
									echo PMCRED();
									echo duplicados();
									echo padron();
									echo reintegro();
									echo ajustes();
									echo recaudaciones();
									echo clientesPrestamos();
									echo saldos();
									echo consumos();
									echo cuentas();
									echo tarjetas();
									echo regimen();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>