<?php

/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['nombreEstado']) && $_POST['descripcion'] != null) {
    
    $query = "INSERT INTO estado VALUES('{$_POST['nombreEstado']}', '{$_POST['descripcion']}')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($result) {
        $div = '<div class="alert alert-success text-center" role="alert"> Se realizó la carga del estado correctamente </div>';
    } else {
        $log = new Log();
        $log->writeLine("[No se pudo ejecutar la creacion del estado en la BD][Query: $query]");
        $div = '<div class="alert alert-danger text-center" role="alert"> No se realizó la carga del estado </div>';
    }
    
} else {
    $log = new Log();
    $log->writeLine("[No se obtuvo el nombre de estado o la descripcion de _POST]");
    $div = '<div class="alert alert-danger text-center" role="alert"> No se recibió la información necesaria para la creación </div>';
}

echo '<h4 class="text-center p-4">CARGAR ESTADO</h4>';
echo $div;
