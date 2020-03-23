<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
require_once '../conf/Constants.php';
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Conta - Sucursales</u></h3>
		<br>
            <a href="<?=$_SERVER["HTTP_REFERER"]?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
			<br><br>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idCuenta = $_POST['seleccionado'];
			$nombre = substr($idCuenta,0,20);
			$monto = substr($idCuenta,20);
			$ruta = URL_Conta . "\\$nombre";

if (file_exists($ruta)) {
    $archivo = fopen($ruta, "r");
    if ($archivo) {
        fgets($archivo);
        $filas = "";
        $registros = array();
        $especiales = array();
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            if (strlen($linea) == 42) {
                $moneda = substr($linea, 2, 2);
                $importe = ltrim(substr($linea, 16, 14), '0');
                $tran = substr($linea, 10, 3);
                $trca = substr($linea, 10, 6);
                if ($moneda === "80") {
                    $registros[$tran][] = ($importe / 100);
                    if ($trca == "300615" || $trca == "350617" || ($tran == "410" && $trca != "410430") || ($tran == "426" && $trca != "426430")) {
                        $especiales[$trca][] = ($importe / 100);
                    }
                }
            }
        }

        foreach ($especiales as $key => $value) {
            $especiales[$key] = array_sum($value);
        }

        $total = $saldoInicial = $monto;
        ksort($registros);
        foreach ($registros as $key => $value) {
            $importe = array_sum($value);
            if ((substr($key, 1, 2) < 50)) {
                if ($key == "410") {
                    $operacion = "SUMA ESPECIAL";
                    foreach ($especiales as $posicion => $valor) {
                        if (substr($posicion, 0, 3) == "410") {
                            $importe = $importe - $valor;
                        }
                    }
                    $total = $total + $importe;
                } else {
                    if ($key == "426") {
                        $operacion = "SUMA ESPECIAL";
                        foreach ($especiales as $posicion => $valor) {
                            if (substr($posicion, 0, 3) == "426") {
                                $importe = $importe - $valor;
                            }
                        }
                        $total = $total - $importe;
                    } else {
						if ($key == "300" && isset($especiales['300615'])) {
							$operacion = "RESTA ESPECIAL";
							$total = $total + $importe - $especiales['300615'];
						} else{
							$operacion = "SUMA";
							$total = $total + $importe;
						}
                    }
                }
            } else {
                    if ($key == "350" && isset($especiales['350617'])) {
                        $operacion = "SUMA ESPECIAL";
                        $total = $total - $importe + $especiales['350617'];
                    } else {
                        $operacion = "RESTA";
                        $total = $total - $importe;
                    }

				}
			$importe =  number_format($importe,2);
			$total2 =  number_format($total,2);
            $filas .= "
                        <tr>
                            <td>" . substr($key, 0, 3) . "</td>
                            <td>" . count($value) . "</td>
                            <td>" . $importe . "</td>
                            <td>" . $operacion . "</td>
                            <td>" . $total2 . "</td>
                        </tr>";
        }
		$total2 =  number_format($total,2);
		$saldoInicial =  number_format($saldoInicial,2);
        $tabla = "
            <table id='tb_buscar_saldos' class='table table-striped table-bordered' border='3' style='width: 100%'>
                <thead style='background-color:#024d85;color:white;'>
                    <tr>
                        <th>Transacción</th>
                        <th>Cantidad</th>
                        <th>Suma Tra-Cau</th>
                        <th>Operacion</th>
                        <th>Cálculo</th>
                    </tr>
                </thead>
                <tbody>{$filas}
				<tfoot>
				<tr>
					<th>Saldo Inicial: {$saldoInicial} ---- Saldo final: {$total2}</th>
				</tr>
				</tfoot>
				</tbody>
            </table>";
        echo $tabla;

    } else {
        echo "No se pudo abrir el archivo '{$nombre}'";
    }
} else {
    echo "El archivo '{$nombre}' no existe en el directorio";
}
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
                ?>
                <div class="container">
                        <br><br>              
                    <br>
                       
            </div>
        </div>
    </div>
</div>
</body>
</html>


