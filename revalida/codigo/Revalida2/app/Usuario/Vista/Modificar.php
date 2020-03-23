<?php
/* FORMULARIO DE MODIFICACION DE UN SERVICIO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['id']) {
    $legajo = $_POST['id'];
    $usuario = new Usuario(NULL, NULL, NULL, $legajo);
    $resultado = $usuario->obtener();
    if ($resultado == 2) {
        $id = $usuario->getId();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $legajo = $usuario->getLegajo();
        $cargo = $usuario->getCargo();
        $gerencia = $usuario->getGerencia();
        $rol = $usuario->getRol();
        $estado = $usuario->getEstado();

        $opcEstado = ($estado == 1) ? "<option value='1' selected>Activo</option>" : "<option value='1'>Activo</option>";
        $opcEstado .= ($estado == 0) ? "<option value='0' selected>Inactivo</option>" : "<option value='0'>Inactivo</option>";
        $cuerpo = '
            <input type="hidden" name="id" id="id" value="' . $id . '">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           placeholder="Nombre del usuario"
                           value="' . $nombre . '" required>
                </div>
                <label class="col-sm-2 col-form-label">Apellido: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="apellido" id="apellido" maxlength="50"
                           placeholder="Apellido del usuario" 
                           value="' . $apellido . '" required>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Legajo: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="legajo" id="legajo" maxlength="10"
                           placeholder="Legajo del usuario" 
                           value="' . $legajo . '" required>
                </div>
                <label class="col-sm-2 col-form-label">Cargo: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="cargo" id="cargo" maxlength="50"
                           placeholder="Cargo" 
                           value="' . $cargo . '" required>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Gerencia: </label>
                <div class="col">
                    <select class="form-control mb-2" name="gerencia" id="gerencia">
                        <option value="' . $gerencia->getId() . '">' . $gerencia->getNombre() . '</option>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Rol: </label>
                <div class="col">
                    <select class="form-control mb-2" name="rol" id="rol">
                        <option value="' . $rol->getId() . '">' . $rol->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Estado: </label>
                <div class="col">
                    <select class="form-control mb-2" name="estado" id="estado">"' . $opcEstado . '"</select>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>';
        $boton = '<button type="submit" name="btnModificar" id="btnModificar" disabled class="btn btn-dark">
                    <i class="far fa-save"></i> GUARDAR 
                  </button>';
    } else {
        $mensaje = $usuario->getMensaje();
        $cuerpo = HTML::getAlerta($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = HTML::getAlerta(0, $mensaje);
}
?>
<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">MODIFICAR USUARIO</div>
    <div class="card-body">
        <form name="formModificarUsuario" id="formModificarUsuario" method="POST">
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

