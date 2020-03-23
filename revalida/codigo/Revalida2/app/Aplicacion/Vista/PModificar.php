<?php

/* PROCESA LA MODIFICACION DEL SERVICIO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['id'] && $_POST['nombre'] && $_POST['gerencia'] && $_POST['estado']) {
    $controlador = new ControladorAplicacion();
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $propietario = $_POST['gerencia'];
    $estado = $_POST['estado'];
    $modificacion = $controlador->modificar($id, $nombre, $propietario, $estado);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? true : false;
    $resultado = HTML::getAlerta($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = HTML::getAlerta(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
