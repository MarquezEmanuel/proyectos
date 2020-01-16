<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

if (isset($_POST['mcepAccion'])) {
    $controlador = new ControladorPersonal();
    $id = $_POST['mcepIdPersonal'];
    $estado = ($_POST['mcepAccion'] == "ALTA") ? 'Activo' : 'Inactivo';
    $modificacion = $controlador->cambiarEstado($id, $estado);
    $mensaje = $controlador->getMensaje();
    $resultado = ControladorHTML::getAlertaOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::getAlertaOperacion(0, $mensaje);
}

echo $resultado;
