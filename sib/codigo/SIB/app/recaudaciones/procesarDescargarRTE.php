<?php

require_once '../conf/Constants.php';
require_once '../conf/Log.php';

/* ESTABLECE EL DIA Y LA HORA PARA ADJUNTAR AL NOMBRE DEL ZIP */
date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Ymd-His");

$fileName = "FallecidosCuentaAnses.txt";
$filePath = URL_RTEOC . "\\" . $fileName;
if(!file_exists($filePath)){
    // Define headers
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=PMCRED_DEB_SIB.txt");
    header("Content-Type: application/txt");
    header("Content-Transfer-Encoding: binary");
    
    // Read the file
    readfile($filePath);
    exit;
}else{
    echo 'The file does not exist.';
}