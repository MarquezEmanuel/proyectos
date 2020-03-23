<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

session_start();
//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function noSAV() {
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual." 00:00:00";
    $actualfinal = $actualfinal." 23:59:59";
    
    
    $sql = "SELECT * FROM [3pagaresCancelados] WHERE codigoSucursalDeposito = {$_SESSION['sucursal']}";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
			while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombreCliente']);
			$fechaLiquidacion = isset($row['fechaLiquidacion']) ? $row['fechaLiquidacion']->format('d/m/Y') : "";
			$fechaVencimiento = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
            $html = $html . "
            <tr>
                <td>{$row['codigoCliente']}</td>
                <td>{$nombre}</td>
                <td>{$row['producto']}</td>
                <td>{$row['numeroPagare']}</td>
                <td>{$fechaLiquidacion}</td>
                <td>{$fechaVencimiento}</td>
                <td>{$row['descripcion']}</td>
                <td>{$row['nombreSucursalDeposito']}</td>
            </tr>";
        }
		}
        else{
            $html = $html."<tr> <td COLSPAN=8>No hay pagares cancelados en SAV en la fecha</td></tr>";
        }
    } else {
        $html = $html."<tr> <td COLSPAN=8>No hay pagares cancelados en SAV en la fecha</td></tr>";
    }
    
    
    return $html;
}

require_once './menuSucursal.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Pagare Cancelados en SAV</u></h3>
                        </div>
                        <br>
                        <a href="buscarPagareCancelados.php"><input type="button" class="btn btn-dark" id="" name="" value="Busqueda Avanzada"></a>
                        &nbsp;
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                                <table id='diariosPagare' class='table table-striped table-bordered' border="3" style="width: 100%">
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Codigo de Cliente</th>
                                            <th>Nombre de Cliente</th>
                                            <th>Producto</th>
                                            <th>Pagare</th>
                                            <th>Fecha Liquidacion</th>
                                            <th>Fecha de Vencimiento</th>
                                            <th>Descripcion</th>
                                            <th>Nombre Sucursal Deposito</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    echo noSAV();
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/buscarPagare.js"></script>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
</html>

