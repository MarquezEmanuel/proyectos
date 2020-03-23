<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

if (isset($_SESSION['user']) && isset($_SESSION['legajo']) && isset($_SESSION['nombreRol']) && $_POST['bloqueados']) {
    $nombreUsuario = $_SESSION['user'];
    $legajoUsuario = $_SESSION['legajo'];
    $nombreRol = $_SESSION['nombreRol'];
    $bloqueados = $_POST['bloqueados'];
    $condicion = "";
    $procesados = 0;
    foreach ($bloqueados as $bloqueo) {
        $consulta = "INSERT INTO [logs] VALUES ('REGISTRO', '{$legajoUsuario}','{$nombreUsuario}','{$nombreRol}','ELIMINA BLOQUEO IVR','NIT: {$bloqueo}',GETDATE())";
        $registroLog = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
        if ($registroLog) {
            $procesados++;
            $condicion .= "'" . $bloqueo . "',";
            Log::escribirError("[ELIMINACION DE BLOQUEO][USUARIO: {$legajoUsuario} / {$nombreUsuario}][NIT: {$bloqueo}]");
        } else {
            Log::escribirError("[ELIMINACION DE BLOQUEO (ERROR)][USUARIO: {$legajoUsuario} / {$nombreUsuario}][NIT: {$bloqueo}]");
            Log::escribirError("[ERROR AL REGISTRAR LOG][{$consulta}]");
        }
    }
    $consulta = "DELETE FROM [192.168.250.141].[IVR].[dbo].[ClienteBloqueo] WHERE Nro_Nit in (" . substr($condicion, 0, -1) . ")";
    $eliminacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
if ($eliminacion) {
        $mensaje = "Total de clientes que han sido desbloqueados: {$procesados}";
        Log::escribirError("[{$mensaje}]");
        $detalle = (strlen($condicion) > 400) ? substr(str_replace("'", "", $condicion), 0, -1) : str_replace("'", "", $condicion);
        $consulta = "INSERT INTO [logs] VALUES ('REGISTRO', '{$legajoUsuario}','{$nombreUsuario}','{$nombreRol}','ELIMINA BLOQUEO IVR','TOTAL BORRADOS ({$procesados}): {$detalle}',GETDATE())";
        sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
        $resultado = '<div class="alert alert-success text-center" role="alert">' . $mensaje . '</div>';
    } else {
        Log::escribirError("[ERROR AL ELIMINAR EN IVR][{$consulta}]");
        $detalle = (strlen($condicion) > 400) ? substr(str_replace("'", "", $condicion), 0, -1) : str_replace("'", "", $condicion);
        $consulta = "INSERT INTO [logs] VALUES ('ERROR', '{$legajoUsuario}','{$nombreUsuario}','{$nombreRol}','ELIMINA BLOQUEO IVR','NO SE PUDO EJECUTAR LA CONSULTA DE ELIMINACION ({$procesados}): {$detalle}',GETDATE())";
        sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
        $mensaje = "No se llevó a cabo la eliminación en IVR";
        $resultado = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    }
} else {
    $mensaje = "No se recibieron los datos necesarios para operar";
    $resultado = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

echo $resultado;
