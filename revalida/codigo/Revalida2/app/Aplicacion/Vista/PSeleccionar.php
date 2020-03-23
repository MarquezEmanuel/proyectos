<?php

/* PROCESA SELECCIONAR GERENCIA */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
$controlador = new ControladorAplicacion();
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$base = isset($_POST['base']) ? $_POST['base'] : "";
$aplicaciones = $controlador->seleccionar($nombre, $base);
if (gettype($aplicaciones) == "resource") {
    while ($aplicacion = sqlsrv_fetch_array($aplicaciones, SQLSRV_FETCH_ASSOC)) {
        $arreglo[] = array('id' => $aplicacion["id"], 'text' => utf8_encode($aplicacion["nombre"]));
    }
} 
echo json_encode($arreglo);
