<?php
require_once './menuSucursal.php';

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

function extraccionesMayores() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual." 00:00:00";
    $actualfinal = $actualfinal." 23:59:59";
    $sql = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [3mayores15] WHERE sucursalPago = {$_SESSION['sucursal']} AND fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$nombre = utf8_encode($row['nombre']);
                $html = $html. "
                    <tr>
                    <td>{$row['cuenta']}</td>
                    <td>{$row['monto2']}</td>    
                    <td>{$row['nroTarDebHab']}</td>
                    <td>";
                    if($row['tarjetaSAV']){
                        $html = $html. "SI";
                    }else{
                        $html = $html. "NO";
                    }
                    $html = $html. "</td>
                    <td class='text-center' title='Ir a ver detalles de extracciones'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesExtracciones2' name='{$row['id']}' width='18' height='18' > 
                    </button>
                    </td>
                    </tr>";
            } 
        }
        else{
            $html = $html."<tr> <td COLSPAN=5>No hay extracciones menores a $20.000 en la fecha</td></tr>";
        }
    } else {
        $log = new Log();
        $log->writeLine("[Error al consultar extracciones de la fecha][QUERY: $sql]");
        $html = $html."<tr> <td COLSPAN=5>No hay extracciones menores a $20.000 en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Extracciones por caja</u></h3>
                        </div>
                        <br>
                        <a href="formBuscarExtracciones.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                                <table id="tableExtraccionesPorCajaRG" class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <colgroup>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 23%'/>
                                    <col style='width: 8%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Numero de cuenta</th>
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
</html>

