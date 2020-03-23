<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../Conexion/Modelo/Constantes.php';

require_once '../../../lib/phpExcelReader/Excel/OLERead.php';
require_once '../../../lib/phpExcelReader/Excel/reader.php';

$file = "C:/xampp/htdocs/REVALIDA2/lib/phpExcelReader/report.xls";
if (is_readable($file)) {
    echo $file . " cccccccc";
} else {
    echo "noo";
}


$nombre = AVA . "\\reporte.xlsx";

$data = new Spreadsheet_Excel_Reader();
//$data->setOutputEncoding('CP1251');
$data->read($file);




echo("<table>");
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
    echo("<tr>");
    for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
        echo("<td>" . $data->sheets[0]['cells'][$i][$j] . "</td>");
    }
    echo("</tr>");
}
echo("</table>");
