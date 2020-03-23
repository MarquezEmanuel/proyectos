<?php

/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['idestado'])) {

    $query = "SELECT id_garantia FROM garantia WHERE estado='{$_POST['idestado']}'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $div = '<div class="alert alert-warning text-center" role="alert"> El estado que intenta borrar tiene relación con garantias </div>';
        } else {
            $query = "DELETE FROM estado WHERE id_estado=" . $_POST['idestado'];
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if ($result) {
                $div = '<div class="alert alert-success text-center" role="alert"> Se realizó la eliminación del estado correctamente</div>';
            } else {
                $log = new Log();
                $log->writeLine("[No se pudo ejecutar la eliminacion del estado en la BD]");
                $div = '<div class="alert alert-danger text-center" role="alert"> No se realizó la eliminación del estado</div>';
            }
        }
    } else {
        $log = new Log();
        $log->writeLine("[No se pudo ejecutar la consulta de garantia en la BD][Query: $query]");
        $div = '<div class="alert alert-danger text-center" role="alert"> No se pudo consultar la relacion de las garantias con el estado </div>';
    }
} else {
    $log = new Log();
    $log->writeLine("[No se obtuvo el identificador del estado de _POST]");
    $div = '<div class="alert alert-danger text-center" role="alert"> No se recibió la información del estado </div>';
}

echo '<h4 class="text-center p-4">BORRAR ESTADO</h4>';
echo $div;
