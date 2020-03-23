<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
//Cobro no aplicado

function cobroNoAplicado() {
    $sql = "SELECT TOP 1 fechaActualizacion from [4cobroNoAplicado] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="cobroNoAplicado.php" class="text-dark"><font size=4>Cobros No Aplicados</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Cobranzas TC

function cobranzasTC() {
    $sql = "SELECT TOP 1 fechaActualizacion FROM [4cobranzasTC] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="cobranzasTC.php" class="text-dark"><font size=4>Cobranzas TC</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Mora prestamos

function moraPrestamos() {
    $sql = "SELECT TOP 1 fechaActualizacion FROM [4moraPrestamos] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="moraPrestamos.php" class="text-dark"><font size=4>Mora en Prestamos</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Mora en Tarjetas

function moraTarjetas() {
    $sql = "SELECT TOP 1 fechaActualizacion FROM [4moraTarjetas] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="moraTarjetas.php" class="text-dark"><font size=4>Mora en Tarjetas</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Reporte unifacado recuperacion crediticia

function unificado() {
    $sql = "SELECT TOP 1 fechaActualizacion FROM [4recuperacionCrediticia] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="unificado.php" class="text-dark"><font size=4>Integrador de Recuperacion Crediticia</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Cuentas por cerrar saldo deudor

function saldoDeudor() {
    $sql = "SELECT TOP 1 fechaActualizacion FROM [3ACMOL] ORDER BY fechaActualizacion DESC";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="saldoDeudor.php" class="text-dark"><font size=4>Cuentas por cerrar saldo deudor</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Cheques cobrados por morosos

function chequesMorosos() {
    $sql = "SELECT TOP 1 fechaActualizacion FROM [5chequesCobradosMorosos] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="chequesMorosos.php" class="text-dark"><font size=4>Cheques cobrados por morosos</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//Cuentas correnties

function cuentasCorrientes() {
    $sql = "SELECT TOP 1 fechaActualizacion FROM [4cuentasCorrientes] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="cuentasCorrientes.php" class="text-dark"><font size=4>Cuentas Corrientes con sobregiro</font></a></th><th><font size=4>' . $fecha . '</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("d/m/Y");
//Refinanciaciones

function refinanciaciones() {
	global $actual;
    $html = $html . '<tr><th><a href="refinanciaciones.php" class="text-dark"><font size=4>Refinanciaciones</font></a></th><th><font size=4>'. $actual .'</font></th></tr>';
    return $html;
}

//Inventario de pagos  agencias externas

function inventarioPagos() {
	global $actual;
    $html = $html . '<tr><th><a href="inventarioPagos.php" class="text-dark"><font size=4>Inventario de operaciones a agencias externas</font></a></th><th><font size=4>'. $actual .'</font></th></tr>';
    return $html;
}

//Inventario operaciones agencias externas

function inventarioOperaciones() {
	global $actual;
    $html = $html . '<tr><th><a href="inventarioOperaciones.php" class="text-dark"><font size=4>Inventario de pagos de agencias externas</font></a></th><th><font size=4>'. $actual .'</font></th></tr>';
    return $html;
}

//Inventario operaciones agencias externas

function cuentas153() {
	global $actual;
    $html = $html . '<tr><th><a href="cuentas153.php" class="text-dark"><font size=4>Cuentas corrientes 153 recupero</font></a></th><th><font size=4>'. $actual .'</font></th></tr>';
    return $html;
}

//Mora comercial

function moraComercial() {
	global $actual;
    $html = $html . '<tr><th><a href="moraComercial.php" class="text-dark"><font size=4>Mora Comercial</font></a></th><th><font size=4>'. $actual .'</font></th></tr>';
    return $html;
}

//Prestamos 

function prestamos() {
	global $actual;
    $html = $html . '<tr><th><a href="prestamos.php" class="text-dark"><font size=4>Clientes Con Tarjetas y Prestamos</font></a></th><th><font size=4>'. $actual .'</font></th></tr>';
    return $html;
}

//correo 

function correo() {
	$querySolicitudes = "select COUNT(*) cantidad
from [bd_sib].[dbo].[recuperacionCrediticia] rec
inner join (select DISTINCT codigoCliente, correo 
                    from [bd_sib].[dbo].[correosElectronicos]) cor on cor.codigoCliente = RIGHT('000000000000' + rec.numeroCliente, 13)
where rec.marca is not null";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
        } else {
			$cantidad = 0;
		}
		$html = $html . '<tr><th><a href="correo.php" class="text-dark"><font size=4>Correo clientes en mora</font></a></th><th><font size=4>'. $cantidad .'</font></th></tr>';
    } else {
        Log::escribirError("[Error al realizar la consulta de Plazos Vencidos en SAV][QUERY: $querySolicitudes]");
    }
    return $html;
}

//Inventario lineas no propias

function inventarioNoPropias() {
	$sql = "SELECT TOP 1 fechaActualizacion FROM [4lineasNoPropias] ORDER BY fechaActualizacion";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            $filas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $fecha = isset($filas['fechaActualizacion']) ? $filas['fechaActualizacion']->format('d/m/Y') : "";
             $html = $html . '<tr><th><a href="inventarioNoPropias.php" class="text-dark"><font size=4>Inventario de lineas no propias</font></a></th><th><font size=4>'. $fecha .'</font></th></tr>';
        } 
    } else {
        $html = "$sql";
    }
    return $html;
}

//PMDEB

function pmdeb(){
	global $actual;
    $html = $html . '<tr><th><a href="pmdeb.php" class="text-dark"><font size=4>Carga PMDEB</font></a></th><th><font size=4>'. $actual .'</font></th></tr>';
    return $html;
}

$_SESSION['buscar'] = null;

require_once './header.php';
?>

<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <br>
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido1" class="col-lg-12 contenido1">
                        <div class="form-row align-items-center mx-auto">
                            <table class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style="width: 70%"/>
                                    <col style="width: 30%"/>
                                </colgroup>
                                <thead style='background-color:#07385c;color:white;'>
                                    <tr>
                                        <th>Nombre de Reporte</th>
                                        <th>Fecha Ultima Actualizacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo cobroNoAplicado();
                                    echo cobranzasTC();
                                    echo moraPrestamos();
                                    echo moraTarjetas();
                                    echo unificado();
									echo saldoDeudor();
									echo chequesMorosos();
									echo cuentasCorrientes();
									echo refinanciaciones();
									echo inventarioPagos();
									echo inventarioOperaciones();
									echo cuentas153();
									echo moraComercial();
									echo prestamos();
									//echo correo();
									echo inventarioNoPropias();
									echo pmdeb();
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
</html>