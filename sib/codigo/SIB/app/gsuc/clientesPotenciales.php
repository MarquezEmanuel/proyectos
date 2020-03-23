<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function clientesPotenciales() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "SELECT * FROM [3clientesPotenciales] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $fechaAlta = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
                $nombreCliente = utf8_encode($row['nombreCliente']);
                $html = $html . "
                <tr>
                    <td>{$row['usuario']}</td>
					<td>{$nombreCliente}</td>
					<td>{$row['nroCliente']}</td>
					<td>{$row['sucursal']}</td>
					<td>{$row['documento']}</td>
					<td>CLIENTE POTENCIAL</td>
					<td>{$fechaAlta}</td>
                </tr>";
            }
        } else {
            $html = $html . "<tr> <td COLSPAN=7>No hay clientes potenciales en la fecha</td></tr>";
        }
    } else {
        $html = $html . "<tr> <td COLSPAN=7>No hay clientes potenciales en la fecha</td></tr>";
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
                            <h3 class="text-center"><u>Clientes potenciales</u></h3>
                        </div>
                        <br>
                        <a href="buscarClientesPotenciales.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosClientesPotenciales' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Nombre de Cliente</th>
                                        <th>Numero de Cliente</th>
                                        <th>Sucursal</th>
										<th>Documento</th>
										<th>Estado</th>
                                        <th>Fecha Alta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo clientesPotenciales();
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/buscarClientesPotenciales.js"></script>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>


