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
    $actual = date("d/m/Y", strtotime('-7 days'));
	$actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT A.*,B.[descripcion]
  FROM [BSCWF00].[DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDPAQUETES] A
  inner join [BSCWF00].[DATOS_CLIENTE_UNICO].[dbo].[SFB_SOLICITUDPAQUETESESTADO] B
  ON A.estadoId = B.id where estadoId IN (7,8)
  AND fechaMod between '{$actual}' AND '{$actualfinal}' AND sucursalId = {$_SESSION['sucursal']}";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$tipoPaquete = utf8_encode($row['subTipoPaquete']);
				$fechaAlta = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
				$fechaMod = isset($row['fechaMod']) ? $row['fechaMod']->format('d/m/Y') : "";
                $html = $html . "
                    <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['cuit']}</td>    
                    <td>{$fechaAlta}</td>
					<td>{$row['sucursalId']}</td>
					<td>{$fechaMod}</td>
					<td>{$tipoPaquete}</td>
					<td>{$row['descripcion']}</td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=7>No hay paquetes pendientes en los ultimos 7 dias</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=7>No hay paquetes pendientes en los ultimos 7 dias</td></tr>";
    }
    return $html;
}

require_once './menuSucursal.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Paquetes pendientes de 7 dias</u></h3>
                        </div>
                        <br>
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosSaldos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Solicitud Nro</th>
                                        <th>CUIT</th>
                                        <th>Fecha Alta</th>
                                        <th>Sucursal</th>
										<th>Fecha Modificacion</th>
                                        <th>Tipo Paquete</th>
										<th>Actividad</th>
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
                            title: 'Paquetes Pendientes'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
   
	});
</script>
</html>



