<?php

require_once './menuSucursal.php';

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

function reversas() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(montoTransaccion as money),1) AS montoTransaccion2 FROM [3reversas] WHERE sucursalCuenta = {$_SESSION['sucursal']} AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $fechaTransaccion = isset($row['fechaTransaccion']) ? $row['fechaTransaccion']->format('d/m/Y') : "";
                $html = $html . "
                    <tr>
                    <td>{$row['usuario']}</td>
                    <td>{$fechaTransaccion}</td>    
                    <td>{$row['montoTransaccion2']}</td>
                    <td>{$row['nombreTransaccion']}</td>
                    <td class='text-center' title='Ir a ver detalles de la Reversa'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesReversas2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=5>No hay reportes de reversas en la fecha</td></tr>";
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar reversas de la fecha][QUERY: $sql]");
        $html = $html . "<tr> <td COLSPAN=5>No hay reportes de reversas en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Reversas</u></h3>
                        </div>
                        <br>
                        <a href="formBuscarReversas.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id="tableReversasRG" class='table table-striped table-bordered' border="3" style="width: 100%">
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
                                        <th>Fecha Transaccion</th>
                                        <th>Monto Transaccion</th>
                                        <th>Nombre Transaccion</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo reversas();
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
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarReversas.js"></script>
</html>

