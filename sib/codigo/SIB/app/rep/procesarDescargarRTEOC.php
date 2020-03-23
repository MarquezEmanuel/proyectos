<?php

include_once '../conf/Constants.php';

function data() {
    return $idTransaccion = $_POST['idOperacion'];
}

// Definimos el nombre de archivo a descargar.
echo (data());
$filename = "CVME" . data();
// Ahora guardamos otra variable con la ruta del archivo
$file = URL_RTEOC . '\\' . $filename . '.xml';
// Aquí, establecemos la cabecera del documento
header('Content-Description: File Transfer');
header('Content-Type: text/xml');
header('Content-Disposition: attachment; filename=' . basename($file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file));

ob_clean();
flush();
readfile($file);
