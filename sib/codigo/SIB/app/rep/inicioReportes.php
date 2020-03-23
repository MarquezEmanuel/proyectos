<?php
/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

if (is_null($_SESSION['ingresa'])) {
    $log = new Log();
    $log->writeLine("[No hay usuario en sesion para mostrar el formulario][Redirecciona: index]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center'>No se obtuvo información de la sesión al iniciar</div>";
    header("Location: ../../index.php");
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIB</title>
        <link rel="stylesheet" type="text/css" href="../../lib/css/estilos.css"/>
        <link rel="stylesheet" type="text/css" href="../../lib/css/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../../lib/css/datatables/dataTables.bootstrap4.min.css">
        <script type="text/javascript" charset="utf8" src="../../lib/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/datatables/jquery.dataTables.js" ></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/datatables/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/bootstrap/bootstrap.min.js"></script>
    </head>
    <body id="body">
        <div class="container" style="margin: 60px;">
            <div class="card-header">
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-12 text-center">
                        <img class="mb-4 img-login" src="../../lib/img/086-negro80_logo.fw.png" alt="">
                        <h1 class="h3 mb-3 font-weight-normal text-blue"> Le damos la bienvenida al Sistema Integral Bancario</h1>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="inicioRTE.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">RTE</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="inicioRTEPF.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">RTE Plazo Fijo</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="inicioRTEOC.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">RTE Operación de Cambio</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="cargarCuentaComitente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Cuenta Comitente</button></a>
                    </div>
                </div>
                <br>
				<div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="regimenTC.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Regimen TC</button></a>
                    </div>
                </div>
                <br>
				<div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="inicioXMLAltas.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Generaci&oacute;n XML Altas</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="../procesarLogout.php">
                            <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button>
                        </a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
                <br>
            </div>
        </div>
    </body>

</html>