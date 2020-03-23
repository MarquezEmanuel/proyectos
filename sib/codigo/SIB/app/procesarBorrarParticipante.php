<?php
include_once 'conf/BDConexion.php';
include_once 'conf/Constants.php';
include_once 'conf/Log.php';

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

/* elimina chat */

$legajo = $_POST["legajo"];
$chat = $_POST["chat"];
$mensaje = "";

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false;

if ($legajo) {

    /* elimina participantes del chat */

    $participantes = "SELECT * FROM [chatsParticipante] WHERE idChat = $chat AND legajo = $legajo";
    $tieneParticipantes = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $participantes);
    if ($tieneParticipantes) {
        $borraParticipantes = "DELETE [chatsParticipante] WHERE idChat = $chat AND legajo = $legajo";
        $borroParticipantes = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $borraParticipantes);
    } else {
        $borroParticipantes = false;
    }

    if ($borroParticipantes) {
        sqlsrv_commit(BDConexion::getInstancia()->getConexion());
        $mensaje = "<div class='alert alert-success text-center' role='alert'> Participante eliminado con exito <div>";
    } else {
        if ($borroParticipantes) {
            $mensaje = "<div class='alert alert-success text-center' role='alert'> No se pudo borrar el participante solicitado, error en los participantes <div>";
        }
    }
} else {
    $log = new Log();
    $log->writeLine("[No se pudo borrar el chat porque no existe][ID: $legajo]");
    $mensaje = "<div class='alert alert-danger text-center' role='alert'> No se pudo borrar el participante solicitado. Por favor informe del error <div>";
}
?>
<html id="html">
    <head>
        <meta charset="UTF-8">
        <title> SIB </title>
        <link rel="stylesheet" href="../lib/css/bootstrap-toggle.min.css"/>
        <link rel="stylesheet" href="../lib/css/estilos.css"/>
        <link rel="stylesheet" href="../lib/css/bootstrap/bootstrap.css"/>
        <link rel="stylesheet" href="../lib/css/datatables/jquery.dataTables.css">
        <link rel="stylesheet" href="../lib/css/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../lib/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="../lib/JQuery/jquery-3.3.1.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/bootstrap-toggle.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.flash.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/js/loader.js"></script>
        <script type="text/javascript" charset="utf8" src="../lib/JQuery/jquery.tablesorter.min.js"></script>
    </head>
    <body style="background-color:lavender;">
    <navbar id="menu-horizontal" class="navbar navbar-expand-lg navbar-dark" style="background-color: #024d85;">
        <div class="container">
            <span><a href="reportesTablas.php"><img src="../lib/img/cabezera.png" class="img-thumbnail" alt="Responsive image" width="70" height="70"></a></span>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        &nbsp;&nbsp;<h3 class="text-white">Gestion de reportes</h3>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </ul>

                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" value="Usuario: <?= $_SESSION['legajo'] ?>" readonly>
                        <input class="form-control mr-sm-2" type="text" value="<?= $nombreRol; ?>" readonly>
                        <a href="procesarLogout.php"><input type="button" class="btn btn-secondary my-2 my-sm-0" value="Salir"></a>
                    </form>
                </div>
            </div>
        </div>
    </navbar>
    <div class="container">
        <div class="card-header">
            <div class="card-header">
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-12 text-center p-2">
                        <?php echo $mensaje; ?>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <form name=cualquiera method=post action=ingresarChat.php>
                            <input type="hidden" id="chat" name="chat" value="<?= $chat; ?>">
                            <button class="btn btn-lg btn-bsc btn-block" type="submit">VOLVER</button>
                        </form>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>