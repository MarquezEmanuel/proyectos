<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */

$idTransaccion = $_POST['seleccionado'];


/* empieza la transaccion */

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* PREPARA LOS UPDATE PARA EJECUTAR */

if ($idTransaccion) {
    $sqlAlta = "DELETE cuentasComitentesAltas WHERE idCuentaComitente =" . $idTransaccion;
    $eliminaAlta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlAlta);


    $sqlBaja = "DELETE cuentasComitentesBajas WHERE idCuentaComitente =" . $idTransaccion;
    $eliminaBaja = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlBaja);

    $sqlComitente = "DELETE cuentasComitentes WHERE idCuentaComitente =" . $idTransaccion;
    $eliminaComitente = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sqlComitente);
} else {
    echo $mensaje = "No se obutvieron los datos del reporte";
}

$html = '';
if ($eliminaAlta && $eliminaBaja && $eliminaComitente) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                        <h1><u>Cuenta Comitente eliminado con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
        return $html;
    }

} else {
    $log = new Log();
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

    if (!$eliminaAlta) {
        function mensaje() {
            $log->writeLine("[Error al borrar alta cliente cuenta comitente de la BD][INFO: $eliminaAlta][SQL: $sqlAlta]");
            $html = '
                    <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Eliminar un Alta de Cliente</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
                    ';
            return $html;
        }

    } else {
        if (!$eliminaBaja) {
            function mensaje() {
                $log->writeLine("[Error al borrar baja cliente cuenta comitente de la BD][INFO: $eliminaBaja][SQL: $sqlBaja]");
                $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Eliminar una Baja de Cliente</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
                    ';
                return $html;
            }
        } else {
            if (!$eliminaComitente) {
                function mensaje() {
                    $log->writeLine("[Error al borrar una cuenta comitente de la BD][INFO: $eliminaComitente][SQL: $eliminaComitente]");
                    $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Eliminar Una Cuenta Comitente</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
                    ';
                    return $html;
                }
            }
        }
    }
}
?>

<body id="body">
    <div class="card-header">
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-12 text-center">
                <h5 class="text-center"><u><?php echo $output = mensaje(); ?></u></h5>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formAltaCliente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear Cuenta Comitente Alta Cliente</button></a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBajaCliente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear Cuenta Comitente Baja Cliente</button></a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="formBuscarCuentaComitente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar Cuenta Comitente</button></a>
            </div>
        </div>
        <br>
        <div class="form-row align-items-center mx-auto">
            <div class="col-lg-2 text-center">
            </div>
            <div class="col-lg-8 text-center">
                <a href="cargarCuentaComitente.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button></a>
            </div>
        </div>
        <br>
    </div>
</body>

</html>


