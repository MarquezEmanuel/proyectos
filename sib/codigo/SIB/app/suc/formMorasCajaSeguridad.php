<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuSucursal.php';

session_start();

$_SESSION['buscar'] = null;

function morasCajaSeguridad() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(importeCuota as money),1) AS importeCuota2,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [3morasCajaSeguridad] WHERE sucursalCuentaDA = {$_SESSION['sucursal']} AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $tipoCuentaDA = utf8_encode($row['tipoCuentaDA']);
                $estado = utf8_encode($row['estado']);
                $html = $html . "
                    <tr>
                    <td>{$row['importeCuota2']}</td>    
                    <td>{$row['cantidadCuotas']}</td>
                    <td>{$row['saldo2']}</td>
                    <td>{$estado}</td>
                    <td class='text-center' title='Ir a ver detalles de Moras '>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMorasCajaSeguridad2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=6>No hay moras en caja de seguridad en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=6>No hay moras en caja de seguridad en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Moras en cajas de seguridad</u></h3>
                        </div>
                        <br>
                        <a href="formBuscarMorasCajaSeguridad.php"><input type="button" class="btn btn-dark" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosMorasCajaSeguridad' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 21%'/>
                                    <col style='width: 21%'/>
                                    <col style='width: 21%'/>
                                    <col style='width: 21%'/>
                                    <col style='width: 13%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Importe total de cuotas</th>
                                        <th>Cantidad de Cuotas</th>
                                        <th>Saldo SFB</th>
                                        <th>Estado</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo morasCajaSeguridad();
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
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/diarios.js"></script>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarMorasCajaSeguridad.js"></script>
</html>

