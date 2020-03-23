<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;
//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function saldos() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = date("ymd");
	$primero = date('ymd', strtotime('-7 days'));
    $sql = "select TCDE TIPOTRAN, TFROM CTADESDE, TTO CTAHACIA, TOACCT NROCTAHACIA, FROMACCT NROCTADESDE, PANCARD TARJETA, TRANDAT FECHA, HORA,
            case 
                  when typcl_cbol = '00' then '25'
                  else typcl_cbol                                                  
            end CHEQUES
	from [BSCBASES4].[TRXLINK].[dbo].[CHEQUERAS]
	WHERE CONVERT(datetime,RTRIM(LTRIM(TRANDAT)), 112) BETWEEN CONVERT(datetime,RIGHT('000000'+rtrim(ltrim('$primero')),6), 112) 
	AND CONVERT(datetime,RIGHT('000000'+rtrim(ltrim('$actual')),6), 112)";

    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$cuenta = $row['NROCTAHACIA'];
				$query = "select CCU_OFICI,CCUNUMCUE,CCUDIGVER,CNO_COMER,CNO_CUENT, SCO_IDENT from openquery(M4000SF,'select CCU_OFICI,CCUNUMCUE,CCUDIGVER,CNO_COMER,CNO_CUENT,SCO_IDENT from sfb_acmol WHERE 
				(LPAD(CCU_OFICI, 2, ''0'')||LPAD(CCUNUMCUE, 6, ''0'')||CCUDIGVER) IN ($cuenta)')";
				$result2 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
				$row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
				$denominacion = utf8_encode($row2['CNO_COMER']);
				$cliente = utf8_encode($row2['CNO_CUENT']);
                $html = $html . "
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
					<td>{$row2['SCO_IDENT']}</td>
					<td>{$row2['CCU_OFICI']}</td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=10>No hay altas de chequeras en los ultimos 7 dias</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=10>No hay altas de chequeras en los ultimos 7 dias</td></tr>";
    }
    return $html;
}

require_once './header.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Altas de Chequeras de 7 dias</u></h3>
                        </div>
                        <br>
                        <a href="buscarChequeras.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosSaldos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Trans</th>
                                        <th>Cta Desde</th>
                                        <th>Cta Hacia</th>
                                        <th>NroCta Desde</th>
										<th>NroCta Hasta</th>
                                        <th>Tarjeta</th>
										<th>Fecha</th>
										<th style='display:none;'>Hora</th>
										<th>Cheques</th>
										<th>Denominacion</th>
										<th>Cliente</th>
										<th>Sucursal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo saldos();
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
<script>
$(document).ready(function () {
                $('#diariosSaldos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 500,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Altas de chequeras'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
   
	});
</script>
</html>



