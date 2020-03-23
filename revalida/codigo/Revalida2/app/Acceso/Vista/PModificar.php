<?php

/* PROCESA LA MODIFICACION DEL SERVICIO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['id'] && $_POST['nombre'] && $_POST['legajo']) {
    $controlador = new ControladorAcceso();
    $id = $_POST['id'];
    $legajo = $_POST['legajo'];
    $nombre = $_POST['nombre'];
    $perfil = ($_POST['perfil'] != "") ? $_POST['perfil'] : "SIN PERFIL";
    $estado = ($_POST['estado'] != "") ? $_POST['estado'] : " ";
    $modificacion = $controlador->modificar($id, $legajo, $nombre, $perfil, $estado);
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
