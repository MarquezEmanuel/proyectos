<?php

require_once '../conf/Constants.php';
$idOperacion = $_POST['idOperacion'];
$uri = URL_RTEPF . "\\RTEPF{$idOperacion}.xml";
if (file_exists($uri)) {
    header('Content-Description: File Transfer');
    header('Content-Type: text/xml');
    header('Content-Disposition: attachment; filename=' . basename($uri));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($uri));
    ob_clean();
    flush();
    readfile($uri);
} else {
    require_once '../conf/Log.php';
    
    $log = new Log();
    $log->writeLine("[No se encuentra el archivo XML para RTEPF][{$url}]");
    
    header("Location: ../index.php");
}
   