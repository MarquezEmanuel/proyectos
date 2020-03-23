<?php
/* FORMULARIO DE MODIFICACION DE UNA GERENCIA */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['id']) {
    $id = $_POST['id'];
    $gerencia = new Gerencia($id);
    $controlador = new ControladorGerencia();
    $resultado = $gerencia->obtener();
    if ($resultado == 2) {
        $nombre = $gerencia->getNombre();
        $delegado = $gerencia->getDelegado();
        $subdelegado = $gerencia->getSubDelegado();
        $estado = $gerencia->getEstado();

        $opcDelegado = ($delegado) ? "<option value='" . $delegado->getId() . "'>" . $delegado->getNombre() . ", " . $delegado->getApellido() . "</option>" : "";
        $opcSubdelegado = ($subdelegado) ? "<option value='" . $subdelegado->getId() . "'>" . $subdelegado->getNombre() . ", " . $subdelegado->getApellido() . "</option>" : "";

        $opcEstado = ($estado == 1) ? "<option value='1' selected>Activo</option>" : "<option value='1'>Activo</option>";
        $opcEstado .= ($estado == 2) ? "<option value='2' selected>Inactivo</option>" : "<option value='2'>Inactivo</option>";
        $cuerpo = '
            <input type="hidden" name="id" id="id" value="' . $id . '">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" required maxlength="50"
                           value="' . $nombre . '">
                </div>
                <label class="col-sm-2 col-form-label">Delegado: </label>
                <div class="col">
                    <select class="form-control mb-2" name="delegado" id="delegado">' . $opcDelegado . '</select>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Subdelegado: </label>
                <div class="col">
                    <select class="form-control mb-2" name="subdelegado" id="subdelegado">' . $opcSubdelegado . '</select>
                </div>
                <label class="col-sm-2 col-form-label">Estado: </label>
                <div class="col">
                    <select class="form-control mb-2" name="estado" id="estado">' . $opcEstado . '</select>
                </div>
            </div>';
        $boton = '<button type="submit" name="btnModificar" id="btnModificar" disabled class="btn btn-dark">
                    <i class="far fa-save"></i> GUARDAR 
                  </button>';
    } else {
        $mensaje = $gerencia->getMensaje();
        $cuerpo = HTML::getAlerta($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = HTML::getAlerta(0, $mensaje);
}
?>
<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header bg-dark text-white">MODIFICAR GERENCIA</div>
    <div class="card-body">
        <form name="formModificarGerencia" id="formModificarGerencia" method="POST">
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