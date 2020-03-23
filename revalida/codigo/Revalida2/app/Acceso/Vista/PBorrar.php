<?php

/* ELIMINACION DE UN ACCESO DE USUARIO A SISTEMA DE TERCERO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if (isset($_POST['id']) && isset($_POST['datos'])) {
    $id = $_POST['id'];
    $datos = $_POST['datos'];
    $controlador = new ControladorAcceso();
    $eliminacion = $controlador->borrar($id, $datos);
    $mensaje = $controlador->getMensaje();
    $resultado = HTML::getAlerta($eliminacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = HTML::getAlerta(0, $mensaje);
}

echo $resultado;
