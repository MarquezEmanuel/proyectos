<?php

/* PROCESA SELECCIONAR GERENCIA */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
$controlador = new ControladorGerencia();
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$gerencias = $controlador->seleccionar($nombre);
if (gettype($gerencias) == "resource") {
    while ($gerencia = sqlsrv_fetch_array($gerencias, SQLSRV_FETCH_ASSOC)) {
        $arreglo[] = array('id' => $gerencia["id"], 'text' => utf8_encode($gerencia["nombre"]));
    }
} else {
    $texto = ($gerencias == 1) ? "Sin resultados" : "Error";
    $arreglo[] = array('id' => "NO", 'text' => $texto);
}
echo json_encode($arreglo);
