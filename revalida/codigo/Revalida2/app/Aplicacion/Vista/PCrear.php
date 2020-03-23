<?php

/* PROCESA LA CREACION DE LA NUEVA APLICACION */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['nombre'] && $_POST['gerencia']) {
    $controlador = new ControladorAplicacion();
    $nombre = $_POST['nombre'];
    $propietario = $_POST['gerencia'];
    $creacion = $controlador->crear($nombre, $propietario);
    $mensaje = $controlador->getMensaje();
    $exito = ($creacion == 2) ? true : false;
    $resultado = HTML::getAlerta($creacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = $HTML::getAlerta(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
