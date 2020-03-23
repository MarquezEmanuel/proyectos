<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuSucursal.php';

session_start();

$_SESSION['buscar'] = null;

$resultado = "";
$querySolicitudes = "SELECT * FROM plazoVencidoSAV WHERE SUCURSAL = {$_SESSION['sucursal']}";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);

if ($result) {
    if (sqlsrv_has_rows($result)) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$tipo = utf8_encode($row['TIPO']);
            $resultado = $resultado . "
                <tr>
                    <td>{$tipo}</td>
                    <td>{$row['NROINICIAL']}</td>
                    <td>{$row['FECHAINGRESO']}</td>
                    <td>{$row['FECHADESTRUCCION']}</td>
                    <td>{$row['PLAZODIAS']}</td>
                    <td class='text-center' title='Ir a ver detalles de solicitudes'>
                        <button class='btn btn-sm btn-outline-info detallesSolicitudWF' name='{$row['ID']}'> 
                            <img src='/lib/img/SHOW.png' name='' width='18' height='18' > 
                        </button>
                    </td>
                </tr>";
        }
    } else {
        $resultado = "<tr> <td COLSPAN=7>No hay Plazos Vencidos en SAV</td></tr>";
    }
} else {
    Log::escribirError("[Error al realizar la consulta de solicitudes de Plazos Vencidos en SAV][QUERY: $querySolicitudes]");
    $resultado = "<tr> <td COLSPAN=7>No se pudieron consultar los Plazos Vencidos en SAV</td></tr>";
}
?>
<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Plazo Vencido en SAV</u></h3>
                        </div>
                        <br>
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <div class="table-responsive">
                                <table id='diariosSolicitudesWF' class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Numero</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Fecha Destruccion</th>
                                            <th>Dias de Atraso</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $resultado; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/PlazoVencido.js"></script>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/diarios.js"></script>
</html>