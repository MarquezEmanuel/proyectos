<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

require_once './menuSucursal.php';

function turnero() {

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('Y/m/d', strtotime('yesterday'));
    $fechats = strtotime($fecha);
    if (date('w', $fechats) == 0) {
        $actual = date("Y/m/d", strtotime($fecha . "- 2 days"));
    } else {
        if (date('w', $fechats) == 6) {
            $actual = date("Y/m/d", strtotime($fecha . "- 1 days"));
        } else {
            $actual = $fecha;
        }
    }
    $actualFinal = explode("/", $actual);
    $total = count($actualFinal);
    $fecha = "";
    for ($i = 0; $i < $total; ++$i) {
        $fecha = $fecha . $actualFinal[$i];
    }

    //tiempo medio de espera Rio Gallegos
	$sucursales = [01, 02, 03, 04, 05, 15, 20, 25, 30, 41, 45, 50, 55, 60, 70, 75, 85];
	$nombreSucursales = ["Rio Gallegos", "Comodoro Rivadavia", "Caleta Olivia", "Perito Moreno", "Buenos Aires", "Rio Turbio", "Comandante Luis Piedra Buena", "El Calafate",
	"Gobernador Gregores", "Los Antiguos", "Las Heras", "Pico Truncado", "Puerto Deseado", "San Julian", "Puerto Santa Cruz", "Agencia", "28 de Noviembre"];
	if($_SESSION['sucursal'] == 10 || $_SESSION['sucursal'] == 40 || $_SESSION['sucursal'] == 80){
		if($_SESSION['sucursal'] == 10){
			$sucursal = 03;
		}else{
			if($_SESSION['sucursal'] == 40){
				$sucursal = 04;
			}else{
				$sucursal = 02;
			}
		}
	}else{
		$sucursal = $_SESSION['sucursal'];
	}
    $medioEspera = "SELECT max(Duration)/60 espera
    FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] WHERE PartitionId = $fecha AND OrganizationCode = {$sucursal} AND DTECode LIKE '%Totem%' AND StateId = 2 AND AdminStopped = 0";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $medioEspera);
	for ($i = 0; $i < 16; ++$i) {
        if($sucursales[$i] == $sucursal){
			$nombre = $nombreSucursales[$i];
		}
    }
    $html = "";
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $espera = $fila["espera"];
            if ($espera < 31) {
                $html = $html . '<tr><th><a class="text-dark"><font size=4>'.$nombre.'</font></a></th><th><img src="/lib/img/verde.png" class="espera" name="'.{$sucursal}.'" width="30" height="30"></th>';
            } else {
                if ($espera < 91) {
                    $html = $html . '<tr><th><a class="text-dark"><font size=4>'.$nombre.'</font></a></th><th><img src="/lib/img/amarillo.png" class="espera" name="'.{$sucursal}.'" width="30" height="30"></th>';
                } else {
                    $html = $html . '<tr><th><a class="text-dark"><font size=4>'.$nombre.'</font></a></th><th><img src="/lib/img/rojo.png" class="espera" name="'.{$sucursal}.'" width="30" height="30"></th>';
                }
            }
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de turnero rio gallegos][QUERY: $medioEspera]");
    }

    //tiempo medio de atencion Rio Gallegos

    $medioAtencion = "SELECT max(Duration)/60 espera
    FROM [VM000DB00].[STE].[dbo].[vw_H_INS_TaskInterval] WHERE PartitionId = $fecha AND OrganizationCode = {$sucursal} AND DTECode NOT LIKE '%Totem%' AND StateId IN (4) AND AdminStopped = 0";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $medioAtencion);
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $fila = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $espera = $fila["espera"];
            if ($espera < 31) {
                $html = $html . '<th><img src="/lib/img/verde.png" class="atencion" name="'.{$sucursal}.'" width="30" height="30"></th></tr>';
            } else {
                if ($espera < 91) {
                    $html = $html . '<th><img src="/lib/img/amarillo.png" class="atencion" name="'.{$sucursal}.'" width="30" height="30"></th></tr>';
                } else {
                    $html = $html . '<th><img src="/lib/img/rojo.png" class="atencion" name="'.{$sucursal}.'" width="30" height="30"></th></tr>';
                }
            }
        }
    } else {
        Log::escribirError("[Error al realizar la consulta de turnero rio gallegos][QUERY: $medioAtencion]");
    }

    return $html;
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('Y/m/d', strtotime('yesterday'));
    $fechats = strtotime($fecha);
    if (date('w', $fechats) == 0) {
        $fechaHoy = date("Y/m/d", strtotime($fecha . "- 2 days"));
    } else {
        if (date('w', $fechats) == 6) {
            $fechaHoy = date("Y/m/d", strtotime($fecha . "- 1 days"));
        } else {
            $fechaHoy = $fecha;
        }
    }


?>
<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                        <div class="center">
                            <h3 class="text-center"><u>Turnero al <?= $fechaHoy; ?></u></h3>
                        </div>
                        <br>
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <br><br>
                        <div class="form-row align-items-center mx-auto">
                            <table id='diariosSaldos' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style="width: 60%"/>
                                    <col style="width: 20%"/>
                                    <col style="width: 20%"/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>Espera</th>
                                        <th>Atencion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo turnero();
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
<script type="text/javascript" charset="utf8" src="/lib/JQuery/turnero.js"></script>
</html>

