<?php
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

function movimientosSinDepositantes() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(montoOrigen as money),1) AS montoOrigen2, convert(varchar,cast(montoPesos as money),1) AS montoPesos2 FROM [3movimientoSinDepositantes] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "
                    <tr>
                    <td>{$row['codigoSucursal']}</td>
                    <td>{$row['tipo']}</td>
                    <td>{$row['codigoUsuario']}</td>    
                    <td>{$row['codigoMoneda']}</td>
                    <td>{$row['montoPesos2']}</td>
                    <td class='text-center' title='Ir a ver detalles de la Reversa'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMovimientos2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=6>No hay reportes de movimientos sin depositantes en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=6>No hay reportes de movimientos sin depositantes en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Movimientos Sin Depositantes</u></h3>
                        </div>
                        <br>
                        <a href="buscarMovimientosSinDepositantes.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        <a href="rankingMovimientosSinDepositantes.php"><input type="button" class="btn btn-dark" id="" name="" value="Ranking"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        &nbsp;
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosMovimientos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 18%'/>
                                    <col style='width: 18%'/>
                                    <col style='width: 18%'/>
                                    <col style='width: 18%'/>
                                    <col style='width: 18%'/>
                                    <col style='width: 10%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>Tipo de Movimiento</th>
                                        <th>Usuario</th>
                                        <th>Codigo de Moneda</th>
                                        <th>Monto en Pesos</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo movimientosSinDepositantes();
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
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarMovimientos.js"></script>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/diarios.js"></script>
</html>

