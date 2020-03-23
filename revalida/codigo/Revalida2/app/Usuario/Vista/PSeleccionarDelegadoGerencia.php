<?php

/* PROCESA SELECCIONAR USUARIO COMO DELEGADO DE UNA GERENCIA */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$arreglo = array();
$controlador = new ControladorUsuario();
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : " ";
$usuarios = $controlador->seleccionarDelegadoGerencia($nombre);
if (gettype($usuarios) == "resource") {
    while ($usuario = sqlsrv_fetch_array($usuarios, SQLSRV_FETCH_ASSOC)) {
        $arreglo[] = array('id' => $usuario["id"], 'text' => utf8_encode($usuario["nombre"]));
    }
} else {
    $texto = ($usuarios == 1) ? "Sin resultados" : "Error";
    $arreglo[] = array('id' => "NO", 'text' => $texto);
}
echo json_encode($arreglo);
