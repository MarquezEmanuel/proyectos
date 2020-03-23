<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

echo '<h4 class="text-center p-4">BORRAR REPORTE DE TRANSACCIONES EN EFECTIVO</h4>';
if (isset($_POST['idOperacion'])) {

    if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
        $log = new Log();
        $log->writeLine("[Error al inicializar la transaccion (begin_transaction)]");
        echo '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
    } else {

        $idOperacion = $_POST['idOperacion'];

        $querySujeto = "DELETE FROM rte_sujeto WHERE idOperacion=" . $idOperacion;
        $resultSujetos = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySujeto);

        $queryOperacion = "DELETE FROM rte_operacion WHERE idOperacion=" . $idOperacion;
        $resultOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryOperacion);

        if ($resultSujetos && $resultOperacion) {

            $uri = URL_RTEPF . "\\RTEPF{$idOperacion}.xml";
            if (file_exists($uri)) {
                unlink($uri);
            } else {
                $log = new Log();
                $log->writeLine("[No se puede borrar el XML RTEPF porque no existe][URL: $uri]");
            }
            sqlsrv_commit(BDConexion::getInstancia()->getConexion());
            echo '<div class="alert alert-success text-center" role="alert"> Se realizó la eliminación del RTE correctamente </div>';
        } else {
            $log = new Log();
            $log->writeLine("[Error al eliminar operacion o sujetos en la BD][QUERY: $queryOperacion][QUERY: $querySujeto]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
            echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la eliminación del RTE </div>';
        }
    }
} else {
    $log = new Log();
    $log->writeLine("[Error al recibir el idOperacion por POST]");
    echo '<div class="alert alert-danger text-center" role="alert"> No se recibió la información del RTE </div>';
}