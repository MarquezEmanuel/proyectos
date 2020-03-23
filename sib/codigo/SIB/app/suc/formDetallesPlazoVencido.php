<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['seleccionado'])) {
    $id = $_POST['seleccionado'];
    $querySolicitud = "SELECT * FROM plazoVencidoSAV WHERE ID = '$id'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitud);
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $solicitud = sqlsrv_fetch_array($result);
            $tipo = utf8_encode($solicitud['TIPO']);
            $titular = utf8_encode($solicitud['TITULAR']);
            $resultado = '
                <div class="container">
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Titular:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $titular . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['SUCURSAL'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Tipo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $tipo . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Numero Inicial:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['NROINICIAL'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Numero Final:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['NROFINAL'] . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Fecha de Ingreso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['FECHAINGRESO'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Fecha de Destruccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['FECHADESTRUCCION'] . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Dias Vencido:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['PLAZODIAS'] . '" readonly>
                        </div>
                    </div>
                </di>';
        } else {
            $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para la solicitud indicada</div>';
        }
    } else {
        Log::escribirError("[Error al realizar la busqueda para detalle de plazo vencido en SAV][QUERY: $querySolicitud]");
        $resultado = '<div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    }
} else {
    $resultado = '<div class="alert alert-danger text-center" role="alert"> No se recibió la información del formulario de búsqueda </div>';
}

echo '
    <div class="container">
        <div id="contenido">
            <h3 class="text-center"><u>Plazo Vencido en SAV</u></h3>
            <div id="centro" class="container">
                <br><br>
                ' . $resultado . '
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <a href=""><input type="button" class="btn btn-dark" value="Volver"></a>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>';


