<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function cuentaCorrentista() {
    $sql = "SELECT UNO.*,convert(varchar,cast(UNO.IMPORTE as money),1) AS IMPORTE2 FROM (select A.* from openquery(M4000SF,'SELECT DECODE (A.ACO_CONCE,2,CONCAT(CONCAT(LPAD(A.ACO_CONCE,1,0), LPAD(A.ACU_OFICI,3,0)),CONCAT(LPAD(A.ACUNUMCUE,6,0), LPAD (A.ACUDIGVER,1,0)))) CLAVE,
A.PFE_ESTAD F_PRO,
A.SCO_IDENT CODCLI,
B.AFE_SOLIC F_NEG,
A.ACO_CONCE CON_C,
A.ACU_OFICI SUC,
A.ACUNUMCUE CTA,
A.ACUDIGVER DIG,
A.PVA_CREDI IMPORTE,
A.PCU_PRODU PRODUCTO,
A.PCN_CUOTA CUOTAS,
B.PCO_APROB LEGAJO,
''PRESTAMOS''
FROM SFB_PPMAP A , SFB_PPASO B
WHERE A.PCU_PRODU in (925, 926,480, 489, 927, 497)
AND A.PCUNUMCUE = B.PCUNUMCUE
AND B.AFERELSOL = (SELECT DRE_DAN1 FROM SFB_DAMCP WHERE DCO_SUCUR4 = 9999)') A
left join(
select *,convert(money,cast(IMPORTE as money),1) AS IMPORTE2 from openquery(M4000SF,'SELECT
DECODE (ACO_CONCE,1,CONCAT(CONCAT(LPAD(ACO_CONCE,1,0), LPAD(ACU_OFICI,3,0)),CONCAT(LPAD(ACUNUMCUE,6,0), LPAD (ACUDIGVER,1,0))),
2,CONCAT(CONCAT(LPAD(ACO_CONCE,1,0), LPAD(ACU_OFICI,3,0)),CONCAT(LPAD(ACUNUMCUE,6,0), LPAD (ACUDIGVER,1,0))),
0,CONCAT(CONCAT(LPAD(ACO_CONC1,1,0), LPAD(ACU_OFIC1,3,0)),CONCAT(LPAD(ACUNUMCU1,6,0), LPAD (ACUDIGVE1,1,0)))) CLAVE,
TFE_TRANS F_PRO,
AFE_NEGOC F_NEG,
ACO_CONC1 CON_C,
ACU_OFIC1 SUC,
ACUNUMCU1 CTA,
ACUDIGVE1 DIG,
DECODE (ACOTRAATM,306,AVAMOVAT1 * -1, AVAMOVAT1) IMPORTE,
''C.AHORRO''
FROM SFB_AUALA
WHERE AFE_NEGOC IN (SELECT DFE_DAN1 FROM SFB_DAMCP WHERE DCO_SUCUR4 = 9999)
AND ACOTRAATM <> 309
AND ACOTRAATM IN (306)
AND DCOCLAUSU <> ''REVERSION''
AND VNU_ERROR = 0
AND ACOTIPTRA NOT IN (''XC'',''ZC'')
')
) b ON b.CLAVE = A.CLAVE
where b.CLAVE IS NULL) UNO
";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				if($row['LEGAJO'] == 09999){
					$legajo = "Carga Masiva";
				}else {
					$legajo = $row['LEGAJO'];
				}
                $html = $html . "
                    <tr>
                    <td>{$row['CLAVE']}</td>
					<td>{$row['CODCLI']}</td>
                    <td>{$row['F_PRO']}</td>    
                    <td>{$row['F_NEG']}</td>
                    <td>{$row['CON_C']}</td>
                    <td>{$row['SUC']}</td>
					<td>{$row['CTA']}</td>
                    <td>{$row['DIG']}</td>
					<td>{$row['IMPORTE2']}</td>
					<td>{$row['PRODUCTO']}</td>
					<td>{$row['CUOTAS']}</td>
					<td>{$legajo}</td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=12>No hay diferencias en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=12>No hay diferencias en la fecha</td></tr>";
    }
    return $html;
}

function prestamosSinLiquidar() {
    $sql = "SELECT UNO.*,convert(varchar,cast(UNO.IMPORTE as money),1) AS IMPORTE2,DOS.PLAZO FROM (select b.* from openquery(M4000SF,'SELECT DECODE (A.ACO_CONCE,2,CONCAT(CONCAT(LPAD(A.ACO_CONCE,1,0), LPAD(A.ACU_OFICI,3,0)),CONCAT(LPAD(A.ACUNUMCUE,6,0), LPAD (A.ACUDIGVER,1,0)))) CLAVE,
A.PFE_ESTAD F_PRO,
B.AFE_SOLIC F_NEG,
A.ACO_CONCE CON_C,
A.ACU_OFICI SUC,
A.ACUNUMCUE CTA,
A.ACUDIGVER DIG,
A.PVA_CREDI IMPORTE,
A.PCU_PRODU PRODUCTO,
A.PCN_CUOTA CUOTAS,
''PRESTAMOS'' TIPO
FROM SFB_PPMAP A , SFB_PPASO B
WHERE A.PCU_PRODU in (925, 926,480, 489, 927, 497)
AND A.PCUNUMCUE = B.PCUNUMCUE
AND B.AFERELSOL = (SELECT DRE_DAN1 FROM SFB_DAMCP WHERE DCO_SUCUR4 = 9999)') A
right join(
select * from openquery(M4000SF,'SELECT
DECODE (A.ACO_CONCE,1,CONCAT(CONCAT(LPAD(A.ACO_CONCE,1,0), LPAD(A.ACU_OFICI,3,0)),CONCAT(LPAD(A.ACUNUMCUE,6,0), LPAD (A.ACUDIGVER,1,0))),
2,CONCAT(CONCAT(LPAD(A.ACO_CONCE,1,0), LPAD(A.ACU_OFICI,3,0)),CONCAT(LPAD(A.ACUNUMCUE,6,0), LPAD (A.ACUDIGVER,1,0))),
0,CONCAT(CONCAT(LPAD(A.ACO_CONC1,1,0), LPAD(A.ACU_OFIC1,3,0)),CONCAT(LPAD(A.ACUNUMCU1,6,0), LPAD (A.ACUDIGVE1,1,0)))) CLAVE,
A.TFE_TRANS F_PRO,
A.AFE_NEGOC F_NEG,
A.ACO_CONC1 CON_C,
AC.SCO_IDENT CODCLI,
A.ACU_OFIC1 SUC,
A.ACUNUMCU1 CTA,
A.ACUDIGVE1 DIG,
DECODE (A.ACOTRAATM,306,A.AVAMOVAT1 * -1, A.AVAMOVAT1) IMPORTE,
''C.AHORRO'' TIPO
FROM SFB_AUALA A, SFB_ACMOL AC
WHERE A.AFE_NEGOC IN (SELECT DFE_DAN1 FROM SFB_DAMCP WHERE DCO_SUCUR4 = 9999)
AND A.ACOTRAATM <> 309
AND A.ACOTRAATM IN (306)
AND A.DCOCLAUSU <> ''REVERSION''
AND A.VNU_ERROR = 0
AND A.ACOTIPTRA NOT IN (''XC'',''ZC'')
AND A.ACU_OFIC1 = AC.ACU_OFICI 
AND A.ACUNUMCU1 = AC.ACUNUMCUE 
AND A.ACUDIGVE1 = AC.ACUDIGVER
')
) b ON b.CLAVE = A.CLAVE
where A.CLAVE IS NULL) UNO
right join (select SUBSTRING(cta,0,3) SUC,SUBSTRING(cta,3,6) CUENTA,SUBSTRING(cta,9,1) DIG,PLAZO from openquery(BSCBASES4,'select pancard td,  postdat fecha, toacct cta, amt1 importe, typcl_cbol+ctcheq plazo  from trxlink.dbo.extract where tcde=''2p'' and respby2=''01''')) DOS 
ON DOS.SUC = UNO.SUC AND DOS.CUENTA = UNO.CTA AND UNO.DIG = DOS.DIG
WHERE UNO.CLAVE IS NOT NULL
";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$producto = 0;
				$producto925 = "select * from openquery(BSCBASES4,'select NRO_TARJETA FROM [PrestamosLink].[dbo].[PROI_PRESTAMOS_LINEA1] WHERE SUC_CTA_LINK = {$row['SUC']} AND 
				NRO_CTA_LINK = {$row['CTA']} AND DIG_CTA_LINK = {$row['DIG']}')";
				$linea1 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $producto925);
				$tiene = sqlsrv_has_rows($linea1);
				if($tiene){
					$producto = 925;
				} else {
					$producto926 = "select * from openquery(BSCBASES4,'select NRO_TARJETA FROM [PrestamosLink].[dbo].[PROI_PRESTAMOS_LINEA2] WHERE SUC_CTA_LINK = {$row['SUC']} AND 
					NRO_CTA_LINK = {$row['CTA']} AND DIG_CTA_LINK = {$row['DIG']}')";
					$linea2 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $producto926);
					$tiene2 = sqlsrv_has_rows($linea2);
					if($tiene2){
						$producto = 926;
					}
				}
                $html = $html . "
                    <tr>
                    <td>{$row['CLAVE']}</td>
					<td>{$row['CODCLI']}</td>
                    <td>{$row['F_PRO']}</td>    
                    <td>{$row['F_NEG']}</td>
                    <td>{$row['CON_C']}</td>
                    <td>{$row['SUC']}</td>
					<td>{$row['CTA']}</td>
                    <td>{$row['DIG']}</td>
					<td>{$row['IMPORTE2']}</td>
					<td>{$row['PLAZO']}</td>
					<td>{$producto}</td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=11>No hay diferencias en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=11>No hay diferencias en la fecha</td></tr>";
    }
    return $html;
}

require_once './header.php';
?>
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
					<br>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <div class="center">
                            <h3 class="text-center"><u>Prestamos Sin Acreditar</u></h3>
                        </div>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosCentralCuentaCorrentista' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Clave</th>
										<th>Cod.Cliente</th>
                                        <th>F_PRO</th>
                                        <th>F_NEG</th>
                                        <th>CON_C</th>
                                        <th>Sucursal</th>
										<th>Cuenta</th>
                                        <th>Digito</th>
										<th>Importe</th>
										<th>Producto</th>
										<th>Cuotas</th>
										<th>Usuario Carga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo cuentaCorrentista();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
					<br><br>
					<div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Prestamos Sin Liquidar</u></h3>
                        </div>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='sinLiquidar' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Clave</th>
										<th>Cod.Cliente</th>
                                        <th>F_PRO</th>
                                        <th>F_NEG</th>
                                        <th>CON_C</th>
                                        <th>Sucursal</th>
										<th>Cuenta</th>
                                        <th>Digito</th>
										<th>Importe</th>
										<th>Plazo</th>
										<th>Producto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo prestamosSinLiquidar();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
</body>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
<script>
$(document).ready(function () {
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    $(document).ready(function () {
    $('#diariosCentralCuentaCorrentista').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 500,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Prestamos Sin Acreditar'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
		});
		
	$(document).ready(function () {
                $('#sinLiquidar').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 500,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'UpTime'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
   
	});
				

});
</script>
</html>

