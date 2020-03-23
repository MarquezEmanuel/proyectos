<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['transacciones'])) {

    $transacciones = $_POST['transacciones'];
    $referencia = $transacciones[0];
    $html = '
    <form method="POST" name="formVincularRTE" id="formVincularRTE">
        <input type="hidden" id="transacciones" name="transaccion" value="' . $referencia . '">
        <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
            <legend class="w-auto" 
                    title="Complete los datos generales de la transacción" 
                    style="font-size: 1em; font-weight: bold;">Sujeto vinculado</legend>
            <div class="container">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Relación fondos:</label> 
                    <div class="col">
                        <select class="form-control" id="rfondos" name="rfondos" title="Relación con los fondos">
                            <option value="Operador/Titular">Operador/Titular</option>
                            <option value="Titular">Titular</option>
                            <option value="Operador">Operador</option>
                            <option value="Vinculado al producto operado">Vinculado con el producto operado</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Rel. Producto:</label> 
                    <div class="col" >
                        <select class="form-control" id="rproducto" name="rproducto" title="Relación con el producto">
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label> 
                    <div class="col">
                        <input type="text" class="form-control"
                               pattern="[0-9]{11}"
                               id="cuit" name="cuit" 
                               placeholder="CUIT/CUIL/CDI" 
                               title="CUIT/CUIL/CDI en caso de numero de documento con 7 dígitos agregar cero aquí" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de persona:</label> 
                    <div class="col">
                        <select class="form-control" id="tipop" name="tipop" title="Tipo de persona">
                            <option value="Persona física">Persona Física</option>
                            <option value="Persona Jurídica">Persona Jurídica</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Apellidos:</label> 
                    <div class="col">
                        <input type="text" class="form-control" 
                               pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
                               id="apellidos" name="apellidos"
                               minlength="1" maxlength="100"
                               placeholder="Apellidos" 
                               title="Apellidos del sujeto vinculado" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombres:</label> 
                    <div class="col">
                        <input type="text" class="form-control" 
                               pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
                               id="nombres" name="nombres"
                               minlength="1" maxlength="100"
                               placeholder="Nombres" 
                               title="Nombres del sujeto vinculado" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo Documento:</label> 
                    <div class="col">
                        <select class="form-control" id="tipodoc" name="tipodoc" title="Tipo de documento del sujeto vinculado">
                            <option value="Documento Nacional de Identidad">DNI</option>
                            <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                            <option value="Libreta Cívica">Libreta cívica</option>
                            <option value="Cédula Mercosur">Cédula Mercosur</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Número:</label> 
                    <div class="col">
                        <input type="text" class="form-control" 
                               pattern="[0-9]{7,12}" 
                               id="dni" name="dni" minlength="7"
                               min="1"
                               placeholder="Número de documento"
                               title="Número de documento del sujeto vinculado" required>
                    </div>
                </div>
            </div>
        </fieldset>
        <br>
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <input type="submit" class="btn btn-success" id="btnVincularRTE" name="btnVincularRTE" value="Agregar">
                    <a href="formBuscarRTE.php">
                        <input type="button" class="btn btn-outline-secondary" id="btnVolverVinculado" name="btnVolverVinculado" value="Volver">
                    </a>
                </div>
            </div>
        </div>
    </form>';
} else {
    /* NO SE RECIBIO POR POST LA TRANSACCION SELECCIONADA */
    $log = new Log();
    $log->writeLine("[Error al recibir parametros por POST]");
    $html = '<div class="alert alert-danger text-center" role="alert"> No se recibieron los datos del formulario de búsqueda </div>';
}

echo '
<h4 class="text-center p-4">AGREGAR SUJETO VINCULADO PARA RTE</h4>
<div class="container">
    ' . $html . '
</div>
<script type="text/javascript" src="../../lib/JQuery/VincularRTE.js"></script>';
