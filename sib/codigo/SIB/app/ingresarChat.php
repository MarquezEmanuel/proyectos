<?php
include_once 'conf/BDConexion.php';
include_once 'conf/Constants.php';
include_once 'conf/Log.php';

session_start();

$legajo = $_SESSION['legajo'];
$sql = "SELECT nombre FROM rol WHERE id_rol = " . $_SESSION['idrol'];
$resultadoRol = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);


if (!$resultadoRol) {
    $log = new Log();
    $log->writeLine("[No se pudo obtener el nombre del rol][QUERY: $sql][USUARIO: $legajo]");
    $_SESSION['mensajeLogin'] = "<div class='alert-danger text-center' role='alert'>No se obtuvo información asociada al rol para cargar menu de usuarios</div>";
    header("Location: ../../index.php");
}


$row = sqlsrv_fetch_array($resultadoRol);
$nombreRol = $row["nombre"];


$chat = $_POST["chat"];

if (!empty($_POST["mensaje"])) {
    $msj = $_POST["mensaje"];
    $mensaje = utf8_decode($msj);
    $nombre = $_POST["envia"];
    $sql = "INSERT chatsMensaje VALUES ('$chat', '$mensaje', '$nombre')";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
}

/* Titulo */

function titulo() {
    global $chat;
    $sqlTitulo = "SELECT tema FROM [chats] WHERE id = $chat";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlTitulo);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "{$row['tema']}";
            }
        } else {
            $html = $html . "";
        }
    } else {
        $html = $html . "";
    }
    return $html;
}

/* Lista participantes */

function participantes() {
    global $chat;
    $sqlParticipante = "SELECT * FROM [chatsParticipante] WHERE idChat = $chat AND estado != 'Creador'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlParticipante);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "<tr>
                    <td>{$row['legajo']}</td>
                    <td>{$row['nombre']}</td>    
                    <td>{$row['estado']}</td>
                    <td>
                    <form name='cualquiera' method='post' action='procesarCambiarEstado.php'>
                        <input type='hidden' id='chat' name='chat' value='" . $chat . "'>
                        <input type='hidden' id='legajo' name='legajo' value='" . $row['legajo'] . "'>
                        <input type='hidden' id='espera' name='espera' value='Espera'>
                        <input type='submit' class='btn btn-primary' value='En espera'>
                        </form>
                    </td>
                    <td>
                    <form name='cualquiera' method='post' action='procesarCambiarEstado.php'>
                        <input type='hidden' id='chat' name='chat' value='" . $chat . "'>
                        <input type='hidden' id='legajo' name='legajo' value='" . $row['legajo'] . "'>
                        <input type='hidden' id='sinLeer' name='sinLeer' value='Sin leer'>
                        <input type='submit' class='btn btn-danger' value='Informar'>
                        </form>
                    </td>
                    <td>
                    <form name='cualquiera' method='post' action='procesarBorrarParticipante.php'>
                        <input type='hidden' id='chat' name='chat' value='" . $chat . "'>
                        <input type='hidden' id='legajo' name='legajo' value='" . $row['legajo'] . "'>
                        <button class='btn btn-sm btn-outline-info' type='submit'><img src='../lib/img/DELETE.png' width='18' height='18'></button> 
                        </form>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "";
        }
    } else {
        $html = $html . "";
    }
    return $html;
}

/* Lista mensajes */

function mensaje() {
    global $chat;
    $sqlParticipante = "SELECT * FROM [chatsMensaje] WHERE idChat = $chat ORDER BY id ASC";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlParticipante);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "<tr>
                    <td>{$row['nombre']}</td>
                    <td>{$row['mensaje']}</td>    
                    </tr>";
            }
        } else {
            $html = $html . "";
        }
    } else {
        $html = $html . "";
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
        <script>
            $(document).ready(function () {
                setInterval(mensaje, 6000);
                function mensaje() {
                    $('#mensajeTabla').load('mensaje.php', {id:<?php echo $chat; ?>});
                }
                setInterval(participan, 6000);
                function participan() {
                    $('#participantesTabla').load('participante.php', {id:<?php echo $chat; ?>});
                }
            });
        </script>
    </head>
    <body style="background-color:lavender;">
    <navbar id="menu-horizontal" class="navbar navbar-expand-lg navbar-dark" style="background-color: #024d85;">
        <div class="container">
            <span><a href="gsuc/reportesTablas.php"><img src="../lib/img/cabezera.png" class="img-thumbnail" alt="Responsive image" width="70" height="70"></a></span>
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
                    <div class="center">
                        <h3 class="text-center"><u><?php echo titulo(); ?></u></h3>
                    </div>
                    <br>
                    <div class="form-group">
                        <form action="ingresarChat.php" method="post">
                            <div class="col" id="mensajeTabla">
                                <table id="mensaje" class="table table-striped table-bordered" border="3" style="width: 100%" style="margin-top: 0px; margin-bottom: 0px; height: 340px;">
                                    <colgroup>
                                        <col style='width: 20%'/>
                                        <col style='width: 80%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Mensaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <input type="hidden" id="chat" name="chat" value="<?= $chat; ?>">
                                    <input type=hidden id="envia" name="envia" value="<?= $_SESSION['legajo'] ?>">
                                    <?php
                                    echo mensaje();
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type='text' class='form-control mb-2' 
                                   id='mensaje' name='mensaje' 
                                   maxlength='150' pattern='[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}'
                                   title='mensaje' placeholder='mensaje'>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <div class="text-center">
                                        <input type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" value="ENVIAR">
                                        <a href="salaChat.php"><input type="button" class="btn btn-outline-secondary" value="SALIR"></a>                                         
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="w-100"><br></div>
                    <div class="row"> <div class="col center"> <h5>PARTICIPANTES</h5> <hr/></div> </div>
                    <div class="row">
                        <div id="participantesTabla" class="col-lg-12 contenido1">
                            <table id='participantes' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 12%'/>
                                    <col style='width: 18%'/>
                                    <col style='width: 16%'/>
                                    <col style='width: 18%'/>
                                    <col style='width: 18%'/>
                                    <col style='width: 18%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Legajo</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Nuevo estado</th>
                                        <th>Nuevo estado</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo participantes();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>                  

                </div>
            </div>
        </div>
    </div>

</body>
</html>



