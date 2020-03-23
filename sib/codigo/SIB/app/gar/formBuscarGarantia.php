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
$estados = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

/* AGREGA LA CABECERA CON EL MENU */
require_once './menuGarantias.php';
?>

<div class="card-header">
    <div id="contenido">
        <h4 class="text-center p-4">BUSCAR GARANTIA</h4>
        <div id="centro" class="container">
            <form id="formBuscarGtia" name="formBuscarGtia" method="POST">
                <?php 
                if($estados && sqlsrv_has_rows($estados)) {
                    echo '<div class="row">
                        <div class="col">
                            <label class="mr-sm-2">Sucursal:</label> 
                            <input type="number" class="form-control" 
                                id="numSucursal" name="numSucursal" 
                                min="1" maxlength="10"
                                placeholder="Sucursal"
                                title "Numero de sucursal">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Sav:</label> 
                            <input type="number" class="form-control" 
                                    id="numSav" name="numSav"
                                    min="1"
                                    placeholder="SAV" 
                                    title="N&uacute;mero de valor no numerario(SAV)">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Estado:</label> 
                            <select id="selectEstado" class="form-control" name="selectEstado" title="Estado de la operaci&oacute;n y la garant&iacute;a">';
                    while ($row = sqlsrv_fetch_array($estados, SQLSRV_FETCH_ASSOC)) {
                        echo "<option value='{$row['id_estado']}'>{$row['nombre']}</option>";
                    }
                    echo'        </select>
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Numero de cliente:</label> 
                            <input type="number" class="form-control" 
                                    id="numNroCliente" name="numNroCliente"
                                    min="1"
                                    placeholder="N&uacute;mero de cliente" title="N&uacute;mero de cliente">
                        </div>
                        <div class="col">
                            <label class="mr-sm-2">Nombre de cliente:</label> 
                            <input type="text" class="form-control" 
                                    id="txtNomCliente" name="txtNomCliente" 
                                    pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                                    placeholder="Nombre de cliente" title="Nombre de cliente">
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <input type="submit" class="btn btn-success" id="btnBuscarGtia" name="btnBuscarGtia" value="Buscar" class="btn btn-bsc mt-4">
                                <a href="formBuscarGarantia.php"><input type="button" class="btn btn-outline-secondary" id="" name="" value="Cancelar"></a>
                            </div>
                        </div>
                    </div>';
                } else {
                    echo '<div class="alert alert-warning text-center" role="alert"> No se obtuvieron estados para cargar el formulario </div>';
                }
                ?>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2"></div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="../../lib/JQuery/BuscarGarantia.js"></script>
</html>