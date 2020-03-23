<?php

require_once '../conf/Constants.php';

$nombre = "conta_050_220120.txt";
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
        $total = $saldoInicial = 13459968.75;
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
                        $operacion = "SUMA";
                        $total = $total + $importe;
                    }
                }
            } else {
                if ($key == "350" && isset($especiales['300615'])) {
                    $operacion = "RESTA ESPECIAL";
                    $total = $total - $importe - $especiales['300615'];
                } else {
                    if ($key == "350" && isset($especiales['350617'])) {
                        $operacion = "SUMA ESPECIAL";
                        $total = $total - $importe + $especiales['350617'];
                    } else {
                        $operacion = "RESTA";
                        $total = $total - $importe;
                    }
                }
            }
            $filas .= "
                        <tr>
                            <td>" . substr($key, 0, 3) . "</td>
                            <td>" . count($value) . "</td>
                            <td>" . $importe . "</td>
                            <td>" . $operacion . "</td>
                            <td>" . $total . "</td>
                        </tr>";
        }

        $tabla = "
            <table border='1'>
                <thead>
                    <tr>
                        <th>Transacción</th>
                        <th>Cantidad</th>
                        <th>Suma Tra-Cau</th>
                        <th>Operacion</th>
                        <th>Cálculo</th>
                    </tr>
                </thead>
                <tbody>{$filas}</tbody>
            </table>";
        echo $tabla;

        echo "<br> <b>Saldo Inicial: </b>" . $saldoInicial . "<b> | Saldo final: </b>" . $total;
    } else {
        echo "No se pudo abrir el archivo '{$nombre}'";
    }
} else {
    echo "El archivo '{$nombre}' no existe en el directorio";
}