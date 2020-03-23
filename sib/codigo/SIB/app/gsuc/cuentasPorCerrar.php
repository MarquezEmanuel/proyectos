<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;
//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function cuentasPorCerrar() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual." 00:00:00";
    $actualfinal = $actualfinal." 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [3ACMOL] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreCliente = utf8_encode($row['nombreCliente']);
                $html = $html . "
                    <tr>
                    <td>{$row['sucursal']}</td>
                    <td>{$row['numeroCliente']}</td>
                    <td>{$nombreCliente}</td>    
                    <td>{$row['definicionEstado']}</td>
                    <td>{$row['cuenta']}</td>
                    <td>{$row['saldo2']}</td>
                    <td class='text-center' title='Ir a ver detalles de las Cuentas'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCuentasPorCerrar2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=7>No hay cuentas por cerrar saldo deudor en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=7>No hay cuentas por cerrar saldo deudor en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Cuentas por cerrar saldo deudor</u></h3>
                        </div>
                        <br>
                        <a href="buscarCuentasPorCerrar.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosCuentasPorCerrar' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 10%'/>
                                    <col style='width: 15%'/>
                                    <col style='width: 20%'/>
                                    <col style='width: 15%'/>
                                    <col style='width: 15%'/>
                                    <col style='width: 15%'/>
                                    <col style='width: 10%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>Numero de Cliente</th>
                                        <th>Nombre de Cliente</th>
                                        <th>Estado</th>
                                        <th>Cuenta</th>
                                        <th>Saldo</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo cuentasPorCerrar();
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/buscarCuentasPorCerrar.js"></script>
</html>

