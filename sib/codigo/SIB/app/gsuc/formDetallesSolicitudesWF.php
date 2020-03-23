<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['seleccionado'])) {
    $id = $_POST['seleccionado'];
    $querySolicitud = "SELECT * FROM solicitudesWF WHERE ID = '$id'";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $querySolicitud);
    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $solicitud = sqlsrv_fetch_array($result);
            $fechaAlta = isset($solicitud['FECHAALTA']) ? $solicitud['FECHAALTA']->format('d/m/Y') : "";
            $fechaEstado = isset($solicitud['FECHAESTADO']) ? $solicitud['FECHAESTADO']->format('d/m/Y') : "";
            $producto = isset($solicitud['PRODUCTO']) ? $solicitud['PRODUCTO'] : "";
            $resultado = '
                <div class="container">
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Proceso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['PROCESO'] . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['SUCURSAL'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Fecha de alta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $fechaAlta . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Usuario:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['USUARIO'] . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['CLIENTE'] . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Producto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $producto . '" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Fecha de cambio:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $fechaEstado . '" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Estado:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="' . $solicitud['DESCRIPCION'] . '" readonly>
                        </div>
                    </div>
                </di>';
        } else {
            $resultado = '<div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para la solicitud indicada</div>';
        }
    } else {
        Log::escribirError("[Error al realizar la busqueda para detalle de solicitudes workflow][QUERY: $querySolicitud]");
        $resultado = '<div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    }
} else {
    $resultado = '<div class="alert alert-danger text-center" role="alert"> No se recibió la información del formulario de búsqueda </div>';
}

echo '
    <div class="container">
        <div id="contenido">
            <h3 class="text-center"><u>Solicitudes de workflow</u></h3>
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


