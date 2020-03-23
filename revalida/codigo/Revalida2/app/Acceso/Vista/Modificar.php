<?php
/* FORMULARIO DE MODIFICACION DE UN ACCESO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['id']) {
    $id = $_POST['id'];
    $usuario = new UsuarioAcceso($id);
    $resultado = $usuario->obtener();
    if ($resultado == 2) {
        $legajo = $usuario->getLegajo();
        $nombre = $usuario->getNombre();
        $perfil = $usuario->getPerfil();
        $estado = $usuario->getEstado();

        $cuerpo = '<input type="hidden" name="id" id="id" value="' . $id . '">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Legajo: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="legajo" id="legajo"
                           maxlength="10" value="' . $legajo . '"
                           placeholder="Legajo de usuario" required>
                </div>
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre"
                           maxlength="50"  value="' . $nombre . '"
                           placeholder="Nombre de usuario" required>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Perfil: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="perfil" id="perfil"
                           maxlength="50"  value="' . $perfil . '"
                           placeholder="Perfil asignado">
                </div>
                <label class="col-sm-2 col-form-label">Estado: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="estado" id="estado"
                           maxlength="20"  value="' . $estado . '"
                           placeholder="Estado en la aplicación">
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-dark" 
                          name="btnModificar" id="btnModificar" disabled >
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
    <div class="card-header text-white bg-dark">MODIFICAR ACCESO DE USUARIO</div>
    <div class="card-body">
        <form name="formModificarAcceso" id="formModificarAcceso" method="POST">
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