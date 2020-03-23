<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
session_start();

/* BUSCA EL ROL PARA EL USUARIO GUARDADO EN LA SESION */

$nombreUsuario = $_SESSION['user'];
$legajoUsuario = $_SESSION['legajo'];
$nombreRol = $_SESSION['nombreRol'];

$datosUsuario = "Usuario: " . $legajoUsuario . " " . $nombreUsuario;
$datosPerfil = "Rol: " . $nombreRol;

if (!isset($_SESSION['nombreRol']) || $_SESSION['nombreRol'] != 'OFICIAL NEGOCIO') {
    $log->escribirError("[Se intento acceder al menu con otro rol][USUARIO: $usuario]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center' role='alert'>No puede acceder al menu solicitado</div>";
    header("Location: ../../index.php");
}
?>
<html id="html">
    <head>
        <meta charset="UTF-8">
        <title>SIB - OFICIALES DE NEGOCIO</title>
        <link rel="icon" href="../../lib/img/estrella.jpg" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="../../lib/css/estilos.css"/>
        <link rel="stylesheet" href="../../lib/css/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" href="../../lib/css/datatables/jquery.dataTables.css">
        <link rel="stylesheet" href="../../lib/css/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../lib/css/buttons.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="../../lib/JQuery/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/buttons.flash.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../../lib/js/buttons.print.min.js"></script>
    </head>
    <body style="background-color:lavender;">
    <navbar id="menu-horizontal" class="navbar navbar-expand-lg navbar-dark" style="background-color: #024d85;">
        <div class="container">
            <span>
                <a href="inicio.php">
                    <img src="../../lib/img/cabezera.png" 
                         class="img-thumbnail" alt="Responsive image" 
                         width="70" height="70">
                </a>
            </span>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <h3 class="text-white ml-2">Oficiales de negocio</h3>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" 
                               title="Datos de usuario conectado"
                               value="<?= $datosUsuario; ?>" readonly>
                        <input class="form-control mr-sm-2" type="text" 
                               title="Datos de rol asociado"
                               value="<?= $datosPerfil; ?>" readonly>
                        <a href="../procesarLogout.php">
                            <input type="button" class="btn btn-secondary my-2 my-sm-0" 
                                   title="Salir de Sistema Integral Bancario"
                                   value="Salir">
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </navbar>

