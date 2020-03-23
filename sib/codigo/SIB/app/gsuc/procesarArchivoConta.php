<?php

require_once '../conf/Constants.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("d/m/y", strtotime('-1 days'));
$actual = str_replace("/","",$actual);
$nombre = "conta_001_{$actual}.txt";
$ruta = URL_Conta . "\\$nombre";

if (file_exists($ruta)) {
    $archivo = fopen($ruta, "r");
    if ($archivo) {
        fgets($archivo);
        $filas = "";
        $registros = array();
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            if (strlen($linea) == 42) {
                $moneda = substr($linea, 2, 2);
                $importe = ltrim(substr($linea, 16, 14), '0');
                $trca = substr($linea, 10, 6);
                if ($moneda === "80") {
                    $registros[$trca][] = ($importe / 100);
                }
            }
        }
        $total = $saldoInicial = 112818825.95;
        ksort($registros);
        foreach ($registros as $key => $value) {
            $importe = array_sum($value);
            if ((substr($key, 1, 2) < 50)) {
                switch ($key) {
                    case "300615":
                        $operacion = "RESTA";
                        $total = $total - $importe;
                        break;
                    case "426430":
                        $operacion = "RESTA";
                        $total = $total - $importe;
                        break;
                    case "410435":
                        $operacion = "";
                        $total = $total;
                        break;
                    case "410440":
                        $operacion = "";
                        $total = $total;
                        break;
                    default :
                        $operacion = "SUMA";
                        $total = $total + $importe;
                        break;
                }
            } else {
                $operacion = "RESTA";
                $total = $total - $importe;
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

        $tabla = "
            <table border='1'>
                <thead>
                    <tr>
                        <th>Transacción</th>
                        <th>Causal</th>
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