<?php

require_once '../conf/Constants.php';

$directorio = opendir(URL_Conta);
$filas = "";
while ($elemento = readdir($directorio)) {
    if ($elemento != "." && $elemento != "..") {
        $filas .= "
        <tr>
            <td>{$elemento}</td>
            <td></td>
        </tr>";
    }
}
$tabla = "
    <table border='1'>
        <thead>
            <tr>
                <th>Nombre archivo</th>
                <th>Operación</th>
            </tr>
        </thead>
        <tbody>{$filas}</tbody>
    </table>";

echo $tabla;

