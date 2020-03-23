<?php
/* FORMULARIO DE MODIFICACION DE UN SERVICIO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['id']) {
    $id = $_POST['id'];
    $rol = new Rol($id);
    $controlador = new ControladorPermiso();
    $resultado = $rol->obtener();
    $permisos = $controlador->listar();
    if (($resultado == 2) && (gettype($permisos) == "resource")) {
        $nombre = $rol->getNombre();
        $menuesPerfil = $rol->getPermisos();
        $permisosPerfil = array();
        foreach ($menuesPerfil as $menu) {
            $permisosPerfil[] = $menu[0];
            $submenuesPerfil = $menu[2];
            foreach ($submenuesPerfil as $submenu) {
                $permisosPerfil[] = $submenu[0];
            }
        }
        $filas = "";
        while ($permiso = sqlsrv_fetch_array($permisos, SQLSRV_FETCH_ASSOC)) {
            $check = (in_array($permiso['id'], $permisosPerfil)) ? "checked" : "";
            $filas .= "
            <tr>
                <td class='text-center'>
                    <input type='checkbox' name='permisos[]' id='permisos' value='" . $permiso['id'] . "' $check>
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

        $cuerpo = '
            <input type="hidden" name="id" id="id" value="' . $id . '">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           placeholder="Nombre del rol" 
                           value="' . $nombre . '" required>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Permisos: </label>
                <div class="col">' . $tablaPermisos . '</div>
            </div>';
        $boton = '<button type="submit" name="btnModificar" id="btnModificar" disabled class="btn btn-dark">
                    <i class="far fa-save"></i> GUARDAR 
                  </button>';
    } else {
        $mensaje = $rol->getMensaje();
        $cuerpo = HTML::getAlerta($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = HTML::getAlerta(0, $mensaje);
}
?>
<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">MODIFICAR ROL</div>
    <div class="card-body">
        <form name="formModificarRol" id="formModificarRol" method="POST">
            <?= $cuerpo; ?>
            <div class="form-row mt-4">
                <div class="col text-center">
                    <button type="button" class="btn btn-outline-secondary" id="btnVolver" name="bntVolver">
                        <i class="fas fa-arrow-left"></i> VOLVER
                    </button>
                    <?= $boton; ?>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../Js/Modificar.js"></script>

