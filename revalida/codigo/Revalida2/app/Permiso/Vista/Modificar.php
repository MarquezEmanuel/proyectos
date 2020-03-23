<?php
/* FORMULARIO DE MODIFICACION DE UN PERMISO */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['id']) {
    $id = $_POST['id'];
    $permiso = new Permiso($id);
    $resultado = $permiso->obtener();
    if ($resultado == 2) {
        $nombre = $permiso->getNombre();
        $cuerpo = '
            <input type="hidden" name="id" id="id" value="' . $id . '">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $nombre . '"
                           placeholder="Nombre del permiso">
                </div>
            </div>'
                ;
        $boton = '<button type="submit" name="btnModificar" id="btnModificar" disabled class="btn btn-dark">
                    <i class="far fa-save"></i> GUARDAR 
                  </button>';
    } else {
        $mensaje = $permiso->getMensaje();
        $cuerpo = HTML::getAlerta($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = HTML::getAlerta(0, $mensaje);
}
?>
<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">MODIFICAR PERMISO</div>
    <div class="card-body">
        <form name="formModificarPermiso" id="formModificarPermiso" method="POST">
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
