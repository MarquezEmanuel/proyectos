<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$_SESSION['buscar'] = null;


function conciliaciones() {
	date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $querySolicitudes = "SELECT count(*) cantidad FROM [9conciliacionContable] WHERE fechaActualizacion between '$actual' and '$actualfinal'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
			$html = '<tr><th><a href="conciliacion.php" class="text-dark"><font size=4>Conciliacion</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
			
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Conciliacion][QUERY: $querySolicitudes]");
    }
    return $html;
}


function conciliacionesHistorico() {
	date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $querySolicitudes = "SELECT count(*) cantidad FROM [9conciliacionContable] WHERE fechaActualizacion between '$actual' and '$actualfinal' AND transaccion IS NULL AND descripcion NOT LIKE '%CRED. VS. ACRED%'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitudes);
    $html = "";
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $cantidad = $fila["cantidad"];
			if($cantidad != 0){
				$html = '<tr><th><a href="diferencias.php" class="text-danger"><font size=6>Historico de Diferencias</font></a>&nbsp;&nbsp;<img src="/lib/img/transparente.svg" width="30" height="30"></th><th class="text-danger"><font size=6>' . $cantidad . '</font></th></tr>';
			}else{
				$html = '<tr><th><a href="diferencias.php" class="text-dark"><font size=4>Historico de Diferencias</font></a></th><th><font size=4>' . $cantidad . '</font></th></tr>';
			}  
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de Conciliacion][QUERY: $querySolicitudes]");
    }
    return $html;
}

require_once './header.php';
?>

<body id="body" style="width:100%;">
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
                                    <col style="width: 85%"/>
                                    <col style="width: 15%"/>
                                </colgroup>
                                <thead style='background-color:#144c75;color:white;'>
                                    <tr>
                                        <th>Nombre de Reporte</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo conciliaciones();
                                    echo conciliacionesHistorico();
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