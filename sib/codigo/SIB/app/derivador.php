<?php

session_start();

require_once 'conf/Constants.php';
require_once 'conf/Log.php';

if (!isset($_SESSION['ingresa']) || !$_SESSION['ingresa'] || !isset($_SESSION['user'])) {
    $log = new Log();
    $log->writeLine("[No se ha definido que ingresa o no hay usuario en sesion][Redirecciona: index]");
    header("Location: ../index.php");
}

include_once 'conf/BDConexion.php';

$query = "SELECT * FROM rol WHERE id_rol=" . $_SESSION['idrol'];
$resultDerivadorNombreRol = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);


if (!$resultDerivadorNombreRol || !sqlsrv_has_rows($resultDerivadorNombreRol)) {
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center'>No se obtuvieron los datos del perfil para el usuario</div>";
    $log->escribirError("[No se pudo consultar el nombre del rol][{$query}][Redirecciona: index]");
    header("Location: ../index.php");
}

$row = sqlsrv_fetch_array($resultDerivadorNombreRol, SQLSRV_FETCH_ASSOC);
$_SESSION['nombreRol'] = $row['nombre'];
if (substr($row['nombre'], 0, 6) == 'REPSUC') {
    $_SESSION['sucursal'] = (int) substr($row['nombre'], 6, 2);
}
header("Location: " . $row['link']);