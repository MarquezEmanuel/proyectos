<?php

/* PROCESA LA MODIFICACION DEL USUARIO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$exito = FALSE;
if ($_POST['id'] && $_POST['nombre']) {
    $controlador = new ControladorUsuario();
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $legajo = $_POST['legajo'];
    $cargo = $_POST['cargo'];
    $gerencia = $_POST['gerencia'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];
    $modificacion = $controlador->modificar($id, $legajo, $nombre, $apellido, $cargo, $gerencia, $rol, $estado);
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
