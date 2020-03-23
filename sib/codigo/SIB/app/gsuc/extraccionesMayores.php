<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 


function extraccionesMayores() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [3mayores15] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombre = utf8_encode($row['nombre']);
                $html = $html . "
                    <tr>
                    <td>{$row['cuenta']}</td>
                    <td>{$row['sucursal']}</td>
                    <td>{$row['monto2']}</td>    
                    <td>{$row['nroTarDebHab']}</td>
                    <td>";
                if ($row['tarjetaSAV']) {
                    $html = $html . "SI";
                } else {
                    $html = $html . "NO";
                }
                $html = $html . "</td>
                    <td class='text-center' title='Ir a ver detalles de extracciones'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesExtracciones2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=6>No hay extracciones mayores a $20.000 en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=6>No hay extracciones mayores a $20.000 en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Extracciones por caja</u></h3>
                        </div>
                        <br>
                        <a href="buscarExtracciones.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        <a href="formCorreoExtracciones.php"><input type="button" class="btn btn-dark" id="" name="" value="Enviar correo"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosExtraccionesMayores' class='table table-striped table-bordered' border="3" style="width: 100%">
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
                                        <th>Numero de cuenta</th>
                                        <th>Sucursal</th>
                                        <th>Monto</th>
                                        <th>Tarjetas habilitadas</th>
                                        <th>Tiene SAV</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo extraccionesMayores();
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
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/buscarExtracciones.js"></script>
<script type="text/javascript" charset="utf8" src="../..//lib/JQuery/diarios.js"></script>
</html>

