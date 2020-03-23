<?php

/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['idestado']) && isset($_POST['nombreEstado']) && isset($_POST['descripcion'])) {

    $query = "UPDATE estado SET nombre='{$_POST['nombreEstado']}', descripcion='{$_POST['descripcion']}' WHERE id_estado=" . $_POST['idestado'];
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($result) {
        echo '<div class="alert alert-success text-center" role="alert"> Se realizó la modificación del estado </div>';
    } else {
        $log = new Log();
        $log->writeLine("[No se pudo ejecutar la modificacion de estado en la BD][Query: $query]");
        echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la modificación del estado </div>';
    }
} else {
    $log = new Log();
    $log->writeLine("[No se obtuvo el identificador de estado(idEstado), nombre(nombreEstado) o la descripcion(descripcion) de _POST]");
    echo '<div class="alert alert-danger text-center" role="alert"> No se recibió la información necesaria para la modificación </div>';
}