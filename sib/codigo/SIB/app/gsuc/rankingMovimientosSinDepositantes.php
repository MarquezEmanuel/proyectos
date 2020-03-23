<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function ranking() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT codigoUsuario,count(codigoUsuario)cantidad FROM [3movimientoSinDepositantes] GROUP BY codigoUsuario ORDER BY cantidad DESC";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $cont = 1;
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                if ($cont < 3) {
                    $html = $html . "
                    <tr>
                    <td><div class='p-3 mb-2 bg-danger text-white'><font size=6>{$cont}</font></div></td>
                    <td><font size=6>{$row['codigoUsuario']}</font></td>
                    <td><font size=6>{$row['cantidad']}</font></td>
                    </tr>";
                    $cont++;
                } else {
                    if ($cont < 5) {
                        $html = $html . "
                    <tr>
                    <td><div class='p-3 mb-2 bg-warning text-dark'><font size=5>{$cont}</font></div></td>
                    <td><font size=5>{$row['codigoUsuario']}</font></td>
                    <td><font size=5>{$row['cantidad']}</font></td>
                    </tr>";
                        $cont++;
                    } else {
                        $html = $html . "
                    <tr>
                    <td><div class='p-3 mb-2 bg-success text-white'><font size=4>{$cont}</font></div></td>
                    <td><font size=4>{$row['codigoUsuario']}</font></td>
                    <td><font size=4>{$row['cantidad']}</font></td>
                    </tr>";
                        $cont++;
                    }
                }
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=5>No hay usuarios cargados</td></tr>";
        }
    } else {
        echo $sql;
        $html = $html . "<tr> <td COLSPAN=5>No hay usuarios con movimientos sin depositantes</td></tr>";
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
                            <h3 class="text-center"><u>Ranking Movimientos Sin Depositantes</u></h3>
                        </div>
                        <br>
                        <a href="buscarMovimientosSinDepositantes.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="movimientosSinDepositantes.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 33%'/>
                                    <col style='width: 33%'/>
                                    <col style='width: 33%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Posicion</th>
                                        <th>Usuario</th>
                                        <th>Cantidad de movimientos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo ranking();
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/buscarMovimientos.js"></script>
</html>

