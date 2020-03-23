<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['transacciones'])) {

    $transacciones = $_POST['transacciones'];
    $referencia = $transacciones[0];

    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $queryTransaccion = "SELECT * FROM rte_transaccion WHERE referencia='" . $referencia . "'";
    $queryVinculado = "SELECT * FROM rte_vinculado WHERE referencia='" . $referencia . "' ORDER BY CASE WHEN relacionFondo = 'Operador' THEN 1 WHEN relacionFondo = 'Operador/Titular' THEN 2 WHEN relacionFondo = 'Titular' THEN 3 WHEN relacionFondo = 'Vinculado al producto operado' THEN 4 END";

    $resultTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTransaccion);
    $resultVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryVinculado, $params, $options);

    if ($resultTransaccion && $resultVinculado) {

        $cantidad = sqlsrv_num_rows($resultVinculado);
        $transaccion = sqlsrv_fetch_array($resultTransaccion);

        $html = '
            <form name="formModificarRTE" id="formModificarRTE" method="POST">
                <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                    <legend class="w-auto" title="Complete los datos generales de la transacción" style="font-size: 1.1em; font-weight: bold;">Datos generales de la transacción</legend>
                    <div class="container">
                        <input type="hidden" name="idOperacion" id="idOperacion" value="' . $referencia . '">
                        <input type="hidden" name="nroPersonas" id="nroPersonas" value="' . $cantidad . '">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Cuenta:</label> 
                            <div class="col">
                                <input type="text" class="form-control" value="' . $transaccion['cuenta'] . '"
                                       id="cuenta" name="cuenta"
                                       pattern="[0-9]{2}-[0-9]{6}/[0-9]"
                                       placeholder="Cuenta inversora" 
                                       title="Cuenta inversora asociada a la transacción" required>
                            </div>
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                            <div class="col">
                                <input type="date" class="form-control" value="' . $transaccion['fecha']->format('Y-m-d') . '"
                                       id="fecha" name="fecha" 
                                       title="Fecha de la transaccíón" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo:</label> 
                            <div class="col">
                                <select class="form-control" id="tipot" name="tipot" title="Tipo de transacción">';
        if (utf8_encode($transaccion['tipo']) == "Depósito") {
            $html = $html . '<option value="Depósito" selected>Depósito</option><option value="Extracción">Extracción</option>';
        } else {
            $html = $html . '<option value="Depósito">Depósito</option> <option value="Extracción" selected>Extracción</option>';
        }
        $html = $html . '
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Moneda: </label> 
                        <div class="col">
                            <select class="form-control" id="moneda" name="moneda" title="Moneda">';
        switch (utf8_encode($transaccion['moneda'])) {
            case "Peso Argentino":
                $html = $html . '
                    <option value="Peso Argentino" selected>Peso Argentino</option>
                    <option value="Peso Chileno">Peso Chileno</option>
                    <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                    <option value="Euro (Unidad Monetaria Europea)">Euro</option>';
                break;
            case "Peso Chileno":
                $html = $html . '
                    <option value="Peso Argentino">Peso Argentino</option>
                    <option value="Peso Chileno" selected>Peso Chileno</option>
                    <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                    <option value="Euro (Unidad Monetaria Europea)">Euro</option>';
                break;
            case "Dólar Estadounidense":
                $html = $html . '          
                    <option value="Peso Argentino">Peso Argentino</option>
                    <option value="Peso Chileno">Peso Chileno</option>
                    <option value="Dólar Estadounidense" selected>Dólar Estadounidense</option>
                    <option value="Euro (Unidad Monetaria Europea)">Euro</option>';
                break;
            case "Euro (Unidad Monetaria Europea)":
                $html = $html . '          
                    <option value="Peso Argentino">Peso Argentino</option>
                    <option value="Peso Chileno">Peso Chileno</option>
                    <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                    <option value="Euro (Unidad Monetaria Europea)" selected>Euro</option>';
                break;
            default:
                $html = $html . '
                    <option value="Peso Argentino" selected>Peso Argentino</option>
                    <option value="Peso Chileno">Peso Chileno</option>
                    <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                    <option value="Euro (Unidad Monetaria Europea)">Euro</option>';
                break;
        }
        $html = $html . ' 
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto de origen:</label> 
                        <div class="col">
                            <input type="number" class="form-control" value="' . $transaccion['montoOrigen'] . '"
                                   id="montomo" name="montomo"
                                   min="1"
                                   placeholder="Monto total en moneda de origen" 
                                   title="Importe total en moneda de origen sin puntos ni comas" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto en pesos:</label> 
                        <div class="col">
                            <input type="number" class="form-control" value="' . $transaccion['montoPesos'] . '"
                                   id="montop" name="montop"
                                   placeholder="Monto total en pesos" 
                                   title="Importe total en pesos sin puntos ni comas" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Provincia:</label> 
                        <div class="col">
                            <input type="text" class="form-control" value="' . utf8_encode($transaccion['provincia']) . '"
                                   id="provincia" name="provincia"
                                   minlength="1" maxlength="100"
                                   placeholder="Nombre de provincia" 
                                   title="Nombre de la provincia" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Localidad:</label> 
                        <div class="col">
                            <input type="text" class="form-control" value="' . utf8_encode($transaccion['localidad']) . '"
                                   id="localidad" name="localidad"
                                   minlength="1" maxlength="100"
                                   placeholder="Nombre de localidad"
                                   title="Nombre de la localidad" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Calle:</label> 
                        <div class="col">
                            <input type="text" class="form-control" value="' . utf8_encode($transaccion['calle']) . '"
                                   id="calle" name="calle"
                                   minlength="1" maxlength="100"
                                   placeholder="Nombre de calle" 
                                   title="Nombre de la calle" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Número:</label> 
                        <div class="col">
                            <input type="number" class="form-control" value="' . $transaccion['numero'] . '"
                                   id="numero" name="numero"
                                   min="1" max="10000"
                                   minlength="1" maxlength="5"
                                   placeholder="Número de altura"
                                   title="Número de la altura" required>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br>
            <fieldset id="datos" class="add border border-dark p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la transacción" 
                        style="font-size: 1.1em; font-weight: bold;">Sujetos vinculados a la transacción (' . $cantidad . ')</legend>
                <div class="container">';
        $contador = 0;
        while ($vinculado = sqlsrv_fetch_array($resultVinculado, SQLSRV_FETCH_ASSOC)) {
            $html = $html . '
                <br>
                <fieldset class="border border-dark p-2" name="' . $contador . '" style="border-color: #b9b9b9 !important;">
                    <legend class="w-auto" title="Complete los datos generales de la transacción" style="font-size: 1em; font-weight: bold;">
                        <button class="removerSujeto btn btn-sm btn-outline-danger text-right" name="' . $vinculado['id'] . '" title"Remover sujeto">
                            <img src="../../lib/img/DELETE.png" width="15" height="15" >
                        </button>
                        Sujeto vinculado N° ' . ($contador + 1) . '</legend>
                    <div class="container">
                    <input type="hidden" id="idSujeto" name="idSujetos[]" value="' . $vinculado['id'] . '">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Rel. con fondos:</label> 
                        <div class="col">
                            <select class="form-control" id="rfondos" name="rfondos[]" title="Relación con los fondos">';
            $html = ($vinculado['relacionFondo'] == 'Operador') ? $html . '<option value="Operador" selected>Operador</option>' : $html . '<option value="Operador">Operador</option>';
            $html = ($vinculado['relacionFondo'] == 'Operador/Titular') ? $html . '<option value="Operador/Titular" selected>Operador/Titular</option>' : $html . '<option value="Operador/Titular">Operador/Titular</option>';
            $html = ($vinculado['relacionFondo'] == 'Titular') ? $html . '<option value="Titular" selected>Titular</option>' : $html . '<option value="Titular">Titular</option>';
            $html = ($vinculado['relacionFondo'] == 'Vinculado al producto operado') ? $html . '<option value="Vinculado al producto operado" selected>Vinculado al producto operado</option>' : $html . '<option value="Vinculado al producto operado">Vinculado al producto operado</option>';
            $html = $html . '
                            </select>
                        </div>';
            if ($vinculado['relacionFondo'] != "Vinculado al producto operado") {
                $html = $html . '  <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Rel. producto:</label> 
                        <div class="col" >
                            <select class="form-control" id="rproducto" name="rproducto" title="Relación con  producto">';
                if ($vinculado['relacionProducto'] === "SI") {
                    $html = $html . '<option value="SI" selected>SI</option> <option value="NO">NO</option>';
                } else {
                    $html = $html . '<option value="SI">SI</option> <option value="NO" selected>NO</option>';
                }
                $html = $html . '      
                            </select>
                        </div>';
            }
            $html = $html . '
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="cuit" name="cuit[]"  value="' . $vinculado['cuil'] . '"
                                   placeholder="CUIT/CUIL/CDI" 
                                   title="CUIT CUIL o CDI del sujeto vinculado" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de persona:</label> 
                        <div class="col">
                            <select class="form-control tipop" id="tipop" name="tipop[]" title="Tipo de persona">';
            if (utf8_encode($vinculado['tipoPersona']) == "Persona física") {
                $html = $html . '<option value="Persona física" selected>Persona Física</option> <option value="Persona Jurídica">Persona Jurídica</option>';
            } else {
                $html = $html . '<option value="Persona física">Persona Física</option> <option value="Persona Jurídica" selected>Persona Jurídica</option>';
            }
            $html = $html . '              
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Apellido para persona física / Denominación para persona jurídica">* Apellidos:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="apellidos" name="apellidos[]" value="' . utf8_encode($vinculado['apellido']) . '"
                                   minlength="1" maxlength="100"
                                   placeholder="Apellidos" 
                                   title="Apellidos del sujeto vinculado" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física"> Nombres:</label> 
                        <div class="col">
                            <input type="text" class="form-control nombres' . $contador . '" 
                                   id="nombres" name="nombres[]" value="' . utf8_encode($vinculado['nombre']) . '"
                                   minlength="1" maxlength="100"
                                   placeholder="Nombres" 
                                   title="Nombres del sujeto vinculado">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física">Tipo Documento:</label> 
                        <div class="col">
                            <select class="form-control tipodoc' . $contador . '" id="tipodoc" name="tipodoc[]" title="Tipo de documento del sujeto vinculado">';
            switch (utf8_encode($vinculado['tipoDocumento'])) {
                case "Documento Nacional de Identidad":
                    $html = $html . '      
                        <option value="Documento Nacional de Identidad" selected>DNI</option>
                        <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                        <option value="Libreta Cívica">Libreta cívica</option>
                        <option value="Cédula Mercosur">Cédula Mercosur</option>
                        <option value="Pasaporte">Pasaporte</option>';
                    break;
                case "Libreta de Enrolamiento":
                    $html = $html . '  
                        <option value="Documento Nacional de Identidad">DNI</option>
                        <option value="Libreta de Enrolamiento" selected>Libreta de enrolamiento</option>
                        <option value="Libreta Cívica">Libreta cívica</option>
                        <option value="Cédula Mercosur">Cédula Mercosur</option>
                        <option value="Pasaporte">Pasaporte</option>';
                    break;
                case "Libreta Cívica":
                    $html = $html . '          
                        <option value="Documento Nacional de Identidad">DNI</option>
                        <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                        <option value="Libreta Cívica" selected>Libreta cívica</option>
                        <option value="Cédula Mercosur">Cédula Mercosur</option>
                        <option value="Pasaporte">Pasaporte</option>';
                    break;
                case "Cédula Mercosur":
                    $html = $html . '          
                        <option value="Documento Nacional de Identidad">DNI</option>
                        <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                        <option value="Libreta Cívica">Libreta cívica</option>
                        <option value="Cédula Mercosur" selected>Cédula Mercosur</option>
                        <option value="Pasaporte">Pasaporte</option>';
                    break;
                case "Pasaporte":
                    $html = $html . '          
                        <option value="Documento Nacional de Identidad">DNI</option>
                        <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                        <option value="Libreta Cívica">Libreta cívica</option>
                        <option value="Cédula Mercosur">Cédula Mercosur</option>
                        <option value="Pasaporte" selected>Pasaporte</option>';
                    break;
                default:
                    $html = $html . '          
                        <option value="Documento Nacional de Identidad">DNI</option>
                        <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                        <option value="Libreta Cívica">Libreta cívica</option>
                        <option value="Cédula Mercosur">Cédula Mercosur</option>
                        <option value="Pasaporte">Pasaporte</option>';
                    break;
            }
            $html = $html . '
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física"> Número:</label> 
                            <div class="col">
                                <input type="text" class="form-control dni' . $contador . '" 
                                       id="dni" name="dni[]" value="' . $vinculado['numeroDocumento'] . '"
                                       min="1"
                                       placeholder="Número de documento"
                                       title="Número de documento del sujeto vinculado">
                            </div>
                        </div>
                    </div>
                </fieldset>';
            $contador++;
        }
        $html = $html . '
                </form>
        <br>
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <input type="submit" class="btn btn-success" id="btnModificarRTE" name="btnModificarRTE" value="Modificar">
                    <a href="formBuscarRTE.php">
                        <input type="button" class="btn btn-outline-secondary" value="Volver">
                    </a>
                    <button class="btn btn-outline-info" id="btnTopModificarRTE" name="btnTopModificarRTE" title="Subir"> 
                        <img src="../../lib/img/TOP.png" width="25" height="25">
                    </button>
                </div>
            </div>
        </div>';
    } else {
        /* ALGUNA DE LAS CONSULTAS A LA BD NO SE REALIZO */
        $log = new Log();
        $log->writeLine("[Error al realizar la consulta con la BD][QUERY: {$queryTransaccion}][QUERY: {$queryVinculado}]");
        $html = '<div class="alert alert-warning text-center" role="alert"> Error al realizar la búsqueda </div>';
    }
} else {
    /* NO SE RECIBIO POR POST LA TRANSACCION SELECCIONADA */
    $log = new Log();
    $log->writeLine("[Error al recibir parametros por POST]");
    $html = '<div class="alert alert-danger text-center" role="alert"> No se recibieron los datos del formulario de búsqueda </div>';
}

echo '
<h4 class="text-center p-4">MODIFICAR RTE</h4>
<div class="container">
    ' . $html . '
</div>
<div id="contenido2" class="container"></div>   
<script type="text/javascript" src="../../lib/JQuery/ModificarRTE.js"></script>
<div class="modal fade" id="mdBorrarSujeto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">ELIMINAR SUJETO VINCULADO</h4>
            </div>
            <div class="modal-body" id="mensaje">
                <label>Confirme la eliminación del sujeto vinculado</label>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="idSujeto" id="idSujeto" value="">
                <input type="submit" class="btn btn-success" style="display:none" id="btnMdAceptar" name="btnMdAceptar" value="Aceptar">
                <input type="submit" class="btn btn-success" id="btnBorrarSujeto" name="btnBorrarSujeto" value="Aceptar">
                <input type="submit" class="btn btn-outline-secondary" id="btnMdCancelar" name="btnMdCancelar" data-dismiss="modal" value="Cancelar">
            </div>
        </div>
    </div>
</div>';

