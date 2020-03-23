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

if (!isset($_SESSION['sucursal'])) {
    $log = new Log();
    $log->writeLine("[Se intento acceder al menu con otro rol][USUARIO: $usuario]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center' role='alert'>No puede acceder al menu solicitado</div>";
    header("Location: ../../index.php");
}
?>
<html id="html">
    <head>
        <meta charset="UTF-8">
        <title> SIB - REPORTES SUCURSAL  <?= $_SESSION['sucursal']; ?></title>
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
        <script type="text/javascript" charset="utf8" src="../../lib/JQuery/jquery.tablesorter.min.js"></script>
        <script>
            $(document).ready(function () {
                setInterval(algo, 6000);
                function algo() {
                    $('#mensajeModal').load('../consulta.php');
                    if ($('#msjModal tr').length > 1) {
                        $('#mdProcesando').modal({show: true, backdrop: 'static'});
                    } else {
                        $('#mdProcesando').modal({show: false});
                    }
                }
            });
        </script>
    </head>
    <body style="background-color:lavender;">
    <navbar id="menu-horizontal" class="navbar navbar-expand-lg navbar-dark" style="background-color: #024d85;">
        <div class="container">
            <span><a href="inicioSucursal.php"><img src="../../lib/img/cabezera.png" class="img-thumbnail" alt="Responsive image" width="70" height="70"></a></span>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        &nbsp;&nbsp;<h3 class="text-white">Gestion de reportes</h3>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                        $sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$usuario' AND estado = 'Pendiente'";
                        $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                        if ($result) {
                            if (sqlsrv_fetch_array($result)) {
                                echo '<a href="../salaChatPendientes.php"><input type="button" class="btn btn-secondary my-2 my-sm-0 btn-danger" value="CHAT PENDIENTE"></a>';
                            } else {
                                $sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$usuario' AND estado = 'Leido'";
                                $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                                if ($result) {
                                    if (sqlsrv_fetch_array($result)) {
                                        echo '<a href="../salaChatPendientes.php"><input type="button" class="btn btn-secondary my-2 my-sm-0" value="Chat Pendiente"></a>';
                                    }
                                }
                            }
                        }
                        ?>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" value="Usuario: <?= $_SESSION['legajo'] ?>" readonly>
                        <input class="form-control mr-sm-2" type="text" value="<?= $nombreRol; ?>" readonly>
                        <a href="../procesarLogout.php"><input type="button" class="btn btn-secondary my-2 my-sm-0" value="Salir"></a>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="mdProcesando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <form action='../tratarChat.php' method='post'>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="myModalLabel">TIENE CONVERSACIONES PENDIENTES</h4>
                        </div>
                        <div class="modal-body" id="mensajeModal">

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </navbar>