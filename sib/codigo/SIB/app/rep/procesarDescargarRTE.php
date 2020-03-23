<?php

require_once '../conf/Constants.php';
require_once '../conf/Log.php';

/* ESTABLECE EL DIA Y LA HORA PARA ADJUNTAR AL NOMBRE DEL ZIP */
date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Ymd-His");

/* LISTADO DE TRANSACCIONES A DESCARGAR */
$transacciones = $_POST['transacciones'];

/* CREAR EL ARCHIVO TEMPORAL COMPRIMIDO */
$nombrezip = "RTE".$actual.".zip";
$zip = new ZipArchive();
$zip->open($nombrezip, ZipArchive::CREATE);
$zip->addEmptyDir($dir);
$contador = 1;
foreach ($transacciones as $referencia) {
    $nombre = "RTE{$referencia}.xml";
    $nombreDestino = "RTE-{$contador}-{$referencia}.xml";
    $url = URL_RTE . "\\" . $nombre;
    $zip->addFile($url, $nombreDestino);
    $contador++;
}
$zip->close();

/* REALIZA LA DESCARGA Y ELIMINACION DEL ARCHIVO TEMPORAL */
header("Content-type: application/octet-stream");
header("Content-disposition: attachment; filename=".$nombrezip);
readfile($nombrezip);
unlink($nombrezip);
