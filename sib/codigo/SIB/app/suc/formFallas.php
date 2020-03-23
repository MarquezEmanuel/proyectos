<?php

require_once './menuSucursal.php';

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

function fallas() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(montoTransaccion as money),1) AS monto2 FROM [3fallas] WHERE sucursalCuenta = {$_SESSION['sucursal']} AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "
                    <tr>
                    <td>{$row['usuario']}</td>
                    <td>{$row['supervisor']}</td>    
                    <td>{$row['nombreTransaccion']}</td>
                    <td>{$row['monto2']}</td>
                    <td class='text-center' title='Ir a ver detalles de falla'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesFallas2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=5>No hay fallas de caja en la fecha</td></tr>";
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar fallas de caja de la fecha][QUERY: $sql]");
        $html = $html . "<tr> <td COLSPAN=5>No hay fallas de caja en la fecha</td></tr>";
    }
    return $html;
}


?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Fallas de caja</u></h3>
                        </div>
                        <br>
                        <a href="formBuscarFallas.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id="tableFallasRG" class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 8%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Supervisor</th>
                                        <th>Nombre Transaccion</th>
                                        <th>Monto</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo fallas();
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
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarFallasRG.js"></script>
</html>