<?php

/* CONSTANTES PARA LAS RUTAS - LOG PARA REGISTRAR Y CONEXION A BASE DE DATOS */
require_once '../conf/Constants.php';
require_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* RECIBE EL IDENTIFICADOR DEL ESTADO */
$idestado = $_POST['idestado'];

/* OBTIENE LA INFORMACION DEL ESTADO DESDE LA BASE DE DATOS */
$query = "SELECT * FROM estado WHERE id_estado=" . $idestado;
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

echo '<h4 class="text-center p-4">MODIFICAR ESTADO</h4>';
if ($result) {
    if (sqlsrv_has_rows($result)) {
        $estado = sqlsrv_fetch_array($result);
        echo '
        <div id="formulario">
            <form id="formModificarEstado" name="formModificarEstado" method="POST">
                <input type="hidden" id="idestado" name="idestado" value="' . $estado['id_estado'] . '">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nombre:</label> 
                    <div class="col">
                        <input type="text" class="form-control mb-2" id="nombreEstado" name="nombreEstado" maxlength="50" value="' . $estado['nombre'] . '" placeholder="Nombre de estado" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Descripción: </label> 
                    <div class="col">
                        <textarea class="form-control mb-2" id="descripcion" name="descripcion" placeholder="Descripción del estado" maxlength="100" required>' . $estado['descripcion'] . '</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-success" id="btnModificarEstado" name="btnModificarEstado" value="Guardar">
                            <a href="formBuscarEstados.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript" charset="utf8" src="../../lib/JQuery/ModificarEstado.js"></script>';
    } else {
        $log = new Log();
        $log->writeLine("[No se obtuvo el registro de estado de la base de datos][Query: {$query}]");
        echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información del estado </div>';
    }
} else {
    $log = new Log();
    $log->writeLine("[No se pudo ejecutar la consulta a la base de datos][Query: {$query}]");
    echo '<div class="alert alert-danger text-center" role="alert"> Error al realizar búsqueda de estado </div>';
}