<?php
/* FORMULARIO DE MODIFICACION DE UNA APLICACION */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();
session_start();

$boton = "";
if ($_POST['id']) {
    $id = $_POST['id'];
    $aplicacion = new Aplicacion($id);
    $resultado = $aplicacion->obtener();
    if ($resultado == 2) {
        $nombre = $aplicacion->getNombre();
        $gerencia = $aplicacion->getPropietario();
        $estado = $aplicacion->getEstado();
        $opcionesEstado = ($estado == 1) ? "<option value='1' selected>Activo</option>" : "<option value='1'>Activo</option>";
        $opcionesEstado .= ($estado == 2) ? "<option value='2' selected>Inactivo</option>" : "<option value='2'>Inactivo</option>";
        $cuerpo = '
            <input type="hidden" name="id" id="id" value="' . $id . '">
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Nombre: </label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" maxlength="50"
                           value="' . $nombre . '"
                           placeholder="Nombre de la aplicación">
                </div>
                <label class="col-sm-2 col-form-label">Gerencia: </label>
                <div class="col">
                    <select class="form-control mb-2" name="gerencia" id="gerencia">
                        <option value="' . $gerencia->getId() . '">' . $gerencia->getNombre() . '</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label">Estado: </label>
                <div class="col">
                    <select class="form-control mb-2" name="estado" id="estado">' . $opcionesEstado . '</select>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>';
        $boton = '<button type="submit" class="btn btn-dark" name="btnModificar" id="btnModificar" disabled >
                    <i class="far fa-save"></i> GUARDAR
                  </button>';
    } else {
        $mensaje = $aplicacion->getMensaje();
        $cuerpo = HTML::getAlerta($resultado, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = HTML::getAlerta(0, $mensaje);
}
?>
<div id="resultado" class="mb-4 mt-4"></div>
<div class="card">
    <div class="card-header text-white bg-dark">MODIFICAR APLICACIÓN</div>
    <div class="card-body">
        <form name="formModificarAplicacion" id="formModificarAplicacion" method="POST">
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
