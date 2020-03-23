<?php

$path = $_GET["path"];

if (file_exists($path)) {

    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename=' . basename($path));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    exit;
    
} else {
    
    include_once '../conf/Constants.php';
    include_once '../conf/Log.php';
    
    $log = new Log();
    $log->writeLine("[No se pudo abrir el documento PDF porque no existe][RUTA: $path]");
    
    echo "<p>No se pudo abrir el documento solicitado. Por favor informe del error</p>";
 
}