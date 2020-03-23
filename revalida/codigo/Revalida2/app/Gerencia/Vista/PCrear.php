<?php

/* PROCESA LA CREACION DE LA NUEVO GERENCIA */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['nombre']) {
    $controlador = new ControladorGerencia();
    $nombre = $_POST['nombre'];
    $creacion = $controlador->crear($nombre);
    $mensaje = $controlador->getMensaje();
    $exito = ($creacion == 2) ? true : false;
    $resultado = HTML::getAlerta($creacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = HTML::getAlerta(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);