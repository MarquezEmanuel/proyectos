<?php

require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['metodo'])) {
    $metodo = $_POST['metodo'];
    $id = $_POST['id'];
    $reporte = $_POST['reporte'];
    $nombre = utf8_decode($_POST['nombre']);
    $asunto = utf8_decode($_POST['asunto']);
    $mensaje = utf8_decode($_POST['mensaje']);
    if ($metodo === 'modificar') {
        $queryModificar = "UPDATE [3correoMensaje] SET nombre='{$nombre}', asunto='{$asunto}', mensaje='$mensaje' WHERE id='$id' ";
        $resultModificar = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryModificar);
        if ($resultModificar) {
            $div = '<div class="alert alert-success text-center" role="alert">Se modificó el mensaje predeterminado para el reporte</div>';
        } else {
            $log = new Log();
            $log->writeLine("[Error al modificar el mensaje predeterminado][QUERY: $queryModificar]");
            $div = '<div class="alert alert-danger text-center" role="alert">No se modificó el mensaje predeterminado para el reporte</div>';
        }
    } else {
        $queryCrear = "INSERT INTO [3correoMensaje] (reporte, nombre, asunto, mensaje) VALUES ('$reporte', '$nombre', '$asunto', '$mensaje')";
        $resultCrear = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCrear);
        if ($resultCrear) {
            $div = '<div class="alert alert-success text-center" role="alert">Se creó el mensaje predeterminado para el reporte</div>';
        } else {
            $log = new Log();
            $log->writeLine("[Error al crear el mensaje predeterminado][QUERY: $queryCrear]");
            $div = '<div class="alert alert-danger text-center" role="alert">No se creó el mensaje predeterminado para el reporte</div>';
        }
    }
} else {
    $div = '<div class="alert alert-danger text-center" role="alert"> No se recibieron los datos desde el formulario </div>';
}

echo $div;
