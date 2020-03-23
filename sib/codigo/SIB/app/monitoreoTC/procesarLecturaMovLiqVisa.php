<?php

$rutaMOVLIQ = "D:\\Aplica\\SIB\\documents\\tarjetas\\B086_ARCHIVOMOVLIQ.txt";

if (file_exists($rutaMOVLIQ)) {
    $file = fopen($rutaMOVLIQ, "r");
    if ($file) {
        $cabecera = fgets($file);
        while (!feof($file)) {
            $linea = fgets($file);
            $codadm = substr($linea, 0, 3);
            $codbco = substr($linea, 3, 3);
            $codcas = substr($linea, 6, 3);
            $codope = substr($linea, 9, 4);
            $nrota1 = substr($linea, 13, 6);
            $nrota2 = substr($linea, 25, 4);
            $nrousu = substr($linea, 29, 9);
            $digusu = substr($linea, 38, 1);
            $fecpre = substr($linea, 39, 6);
            $fecori = substr($linea, 45, 6);
            $nrocom = substr($linea, 51, 8);
            $moneda = substr($linea, 59, 3);
            $import = substr($linea, 62, 14);
            $monori = substr($linea, 76, 3);
            $impori = substr($linea, 79, 14);
            $imppes = substr($linea, 93, 14);
            $impdol = substr($linea, 107, 14);
            $nombre = substr($linea, 143, 35);
            $cadest = substr($linea, 178, 3);
            $cbcest = substr($linea, 181, 3);
            $csuest = substr($linea, 184, 3);
            $carter = substr($linea, 187, 2);
            $marint = substr($linea, 189, 1);
            $fecint = substr($linea, 199, 6);
            $grupaf = substr($linea, 205, 4);
            $tipcta = substr($linea, 209, 1);
            $regusu = substr($linea, 210, 5);
            $regest = substr($linea, 215, 5);
            $codpai = substr($linea, 225, 2);
            
            echo $codadm . " " . $codbco . " " . $codcas . " " . $codope . " ";
            echo $nrota1 . " " . $nrota2 . " " . $nrousu . " " . $digusu . " ";
            echo $fecpre . " " . $fecori . " " . $nrocom . " " . $moneda . " ";
            echo $import . " " . $monori . " " . $impori . " " . $moneda . " ";
            echo $impdol . " " . $nombre . " " . $cadest . " " . $cbcest . " ";
            echo $csuest . " " . $carter . " " . $marint . " " . $fecint . " ";
            echo '<br>';
        }
    } else {
        echo 'NO SE PUDO ABRIR EL ARCHIVO';
    }
} else {
    echo 'EL ARCHIVO NO EXISTE';
}