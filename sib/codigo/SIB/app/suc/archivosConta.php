<?php
include_once '../conf/BDConexion.php';

session_start(); 

function cuentaCorrentista() {
	date_default_timezone_set('America/Argentina/Buenos_Aires');
    $actual = $actualfinal = date("d/m/Y");
    $actual = $actual . " 00:00:00";
    $actualfinal = $actualfinal . " 23:59:59";
    $sql = "select *
	from [bd_sib].[dbo].[3archivosConta] WHERE fechaActualizacion between '{$actual}' AND '{$actualfinal}' AND sucursal = {$_SESSION['sucursal']}";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
	$archivos = array("LAINF2K","conta","CM0","A49280","CM_ATM","00860","S008600");
	$html .= "<table id='diariosCentralCuentaCorrentista' class='table table-striped table-bordered' border='3' style='width: 100%'>
                <thead style='background-color:#024d85;color:white;'>
                    <tr>
						<th>Nombre</th>
						<th>Fecha</th>
                    </tr>
                </thead>
            <tbody>";
	$html2 .= "<div id='contenido' name='contenido' class='col-lg-12 contenido1'>
				<div class='center'>
                    <h3 class='text-center'><u>Archivos Pendientes</u></h3>
                </div><br><br>
                <div class='form-row align-items-center mx-auto'>
				<table id='diariosCentralCuentaCorrentista' class='table table-striped table-bordered' border='3' style='width: 100%'>
                    <thead style='background-color:#024d85;color:white;'>
                        <tr>
							<th>Nombre</th>
                        </tr>
                    </thead>
                <tbody>";
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$nombre = utf8_encode($row['nombreArchivo']);
				$fecha = isset($row['fechaActualizacion']) ? $row['fechaActualizacion']->format('d/m/Y H:i:s') : "";
                $html = $html . "
                    <tr>
					<td>{$nombre}</td>
                    <td>{$fecha}</td>    
                    </tr>";
				for($i = 0; $i <= count($archivos); $i++){
					if(substr($nombre, 0,3) == substr($archivos[$i], 0,3)){
						unset($archivos[$i]);
						$i = count($archivos);
					}
				}
				$archivos = array_values($archivos);
            }
			$html .= "</tbody>
                            </table> <br>";
			for($i = 0; $i <= count($archivos); $i++){
				if($archivos[$i] != ""){
					$html2 .= "<tr><td>{$archivos[$i]}</td></tr>";
				}
			}
			$html2 .= "</tbody>
                            </table> <br></div></div>";
        } else {
            $html .= "</tbody>
                            </table><br>";
			for($i = 0; $i <= count($archivos); $i++){
				if($archivos[$i] != ""){
					$html2 .= "<tr><td>{$archivos[$i]}</td></tr>";
				}
			}
			$html2 .= "</tbody>
                            </table><br></div></div>";
        }
    } else {
        $html .= "</tbody>
                            </table><br>";
			for($i = 0; $i <= count($archivos); $i++){
				if($archivos[$i] != ""){
					$html2 .= "<tr><td>{$archivos[$i]}</td></tr>";
				}
			}
			$html2 .= "</tbody>
                            </table><br></div></div>";
    }
	$total = $html . $html2;
    return $total;
}

$_SESSION['buscar'] = null;

require_once './menuSucursal.php';
?>
<div class="container">
    <div class="card-header">
        <div id="centro" class="container">
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido" name="contenido" class="col-lg-12 contenido1">
						<br>
                        <a href="conta.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        <div class="center">
                            <h3 class="text-center"><u>Archivos Generados</u></h3>
                        </div>
						<br><br>
                        <div class="form-row align-items-center mx-auto">
                                    <?php
                                    echo cuentaCorrentista();
                                    ?>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>