<?php
/* INCLUYE LOS ARCHIVOS A UTILIZAR */
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if(isset($_POST['idSujeto'])) {
    $id = $_POST['idSujeto'];
    $sql = "DELETE FROM rte_vinculado WHERE id=$id";
    $resultVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    if($resultVinculado) {
        $resultado = '<div class="alert alert-success text-center" role="alert"> Se eliminó el sujeto vinculado correctamente </div>';
    } else {
        $log = new Log();
        $log->writeLine("[Error al eliminar sujeto vinculado][QUERY: $sql]");
        $resultado = '<div class="alert alert-success text-center" role="alert"> No se eliminó el sujeto vinculado </div>';
    }
} else {
    $resultado = '<div class="alert alert-danger text-center" role="alert"> No se recibió la información del formulario de modificación </div>';
}

echo $resultado;