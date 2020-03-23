<?php
/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

if (is_null($_SESSION['ingresa'])) {
    $log = new Log();
    $log->writeLine("[No hay usuario en sesion para mostrar el formulario][Redirecciona: index]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center'>No se obtuvo información de la sesión al iniciar</div>";
    header("Location: ../../index.php");
}

$query = "SELECT p.nombre nombre FROM rol_permiso rp, permiso p WHERE rp.id_permiso = p.id_permiso AND rp.id_rol=" . $_SESSION['idrol'];
$resultPermisos = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

if (!$resultPermisos || !sqlsrv_has_rows($resultPermisos)) {
    $log = new Log();
    $log->writeLine("[No se obtuvieron los permisos desde la BD][Redirecciona: index][QUERY: $query]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center'>No se obtuvieron los permisos asociados al usuario</div>";
    header("Location: ../../index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SIB - GARANTIAS</title>
        <link rel="icon" href="../../lib/img/estrella.jpg" type="image/gif" sizes="16x16">
        <link rel="stylesheet" type="text/css" href="../../lib/css/estilos.css"/>
        <link rel="stylesheet" type="text/css" href="../../lib/css/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../../lib/css/datatables/dataTables.bootstrap4.min.css">
        <script type="text/javascript" charset="utf8" src="../../lib/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/datatables/jquery.dataTables.js" ></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/datatables/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/bootstrap/bootstrap.min.js" ></script>
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
                <?php
                while ($row = sqlsrv_fetch_array($resultPermisos, SQLSRV_FETCH_ASSOC)) {
                    if ($row['nombre'] == "GESTIONAR GARANTIAS") {
                        echo '
                        <div class="form-row align-items-center mx-auto text-center">
                            <div class="col-lg-2 text-center">
                            </div>
                            <div class="col-lg-8 text-center">
                                <a href="formBuscarGarantia.php">
                                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Garantias</button>
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="form-row align-items-center mx-auto text-center">
                            <div class="col-lg-2 text-center">
                            </div>
                            <div class="col-lg-8 text-center">
                                <a href="formBuscarEstados.php">
                                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Estado</button>
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="form-row align-items-center mx-auto">
                            <div class="col-lg-2 text-center">
                            </div>
                            <div class="col-lg-8 text-center">
                                <a href="formCargarGarantia.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Cargar Garantia</button></a>
                            </div>
                        </div>';
                    }
                    if ($row['nombre'] == "CONSULTAR GARANTIAS") {
                        echo '
                        <div class="form-row align-items-center mx-auto text-center">
                            <div class="col-lg-2 text-center">
                            </div>
                            <div class="col-lg-8 text-center">
                                <a href="formConsultarGarantia.php">
                                    <button class="btn btn-lg btn-bsc btn-block" type="submit">Consultar Garantias</button>
                                </a>
                            </div>
                        </div>';
                    }
                }
                ?>
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