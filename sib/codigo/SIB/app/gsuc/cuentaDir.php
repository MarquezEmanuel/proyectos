<?php

require_once '../conf/Constants.php';

$elemento = scandir(URL_Conta);

$total = count($elemento);

echo $total-2;

$directorio = opendir(URL_ConstanciaSaldo); //ruta actual
while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
{
    if (!is_dir($archivo))//verificamos si es o no un directorio
    {
        echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
    }
    else
    {
        echo $archivo . "<br />";
    }
}

?>