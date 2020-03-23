<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$idOperacion = $_POST['idOperacion'];

$queryOperacion = "SELECT * FROM rte_operacion WHERE idOperacion=" . $idOperacion;
$resultOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryOperacion);

$querySujeto = "SELECT * FROM rte_sujeto WHERE idOperacion=" . $idOperacion;
$resultSujetos = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySujeto);

if ($resultOperacion && $resultSujetos) {

    $operacion = sqlsrv_fetch_array($resultOperacion);

    echo '
    <h4 class="text-center p-4">MODIFICAR REPORTE DE TRANSACCIONES EN EFECTIVO</h4>
    <div id="contenido" class="container">
        <form name="formModificarRTE" id="formModificarRTE" method="POST">
            <input type="hidden" name="idOperacion" id="idOperacion" value="'.$idOperacion.'">
            <input type="hidden" name="nroPersonas" id="nroPersonas" value="'.$operacion['numeroPersonas'].'">
            <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la transacción" 
                        style="font-size: 1.1em; font-weight: bold;">Datos generales de la transacción</legend>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Cuenta inversora:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . $operacion['cuenta'] . '"
                               id="cuenta" name="cuenta"
                               pattern="[0-9]{2}-[0-9]{6}/[0-9]"
                               placeholder="Cuenta inversora" 
                               title="Cuenta inversora asociada a la transacción" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label> 
                    <div class="col">
                        <input type="date" class="form-control" value="' . $operacion['fecha']->format('Y-m-d') . '"
                               id="fecha" name="fecha" 
                               title="Fecha de la transaccíón" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo:</label> 
                    <div class="col">';

    echo '              <select class="form-control" id="tipot" name="tipot" title="Tipo de transacción">';

    if (utf8_encode($operacion['tipo']) == "Depósito") {
        echo '              <option value="Depósito" selected>Depósito</option>
                            <option value="Extracción">Extracción</option>';
    } else {
        echo '              <option value="Depósito">Depósito</option>
                            <option value="Extracción" selected>Extracción</option>';
    }

    echo '              </select>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Moneda: </label> 
                    <div class="col">
                        <select class="form-control" id="moneda" name="moneda" title="Moneda"> ';
    switch (utf8_encode($operacion['moneda'])) {
        case "Peso Argentino":
            echo '          <option value="Peso Argentino" selected>Peso Argentino</option>
                            <option value="Peso Chileno">Peso Chileno</option>
                            <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                            <option value="Euro (Unidad Monetaria Europea)">Euro</option>';
            break;
        case "Peso Chileno":
            echo '          <option value="Peso Argentino">Peso Argentino</option>
                            <option value="Peso Chileno" selected>Peso Chileno</option>
                            <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                            <option value="Euro (Unidad Monetaria Europea)">Euro</option>';
            break;
        case "Dólar Estadounidense":
            echo '          <option value="Peso Argentino">Peso Argentino</option>
                            <option value="Peso Chileno">Peso Chileno</option>
                            <option value="Dólar Estadounidense" selected>Dólar Estadounidense</option>
                            <option value="Euro (Unidad Monetaria Europea)">Euro</option>';
            break;
        case "Euro (Unidad Monetaria Europea)":
            echo '          <option value="Peso Argentino">Peso Argentino</option>
                            <option value="Peso Chileno">Peso Chileno</option>
                            <option value="Dólar Estadounidense">Dólar Estadounidense</option>
                            <option value="Euro (Unidad Monetaria Europea)" selected>Euro</option>';
            break;
    }
    echo '              </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto MO:</label> 
                    <div class="col">
                        <input type="number" class="form-control" value="' . $operacion['montoMo'] . '"
                               id="montomo" name="montomo"
                               min="1"
                               placeholder="Monto total en moneda de origen" 
                               title="Importe total en moneda de origen sin puntos ni comas" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Monto pesos:</label> 
                    <div class="col">
                        <input type="number" class="form-control" value="' . $operacion['montoPesos'] . '"
                               id="montop" name="montop"
                               placeholder="Monto total en pesos" 
                               title="Importe total en pesos sin puntos ni comas" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Provincia:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($operacion['provincia']) . '"
                               id="provincia" name="provincia"
                               minlength="1" maxlength="100"
                               placeholder="Nombre de provincia" 
                               title="Nombre de la provincia" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Localidad:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($operacion['localidad']) . '"
                               id="localidad" name="localidad"
                               minlength="1" maxlength="100"
                               placeholder="Nombre de localidad"
                               title="Nombre de la localidad" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Calle:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($operacion['calle']) . '"
                               id="calle" name="calle"
                               minlength="1" maxlength="100"
                               placeholder="Nombre de calle" 
                               title="Nombre de la calle" required>
                    </div>
                    <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Número:</label> 
                    <div class="col">
                        <input type="number" class="form-control" value="' . $operacion['numero'] . '"
                               id="numero" name="numero"
                               min="1" max="10000"
                               minlength="1" maxlength="5"
                               placeholder="Número de altura"
                               title="Número de la altura" required>
                    </div>
                </div>
            </fieldset>
            <br>
            <fieldset id="datos" class="add border border-dark p-2" style="border-color: #b9b9b9 !important;">
                <legend class="w-auto" 
                        title="Complete los datos generales de la transacción" 
                        style="font-size: 1.1em; font-weight: bold;">Sujetos vinculados a la transacción</legend>';
    $cantidad = 0;
    while ($sujeto = sqlsrv_fetch_array($resultSujetos, SQLSRV_FETCH_ASSOC)) {

        echo '  <br><fieldset class="border border-dark p-2" name="'.$cantidad.'" style="border-color: #b9b9b9 !important;">
                    <legend class="w-auto" 
                            title="Complete los datos generales de la transacción" 
                            style="font-size: 1em; font-weight: bold;">Sujeto vinculado</legend>

                    <input type="hidden" id="idSujeto" name="idSujetos[]" value="'.$sujeto['idSujeto'].'">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Relación fondos:</label> 
                        <div class="col">
                            <select class="form-control" id="rfondos" name="rfondos[]" title="Relación con los fondos">';
        switch ($sujeto['relacionFondo']) {
            case "Titular":
                echo '          
                                <option value="Operador/Titular">Operador/Titular</option>
                                <option value="Titular" selected>Titular</option>
                                <option value="Operador">Operador</option>
                                <option value="Vinculado al producto operado">Vinculado al producto operado</option>';
                break;
            case "Operador":
                echo '          <option value="Operador/Titular">Operador/Titular</option>
                                <option value="Titular">Titular</option>
                                <option value="Operador" selected>Operador</option>
                                <option value="Vinculado al producto operado">Vinculado al producto operado</option>';
                break;
            case "Operador/Titular":
                echo '          <option value="Operador/Titular" selected>Operador/Titular</option>
                                <option value="Titular">Titular</option>
                                <option value="Operador">Operador</option>
                                <option value="Vinculado al producto operado">Vinculado al producto operado</option>';
                break;
            case "Vinculado al producto operado":
                echo '           <option value="Operador/Titular">Operador/Titular</option>
                                <option value="Titular">Titular</option>
                                <option value="Operador">Operador</option>
                                <option value="Vinculado al producto operado" selected>Vinculado al producto operado</option>';
                break;
            default :
                echo '          <option value="Operador/Titular">Operador/Titular</option>
                                <option value="Titular">Titular</option>
                                <option value="Operador">Operador</option>
                                <option value="Vinculado al producto operado">Vinculado al producto operado</option>';
                break;
        }
        echo '              </select>
                        </div>';

        if ($sujeto['relacionFondo'] != "Vinculado al producto operado") {
            echo '      <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Relación producto:</label> 
                        <div class="col" >
                            <select class="form-control" id="rproducto" name="rproducto" title="Relación con el producto">';
            if($sujeto['relacionProducto'] === "SI") {
                echo '          <option value="SI" selected>SI</option>
                                <option value="NO">NO</option>';
            } else {
                echo '          <option value="SI">SI</option>
                                <option value="NO" selected>NO</option>';
            }
            echo '          </select>
                        </div>';
        }
        echo '      </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* CUIT/CUIL/CDI:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="cuit" name="cuit[]"  value="' . $sujeto['cuit'] . '"
                                   placeholder="CUIT/CUIL/CDI" 
                                   title="CUIT CUIL o CDI del sujeto vinculado" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio">* Tipo de persona:</label> 
                        <div class="col">
                            <select class="form-control tipop" id="tipop" name="tipop[]" title="Tipo de persona">';
        if (utf8_encode($sujeto['tipoPersona']) == "Persona física") {
            echo '              <option value="Persona física" selected>Persona Física</option>
                                <option value="Persona Jurídica">Persona Jurídica</option>';
        } else {
            echo '              <option value="Persona física">Persona Física</option>
                                <option value="Persona Jurídica" selected>Persona Jurídica</option>';
        }
        echo '              </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Apellido para persona física / Denominación para persona jurídica">* Apellidos:</label> 
                        <div class="col">
                            <input type="text" class="form-control" 
                                   id="apellidos" name="apellidos[]" value="' . utf8_encode($sujeto['apellidos']) . '"
                                   minlength="1" maxlength="100"
                                   placeholder="Apellidos" 
                                   title="Apellidos del sujeto vinculado" required>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física"> Nombres:</label> 
                        <div class="col">
                            <input type="text" class="form-control nombres'.$cantidad.'" 
                                   id="nombres" name="nombres[]" value="' . utf8_encode($sujeto['nombres']) . '"
                                   minlength="1" maxlength="100"
                                   placeholder="Nombres" 
                                   title="Nombres del sujeto vinculado">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física">Tipo Documento:</label> 
                        <div class="col">
                      <select class="form-control tipodoc'.$cantidad.'" id="tipodoc" name="tipodoc[]" title="Tipo de documento del sujeto vinculado">';
        switch (utf8_encode($sujeto['tipoDocumento'])) {
            case "Documento Nacional de Identidad":
                echo '          <option value="Documento Nacional de Identidad" selected>DNI</option>
                                <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                                <option value="Libreta Cívica">Libreta cívica</option>
                                <option value="Cédula Mercosur">Cédula Mercosur</option>
                                <option value="Pasaporte">Pasaporte</option>';
                break;
            case "Libreta de Enrolamiento":
                echo '          <option value="Documento Nacional de Identidad">DNI</option>
                                <option value="Libreta de Enrolamiento" selected>Libreta de enrolamiento</option>
                                <option value="Libreta Cívica">Libreta cívica</option>
                                <option value="Cédula Mercosur">Cédula Mercosur</option>
                                <option value="Pasaporte">Pasaporte</option>';
                break;
            case "Libreta Cívica":
                echo '          <option value="Documento Nacional de Identidad">DNI</option>
                                <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                                <option value="Libreta Cívica" selected>Libreta cívica</option>
                                <option value="Cédula Mercosur">Cédula Mercosur</option>
                                <option value="Pasaporte">Pasaporte</option>';
                break;
            case "Cédula Mercosur":
                echo '          <option value="Documento Nacional de Identidad">DNI</option>
                                <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                                <option value="Libreta Cívica">Libreta cívica</option>
                                <option value="Cédula Mercosur" selected>Cédula Mercosur</option>
                                <option value="Pasaporte">Pasaporte</option>';
                break;
            case "Pasaporte":
                echo '          <option value="Documento Nacional de Identidad">DNI</option>
                                <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                                <option value="Libreta Cívica">Libreta cívica</option>
                                <option value="Cédula Mercosur">Cédula Mercosur</option>
                                <option value="Pasaporte" selected>Pasaporte</option>';
                break;
            default:
                echo '          <option value="Documento Nacional de Identidad">DNI</option>
                                <option value="Libreta de Enrolamiento">Libreta de enrolamiento</option>
                                <option value="Libreta Cívica">Libreta cívica</option>
                                <option value="Cédula Mercosur">Cédula Mercosur</option>
                                <option value="Pasaporte">Pasaporte</option>';
                break;
        }
        echo '              </select>
                        </div>
                        <label class="col-sm-2 col-form-label" title="Campo obligatorio solo para persona física"> Número:</label> 
                        <div class="col">
                            <input type="text" class="form-control dni'.$cantidad.'" 
                                   id="dni" name="dni[]" value="' . $sujeto['numeroDocumento'] . '"
                                   min="1"
                                   placeholder="Número de documento"
                                   title="Número de documento del sujeto vinculado">
                        </div>
                    </div>
                </fieldset>';
        $cantidad++;
    } /* FIN WHILE */

    echo '  </fieldset>
            <BR>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <input type="submit" class="btn btn-success" id="btnModificarRTE" name="btnModificarRTE" value="Modificar">
                        <a href="formBuscarRTEPF.php"><input type="button" class="btn btn-outline-secondary" value="Cancelar"></a>
                    </div>
                </div>
            </div>   
        </form>
    </div>
    <div id="contenido2"></div>   
    <script type="text/javascript" src="../../lib/JQuery/ModificarRTEPF.js"></script>


</html>';
} else {
    $log = new Log();
    $log->writeLine("[Error al obtener operacion o sujetos vinculados desde la BD][QUERY: $queryOperacion][QUERY: $querySujeto]");
    echo '<div class="alert alert-danger" role="alert"> No se pudo obtener la información del RTE </div>';
}