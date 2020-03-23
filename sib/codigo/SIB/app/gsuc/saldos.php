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
    $actual = $actualfinal = date("d-m-Y"); 
	if(date("l") == "Monday"){
		$actual = $actualfinal = date("d-m-Y",strtotime("last Saturday"));
	}
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT * FROM [3saldosSucursales] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
                $html = $html . "
                    <tr>
                    <td>{$row['numeroSucursal']}</td>
                    <td>{$row['saldoSFB']}</td>    
                    <td>{$row['saldoSCB']}</td>
                    <td>{$row['diferencias']}</td>
                    <td class='text-center' title='Ir a ver detalles de saldos'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesSaldos2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=5>No hay saldos contables en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=5>No hay saldos contables en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Saldos contables diarios</u></h3>
                        </div>
                        <br>
                        <a href="buscarSaldos.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosSaldos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 8%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>Saldo SFB</th>
                                        <th>Saldo SCB</th>
                                        <th>Diferencia</th>
                                        <th>Detalles</th>
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/buscarSaldos.js"></script>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>



