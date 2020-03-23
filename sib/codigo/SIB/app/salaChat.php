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
    $sql = "SELECT * FROM [chats] WHERE legajo = '$usuario'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
                $html = $html . "<tr>
                    <td>{$row['tema']}</td> 
                    <td>{$fecha}</td>
                    <td>
                    <form name=cualquiera method=post action=ingresarChat.php>
                        <input type=hidden id=chat name=chat value=" . $row['id'] . ">
                        <button class='btn btn-sm btn-outline-info' type='submit'><img src='../lib/img/EYE.png' width='18' height='18'></button> 
                        </form>
                    </td>
                    <td>
                    <form name=cualquiera method=post action=procesarBorrarChat.php>
                        <input type=hidden id=ruta name=ruta value=" . $row['id'] . ">
                        <button class='btn btn-sm btn-outline-info' type='submit'><img src='../lib/img/DELETE.png' width='18' height='18'></button> 
                        </form>
                    </td>
                    </tr>";
            }
        } else {
            $html = $html . "<tr><td COLSPAN=5>No hay chats creados</td></tr>";
        }
    } else {
        $html = $html . "<tr><td COLSPAN=5>No hay chats creados</td></tr>";
    }
    return $html;
}

function lista() {
    $usuario = $_SESSION['legajo'];
    $sql = "SELECT * FROM [usuario] WHERE id_rol NOT IN (1, 2, 3, 4) AND legajo != '$usuario' AND legajo != '01601' AND legajo != '01969' AND legajo != '07488'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
	echo $sql;
    $html = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $html = $html . "<option value='{$row['legajo']}'>{$row['legajo']} -- {$row['nombre']}</option>";
            }
        } else {
            $html = $html . "<option>No hay usuarios disponibles.</option>";
			$log = new Log();
			$log->writeLine("[No se pudo obtener el nombre del rol][QUERY: $sql][USUARIO: $usuario]");
        }
    } else {
        $html = $html . "<option>No hay usuarios disponibles</option>";
		$log = new Log();
		$log->writeLine("[No se pudo obtener el nombre del rol][QUERY: $sql][USUARIO: $usuario]");
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
                setInterval(algo, 6000);
                function algo() {
                    $('#mensajeModal').load('consulta.php');
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
                    <div class="row">
                        <div id="contenido" name="contenido" class="col-lg-12 contenido1">
                            <table id='diariosAltaClientes' class='table table-striped table-bordered' border="3" style="width: 100%">
                                <colgroup>
                                    <col style='width: 25%'/>
                                    <col style='width: 25%'/>
                                    <col style='width: 25%'/>
                                    <col style='width: 25%'/>
                                </colgroup>
                                <thead style='background-color:#024d85;color:white;'>
                                    <tr>
                                        <th>Tema</th>
                                        <th>Fecha</th>
                                        <th>Ingresar</th>
                                        <th>Eliminar</th>
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
                    <div class="row"> <div class="col"> <h5>CREAR CHAT NUEVO</h5> </div>
                        <div class="col">    
                            <?php
                            $sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$usuario' AND estado = 'Pendiente'";
                            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                            if ($result) {
                                if (sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                    echo '<a href="salaChatPendientes.php"><input type="button" class="btn btn-secondary my-2 my-sm-0 btn-danger" value="CHAT PENDIENTE"></a>';
                                } else {
                                    $sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$usuario' AND estado = 'Sin leer'";
                                    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                                    if ($result) {
                                        if (sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                            echo '<a href="salaChatPendientes.php"><input type="button" class="btn btn-secondary my-2 my-sm-0 btn-danger" value="CHAT PENDIENTE"></a>';
                                        } else {
                                            $sql = "SELECT * FROM [chatsParticipante] WHERE legajo = '$usuario' AND estado = 'Leido'";
                                            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
                                            if ($result) {
                                                if (sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                    echo '<a href="salaChatPendientes.php"><input type="button" class="btn btn-secondary my-2 my-sm-0" value="Chat Pendiente"></a>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </div> </div><hr/>
                    <div class="form-group">
                        <form action="creaChat.php" method="post">
                            <label for="descripcionProd" class="col-sm-2 col-form-label" title="Descripci&oacute;n del producto">Nombre de Chat:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="titulo" name="titulo" 
                                       maxlength="150" pattern="[A-Za-záéíóúñÁÉÍÓÚÑ0123456789.,$%/° ]{1,150}"
                                       title="Titulo" placeholder="Titulo">
                            </div>
                            <label class="mr-sm-2" title="Seleccione pulsando Ctrl para elegir mas de un usuario">Lista de Usuarios:</label> 
                            <div class="col">
                                <select multiple id="elegido" class="form-control" name="elegido[]" style="width: 500; height:500" title="Seleccione pulsando Ctrl para elegir mas de un usuario">
<?php
echo lista();
?>
                                </select>
                            </div>
                            <label>
                                <button type="imput" class='btn btn-bsc mt-4' id="juridica">Crear chat</button>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="gsuc/reportesTablas.php"><input type="button" class="btn btn-bsc mt-4" value="Volver"></a>
                            </label>   
                        </form>
                    </div>
					<div class="modal fade" id="mdProcesando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <form action='tratarChat.php' method='post'>
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
                </div>
            </div>
        </div>
        <div id="contenido2"></div>

    </div>
</body>
</html>

