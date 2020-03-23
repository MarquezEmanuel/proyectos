<?php
/* CREAR NUEVO ROL */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
$controlador = new ControladorPermiso();

$permisos = $controlador->listar();
if (gettype($permisos) == "resource") {
    $filas = "";
    while ($permiso = sqlsrv_fetch_array($permisos, SQLSRV_FETCH_ASSOC)) {
        $filas .= "
            <tr>
                <td class='text-center'>
                    <input type='checkbox' name='permisos[]' id='permisos' value='" . $permiso['id'] . "'>
                </td>
                <td>" . utf8_encode($permiso['nombre']) . "</td>
                <td>" . utf8_encode($permiso['nivel']) . "</td>
            </tr>";
    }
    $tablaPermisos = '
        <div class="table-responsive">
            <table id="tbPermisos" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" name="cbTodosPermisos" id="cbTodosPermisos">
                        </th>
                        <th>Nombre</th>
                        <th>Nivel</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    /* AGREGAR ESTILO SANTIAGO */
    $tablaPermisos = $controlador->getMensaje();
}
?>
<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">NUEVO ROL</div>
    <div class="card-body">
        <form name="formCrearRol" id="formCrearRol" method="POST">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           placeholder="Nombre del rol" required>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Permisos: </label>
                <div class="col"><?= $tablaPermisos; ?></div>
            </div>
            <div class="form-row mt-4">
                <div class="col text-center">
                    <button type="button" class="btn btn-outline-secondary" id="btnVolver" name="bntVolver">
                        <i class="fas fa-arrow-left"></i> VOLVER
                    </button>
                    <button type="submit" class="btn btn-dark">
                        <i class="far fa-save"></i> GUARDAR
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../Js/Crear.js"></script>