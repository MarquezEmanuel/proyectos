<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if (isset($_POST['idPersonal'])) {
    $controlador = new ControladorPersonal();
    $id = $_POST['idPersonal'];
    $nombre = $_POST['nombre'];
    $sigla = $_POST['sigla'];
    $departamento = $_POST['departamento'];
    $rti = $_POST['rti'];
    $modificacion = $controlador->modificar($id, $sigla, $nombre, $departamento, $rti);
    $mensaje = $controlador->getMensaje();
    $exito = ($modificacion == 2) ? true : false;
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
