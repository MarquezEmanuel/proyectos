<?php

require_once '../conf/Constants.php';
require_once '../conf/Log.php';

/* ESTABLECE EL DIA Y LA HORA PARA ADJUNTAR AL NOMBRE DEL ZIP */
date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y_m_d-His");

if (isset($_POST['cbCorreos'])) {
	$nombrezip = "Saldos".$actual.".zip";
	$zip = new ZipArchive();
	$zip->open($nombrezip, ZipArchive::CREATE);
	$zip->addEmptyDir($dir);
	$contador = 1;
    $correos = $_POST['cbCorreos'];
    foreach ($correos as $correo) {
		$nombre = "{$correo}";
		$nombreDestino = "{$correo}";
		$url = URL_ConstanciaSaldo . "\\" . $nombre;
		$zip->addFile($url, $nombreDestino);
		$contador++;
	}
	$zip->close();
}
/* REALIZA LA DESCARGA Y ELIMINACION DEL ARCHIVO TEMPORAL */
header("Content-type: application/octet-stream");
header("Content-disposition: attachment; filename=".$nombrezip);
readfile($nombrezip);
unlink($nombrezip);
