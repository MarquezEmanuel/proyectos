<?php
require_once '../conf/Constants.php';
include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX

$sucursal = $_POST['sucursal'];
$monto = $_POST['monto'];

$html = "";

$ruta = URL_Conta . "\\$sucursal";

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
            $filas .= "
                        <tr>
                            <td>" . substr($key, 0, 3) . "</td>
                            <td>" . substr($key, 3, 3) . "</td>
                            <td>" . count($value) . "</td>
                            <td>" . $importe . "</td>
                            <td>" . $operacion . "</td>
                            <td>" . $total . "</td>
                        </tr>";
        }

        $total2 =  number_format($total,2);
		$saldoInicial2 =  number_format($saldoInicial,2);
		$html = $html. "<br>
        <table id='tb_buscar_saldos' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Saldo Inicial</th>
                                            <th>Saldo Final</th>
                                            <th>Detalle</th>
                                        </tr>
            </thead>
        <tbody>
		<tr>
                <td>{$saldoInicial2}</td>
                <td>{$total2}</td>

                <td class='text-center' title='Ir a ver detalles de saldos'>
                    <button class='btn btn-sm btn-outline-info detallesSaldos' name='{$sucursal}{$saldoInicial}'> 
                        <img src='/lib/img/SHOW.png' class='detallesSaldos' name='{$sucursal}{$saldoInicial}' width='18' height='18' > 
                    </button>
                </td>
            </tr>
		</tbody></table>
		";
		echo $html;
    } else {
        echo "No se pudo abrir el archivo '{$sucursal}'";
    }
} else {
    echo "El archivo '{$sucursal}' no existe en el directorio";
}


