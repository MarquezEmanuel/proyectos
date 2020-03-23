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

function chats() {
    $usuario = $_SESSION['legajo'];
    $sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$usuario' AND estado != 'Creador'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $chat = "SELECT * FROM [chats] WHERE id =" . $row['idChat'];
                $resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $chat);
                if ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                    $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
                    $html = $html . "<tr>
                    <td>{$row['tema']}</td>   
                    <td>{$fecha}</td>
                    <td>
                    <form name=cualquiera method=post action=tratarChat.php>
                        <input type=hidden id=chat name=chat value=" . $row['id'] . ">
                        <button class='btn btn-sm btn-outline-info' type='submit'><img src='../lib/img/EYE.png' width='18' height='18'></button> 
                        </form>
                    </td>
                    </tr>";
                }
            }
        } else {
            $html = $html . "<tr><td COLSPAN=4>No hay chats pendientes</td></tr>";
        }
    } else {
        $html = $html . "<tr><td COLSPAN=4>No hay chats pendientes</td></tr>";
    }
    return $html;
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
            <span><a href="<?php
                switch ($nombreRol) {
                    case "MONITOR":
                        echo "gsuc/reportesTablas.php";
                        break;
                    case "REPSUC01":
						$_SESSION['sucursal'] = 1;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC05":
                        $_SESSION['sucursal'] = 5;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC10":
                        $_SESSION['sucursal'] = 10;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC15":
                        $_SESSION['sucursal'] = 15;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC20":
                        $_SESSION['sucursal'] = 20;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC25":
                        $_SESSION['sucursal'] = 25;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC30":
                        $_SESSION['sucursal'] = 30;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC40":
                        $_SESSION['sucursal'] = 40;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC41":
                        $_SESSION['sucursal'] = 41;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC45":
                        $_SESSION['sucursal'] = 45;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC50":
                        $_SESSION['sucursal'] = 50;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC55":
                        $_SESSION['sucursal'] = 55;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC60":
                        $_SESSION['sucursal'] = 60;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC70":
                        $_SESSION['sucursal'] = 70;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC80":
                        $_SESSION['sucursal'] = 80;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC85":
                        $_SESSION['sucursal'] = 85;
                        echo "suc/inicioSucursal.php";
                        break;
                }
                ?>"><img src="../lib/img/cabezera.png" class="img-thumbnail" alt="Responsive image" width="70" height="70"></a></span>
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
            <div id="centro" class="container">
                <div class="col-lg-12">
                    <div class="row">
                        <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                            <table id='diariosAltaClientes' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 33%'/>
                                    <col style='width: 33%'/>
                                    <col style='width: 33%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Tema</th>
                                        <th>Fecha</th>
                                        <th>Ingresar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo chats();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="w-100"><br></div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <a href="<?php
                            switch ($nombreRol) {
                                case "MONITOR":
                        echo "gsuc/reportesTablas.php";
                        break;
                    case "REPSUC01":
						$_SESSION['sucursal'] = 1;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC05":
                        $_SESSION['sucursal'] = 5;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC10":
                        $_SESSION['sucursal'] = 10;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC15":
                        $_SESSION['sucursal'] = 15;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC20":
                        $_SESSION['sucursal'] = 20;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC25":
                        $_SESSION['sucursal'] = 25;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC30":
                        $_SESSION['sucursal'] = 30;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC40":
                        $_SESSION['sucursal'] = 40;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC41":
                        $_SESSION['sucursal'] = 41;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC45":
                        $_SESSION['sucursal'] = 45;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC50":
                        $_SESSION['sucursal'] = 50;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC55":
                        $_SESSION['sucursal'] = 55;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC60":
                        $_SESSION['sucursal'] = 60;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC70":
                        $_SESSION['sucursal'] = 70;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC80":
                        $_SESSION['sucursal'] = 80;
                        echo "suc/inicioSucursal.php";
                        break;
                    case "REPSUC85":
                        $_SESSION['sucursal'] = 85;
                        echo "suc/inicioSucursal.php";
                        break;
                            }
                            ?>"><input type="button" class="btn btn-outline-secondary" value="SALIR"></a>                                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="contenido2">
        </div>
    </div>
</body>
</html>

