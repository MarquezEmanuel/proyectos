<?php

/* PROCESA SELECCIONAR ROL */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
$controlador = new ControladorRol();
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$roles = $controlador->seleccionar($nombre);
if (gettype($roles) == "resource") {
    while ($rol = sqlsrv_fetch_array($roles, SQLSRV_FETCH_ASSOC)) {
        $arreglo[] = array('id' => $rol["id"], 'text' => utf8_encode($rol["nombre"]));
    }
} else {
    $texto = ($roles == 1) ? "Sin resultados" : "Error";
    $arreglo[] = array('id' => "NO", 'text' => $texto);
}
echo json_encode($arreglo);
