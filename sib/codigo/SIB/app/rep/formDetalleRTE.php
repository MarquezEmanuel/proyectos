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
    $queryVinculado = "SELECT * FROM rte_vinculado WHERE referencia= '" . $referencia . "' ORDER BY CASE WHEN relacionFondo = 'Operador' THEN 1 WHEN relacionFondo = 'Operador/Titular' THEN 2 WHEN relacionFondo = 'Titular' THEN 3 WHEN relacionFondo = 'Vinculado al producto operado' THEN 4 END";

    $resultTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTransaccion);
    $resultVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryVinculado, $params, $options);

    if ($resultTransaccion && $resultVinculado) {

        $cantidad = sqlsrv_num_rows($resultVinculado);
        $transaccion = sqlsrv_fetch_array($resultTransaccion);

        $html = '
        <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
            <legend class="w-auto" style="font-size: 1.1em; font-weight: bold;">Datos generales de la transacción</legend>
            <div class="container">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Cuenta inversora:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . $transaccion['cuenta'] . '"
                               placeholder="Número de cuenta" 
                               title="Cuenta inversora asociada a la transacción" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label">Fecha:</label> 
                    <div class="col">
                        <input type="date" class="form-control" value="' . $transaccion['fecha']->format('Y-m-d') . '"
                               title="Fecha de la transaccíón" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipo:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($transaccion['tipo']) . '"
                               placeholder="Tipo de transacción" 
                               title="Tipo de transacción" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label">Moneda: </label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($transaccion['moneda']) . '"
                               placeholder="Moneda" 
                               title="Moneda de origen" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Monto de origen:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . $transaccion['montoOrigen'] . '"
                               placeholder="Monto en moneda origen" 
                               title="Monto en moneda de origen" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label">Monto en pesos: </label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . $transaccion['montoPesos'] . '"
                               placeholder="Monto en pesos" 
                               title="Monto en pesos" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Provincia:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($transaccion['provincia']) . '"
                               placeholder="Provincia" 
                               title="Nombre de provincia" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label">Localidad: </label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($transaccion['localidad']) . '"
                               placeholder="Localidad" 
                               title="Nombre de localidad" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Calle:</label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . utf8_encode($transaccion['calle']) . '"
                               placeholder="Calle" 
                               title="Nombre de la calle" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label">Número: </label> 
                    <div class="col">
                        <input type="text" class="form-control" value="' . $transaccion['numero'] . '"
                               placeholder="Número" 
                               title="Número de altura para la calle" readonly>
                    </div>
                </div>
            </div>
        </fieldset>
        <br>
        <fieldset class="border p-2" style="border-color: #b9b9b9 !important;">
            <legend class="w-auto" style="font-size: 1.1em; font-weight: bold;">Sujetos vinculados a la transacción (' . $cantidad . ')</legend>
            <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="background-color:#024d85; color:white;">
                        <tr>
                            <th class="text-center align-middle">Relación fondo</th>
                            <th class="text-center align-middle">Relacion producto</th>
                            <th class="text-center align-middle">CUIL CUIT CDI</th>
                            <th class="text-center align-middle">Tipo de persona</th>
                            <th class="text-center align-middle">Nombre</th>
                            <th class="text-center align-middle">Tipo de documento</th>
                            <th class="text-center align-middle">Número de documento</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">';
        while ($vinculado = sqlsrv_fetch_array($resultVinculado, SQLSRV_FETCH_ASSOC)) {
            $relacionProducto = isset($vinculado['relacionProducto']) ? $vinculado['relacionProducto'] : "";
            $html = $html . "
                        <tr>
                            <td class='align-middle'>{$vinculado['relacionFondo']}</td>
                            <td class='align-middle'>{$relacionProducto}</td> 
                            <td class='align-middle'>{$vinculado['cuil']}</td>
                            <td class='align-middle'>" . utf8_encode($vinculado['tipoPersona']) . "</td>
                            <td class='align-middle'>" . utf8_encode($vinculado['apellido']) . " " . utf8_encode($vinculado['nombre']) . "</td> 
                            <td class='align-middle'>" . utf8_encode($vinculado['tipoDocumento']) . "</td>
                            <td class='align-middle'>{$vinculado['numeroDocumento']}</td>
                        </tr>";
        }
        $html = $html . '
                    </tbody>
                </table>
            </div>
            </div>
        </fieldset>';
        if ($cantidad > 5) {
            $html = $html . '
            <div class="alert">
                <div class="col text-center">
                    <a href="formBuscarRTE.php">
                        <input type="button" class="btn btn-outline-secondary" value="Volver">
                    </a>
                    <button class="btn btn-outline-info" id="btnTopDetalleRTE" name="btnTopDetalleRTE" title="Subir"> 
                        <img src="../../lib/img/TOP.png" width="25" height="25">
                    </button>
                </div>
            </div>';
        } else {
            $html = $html . '
            <div class="alert">
                <div class="col text-center">
                   <a href="formBuscarRTE.php">
                        <input type="button" class="btn btn-outline-secondary" value="Volver">
                    </a>
                </div>
            </div>';
        }
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
    $html = '<div class="alert alert-danger" role="alert"> No se recibieron los datos del formulario de búsqueda </div>';
}

echo '
<h4 class="text-center p-4">DETALLE RTE</h4>
<div class="container">
    ' . $html . '
</div>';

