<?php

$files = glob('./altasXML/*.xml'); //obtenemos todos los nombres de los ficheros XML de la carpeta 
foreach($files as $file){
    if(is_file($file))
    unlink($file); //elimino uno a uno todos los ficheros de la carpeta
}
$fecha = getdate();

$file = "altasXML.zip";
  if (is_file($file)) {
    $filename = "altasXML_".$fecha['year']."-".$fecha['mon'].".zip"; // el nombre con el que se descargará el archivo comprimido
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    readfile($file);
  } else {
	  echo "<h3> Error: </h3>";
    die("No se encontró el archivo '$file'");
  }
  
  unlink($file);
  //rmdir("./altasXML");

?>