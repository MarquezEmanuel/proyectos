<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

/* BUSCA EL ROL PARA EL USUARIO GUARDADO EN LA SESION */

$usuario = $_SESSION['legajo'];
$sql = "SELECT nombre FROM rol WHERE id_rol = " . $_SESSION['idrol'];
$resultadoRol = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);

if (!$resultadoRol) {
    $log = new Log();
    $log->writeLine("[No se pudo obtener el nombre del rol][QUERY: $sql][USUARIO: $usuario]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center' role='alert'>No se obtuvo información asociada al rol para cargar menu de usuarios</div>";
    header("Location: ../../index.php");
}

$row = sqlsrv_fetch_array($resultadoRol);
$nombreRol = $row["nombre"];

if ($nombreRol != "MONITOREO TC") {
    $log = new Log();
    $log->writeLine("[Se intento acceder al menu con otro rol][USUARIO: $usuario]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center' role='alert'>No puede acceder al menu solicitado</div>";
    header("Location: ../../index.php");
}
?>

<html id="html">
    <head>
        <meta charset="UTF-8">
        <title> SIB </title>
        <link rel="stylesheet" href="../../lib/css/bootstrap-toggle.min.css"/>
        <link rel="stylesheet" href="../../lib/css/estilos.css"/>
        <link rel="stylesheet" href="../../lib/css/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" href="../../lib/css/datatables/jquery.dataTables.css">
        <link rel="stylesheet" href="../../lib/css/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../lib/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="../../lib/JQuery/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/bootstrap-toggle.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/buttons.flash.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/loader.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/JQuery/jquery.tablesorter.min.js"></script>
    </head>
    <body style="background-color:lavender;">
    <navbar id="menu-horizontal" class="navbar navbar-expand-lg navbar-dark" style="background-color: #1d6091;">
        <div class="container">
            <span><a href="inicio.php"><img src="../../lib/img/cabezera.png" class="img-thumbnail" alt="Responsive image" width="70" height="70"></a></span>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        &nbsp;&nbsp;<h3 class="text-white">Monitoreo TC</h3>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </ul>
                    
                    <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="text" value="Usuario: <?= $_SESSION['legajo'] ?>" readonly>
                    <input class="form-control mr-sm-2" type="text" value="<?= $nombreRol; ?>" readonly>
                    <a href="../procesarLogout.php"><input type="button" class="btn btn-secondary my-2 my-sm-0" value="Salir"></a>
                </form>
                </div>
            </div>
        </div>
    </navbar>
