<?php

require_once '../../../lib/PHPExcel/Classes/PHPExcel.php';
require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['legajo'] && $_POST['nombre'] && $_POST['idAplicacion']) {
    $legajo = $_POST['legajo'];
    $nombre = $_POST['nombre'];
    $perfil = ($_POST['perfil'] != "") ? $_POST['perfil'] : "SIN PERFIL";
    $estado = ($_POST['estado'] != "") ? $_POST['estado'] : " ";
    $aplicacion = $_POST['idAplicacion'];
    $controlador = new ControladorAcceso();
    $creacion = $controlador->crear($legajo, $nombre, $perfil, $estado, $aplicacion);
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
