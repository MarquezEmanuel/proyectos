<?php

/* PROCESA LA MODIFICACION DE LA GERENCIA */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['id'] && $_POST['nombre']) {
    $controlador = new ControladorGerencia();
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $delegado = isset($_POST['delegado']) ? $_POST['delegado'] : NULL;
    $subdelegado = isset($_POST['subdelegado']) ? $_POST['subdelegado'] : NULL;
    $estado = $_POST['estado'];
    $modificacion = $controlador->modificar($id, $nombre, $delegado, $subdelegado, $estado);
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
