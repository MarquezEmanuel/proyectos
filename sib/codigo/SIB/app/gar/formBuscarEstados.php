<?php

/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

if (!isset($_SESSION['user'])) {
    /* NO SE HA LOGEADO - NO TIENE PERMISOS */
    $log = new Log();
    $log->writeLine("[No hay usuario en sesion para mostrar el formulario][Redirecciona: index]");
    header('Location: ../../index.php');
}

/* CONSULTA TODOS LOS ESTADOS GUARDADOS EN LA BASE DE DATOS */
$query = "SELECT * FROM estado";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

/* AGREGA LA CABECERA CON EL MENU */
require_once './menuGarantias.php';
?>

<div class="card-header">

    <div id="contenido">
        <h4 class="text-center p-4">BUSCAR ESTADOS</h4>
        <form>
            <input type='submit' class='btn btn-success p-2' id='btnNuevoEstado' name='btnNuevoEstado' value='Nuevo estado'><br>
        </form>
        <br>
        <?php
        if ($result) {
            if (sqlsrv_has_rows($result)) {
                echo "
                    <input type='hidden' id='seleccionado' name='seleccionado' value=''>
                    <table id='tablaEstados' class='table table-bordered' >
                        <thead style='background-color:#739cc7;'>
                            <tr>
                                <th class='text-center'>Nombre</th>
                                <th class='text-center'>Descripción</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    echo"
                        <tr>
                            <td>{$row['nombre']}</td>
                            <td>{$row['descripcion']}</td>    
                            <td class='text-center' title='Elimina el estado'>
                                <form method='POST' class='borrarEstado' name='{$row['id_estado']}' action=''>
                                    <button class='btn btn-sm btn-outline-danger'> 
                                        <img src='../../lib/img/DELETE.png' width='18' height='18' > 
                                    </button>
                                </form>
                            </td>
                            <td class='text-center' title='Ir a la modificación del estado'>
                                <button class='btn btn-sm btn-outline-warning'> 
                                    <img src='../../lib/img/EDIT.png' class='modificarEstado' name='{$row['id_estado']}' width='18' height='18' > 
                                </button>
                            </td>
                        </tr>";
                }
                echo'</tbody>
                    </table>';
            } else {
                echo '<div class="alert alert-warning text-center" role="alert"> No se encontraron resultados </div>';
            }
        } else {
            echo '<div class="alert alert-danger text-center" role="alert"> Error al realizar búsqueda </div>';
        }
        ?>
    </div>
    <div id="contenido2" name="contenido2"></div>
    <?php
    include_once './modalCargarEstado.php';
    include_once '../modalBorrar.php';
    ?>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/BuscarEstado.js"></script>
</html>