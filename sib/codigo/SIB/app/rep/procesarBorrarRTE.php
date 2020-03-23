<?php

/* INCLUYE LOS ARCHIVOS PARA UTILIZAR */
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['transacciones'])) {
    if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
        $log = new Log();
        $log->writeLine("[Error al inicializar la transaccion (begin_transaction)]");
        echo '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
    } else {
        $transacciones = $_POST['transacciones'];

        $referencias = "";
        foreach ($transacciones as $transaccion) {
            /* RECORRE LAS TRANSACCIONES Y ELIMINA LOS ARCHIVOS ASOCIADOS */
            $referencias = $referencias . "'" . $transaccion . "',";
            $uri = URL_RTE . "\\RTE{$transaccion}.xml";
            if (file_exists($uri)) {
                unlink($uri);
            } else {
                $log = new Log();
                $log->writeLine("[No se puede borrar el XML RTE porque no existe][URL: $uri]");
            }
        }
        $referencias = substr($referencias, 0, -1);
        $queryVinculado = "DELETE FROM  rte_vinculado WHERE referencia IN ($referencias)";
        $resultVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryVinculado);
        if ($resultVinculado) {
            /* SE ELIMIINARON TODOS LOS SUJETOS VINCULADOS */
            $queryTransaccion = "DELETE FROM rte_transaccion WHERE referencia IN ($referencias)";
            $resultTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTransaccion);
            if ($resultTransaccion) {
				$log = new Log();
                $log->writeLine("[quiee eliminar][QUERY: $queryTransaccion]");
                sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                echo '<div class="alert alert-success text-center" role="alert"> Se realizó la eliminación de RTE correctamente </div>';
            } else {
                $log = new Log();
                $log->writeLine("[Error al eliminar transacciones en la BD][QUERY: $queryTransaccion]");
                sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
                echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la eliminación del RTE </div>';
            }
        } else {
            $log = new Log();
            $log->writeLine("[Error al eliminar sujetos vinculados en la BD][QUERY: $queryVinculado]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
            echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la eliminación del RTE </div>';
        }
    }
} else {
    /* NO SE RECIBIO POR POST LA TRANSACCION SELECCIONADA */
    $log = new Log();
    $log->writeLine("[Error al recibir parametros por POST]");
    $html = '<div class="alert alert-danger" role="alert"> No se recibieron los datos del formulario de búsqueda </div>';
}