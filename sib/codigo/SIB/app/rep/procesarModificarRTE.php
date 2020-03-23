<?php

/* INCLUYE LOS ARCHIVOS A UTILIZAR */
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$formulario = "";
if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
    /* ERROR AL INICIAR LA TRANSACCION CON LA BD. SE CANCELA LA OPERACION */
    $log = new Log();
    $log->writeLine("[Error al inicializar la transaccion (begin_transaction)]");
    $div = '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
} else {
    /* SE OBTIENEN LOS CAMPOS (Y ARREGLOS) DESDE EL FORMULARIO */
    $idOperacion = $_POST['idOperacion'];
    $cuenta = $_POST['cuenta'];
    $fecha = $_POST['fecha'] . "T00:00:00";
    $tipo = utf8_decode($_POST['tipot']);
    $moneda = utf8_decode($_POST['moneda']);
    $montoMO = $_POST['montomo'];
    $montoPesos = $_POST['montop'];
    $personas = $_POST['nroPersonas'];
    $provincia = utf8_decode($_POST['provincia']);
    $localidad = utf8_decode($_POST['localidad']);
    $calle = utf8_decode($_POST['calle']);
    $numero = $_POST['numero'];
    $fondos = $_POST['rfondos'];
    $producto = isset($_POST['rproducto']) ? $_POST['rproducto'] : "SI";
    $cuit = $_POST['cuit'];
    $tipop = $_POST['tipop'];
    $apellidos = $_POST['apellidos'];
    $nombres = $_POST['nombres'];
    $tipoDoc = $_POST['tipodoc'];
    $dni = $_POST['dni'];
    $idSujetos = $_POST['idSujetos'];

    $queryTransaccion = "UPDATE rte_transaccion SET cuenta='$cuenta', fecha='$fecha', tipo='$tipo', "
            . "moneda='$moneda', montoOrigen=$montoMO, montoPesos=$montoPesos, provincia='$provincia', "
            . "localidad='$localidad', calle='$calle', numero='$numero' WHERE referencia='" . $idOperacion . "'";
    $resultTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTransaccion);

    if ($resultTransaccion) {
        /* SE REALIZO LA MODIFICACION DE LA TRANSACCION. CONTINUA CON LOS SUJETOS VINCULADOS */
        $posicion = 0;
        $modificaciones = true;
        for ($i = 0; $i < $personas; $i++) {
            /* RECORRE PARA CADA UNO DE LOS SUJETOS VINCULADOS */
            $idSujeto = $idSujetos[$i];
            $tipoPersona = utf8_decode($tipop[$i]);
            $apellido = utf8_decode($apellidos[$i]);
            if ($fondos[$i] === "Vinculado al producto operado") {
                if ($tipop[$i] === "Persona física") {
                    $nombre = utf8_decode($nombres[$i]);
                    $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                    $posicion++;
                    $set = "UPDATE rte_vinculado "
                            . "SET relacionFondo='$fondos[$i]', relacionProducto='', "
                            . "cuil='$cuit[$i]', tipoPersona='$tipoPersona', apellido='$apellido', "
                            . "nombre='$nombre', tipoDocumento='$tipoDocumento', "
                            . "numeroDocumento='$dni[$i]' WHERE id=$idSujeto";
                } else {
                    $set = "UPDATE rte_vinculado "
                            . "SET relacionFondo='$fondos[$i]', relacionProducto='', "
                            . "cuil='$cuit[$i]', tipoPersona='$tipoPersona', apellido='$apellido', "
                            . "nombre='', tipoDocumento='', numeroDocumento='' WHERE id=$idSujeto";
                }
            } else {
                if ($tipop[$i] === "Persona física") {
                    $nombre = utf8_decode($nombres[$i]);
                    $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                    $posicion++;
                    $set = "UPDATE rte_vinculado "
                            . "SET relacionFondo='$fondos[$i]', relacionProducto='$producto', "
                            . "cuil='$cuit[$i]', tipoPersona='$tipoPersona', apellido='$apellido', "
                            . "nombre='$nombre', tipoDocumento='$tipoDocumento', "
                            . "numeroDocumento='$dni[$i]' WHERE id=$idSujeto";
                } else {
                    $set = "UPDATE rte_vinculado "
                            . "SET relacionFondo='$fondos[$i]', relacionProducto='$producto', "
                            . "cuil='$cuit[$i]', tipoPersona='$tipoPersona', apellido='$apellido', "
                            . "nombre='', tipoDocumento='', numeroDocumento='' WHERE id=$idSujeto";
                }
            }
            $resultVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $set);
            if (!$resultVinculado) {
                /* FALLO UNA DE LAS MODIFICACIONES AL SUJETO VINCULADO */
                $log = new Log();
                $log->writeLine("[Error al modificar sujetos vinculados en la BD][QUERY: $set]");
                $modificaciones = false;
            }
        }
        if ($modificaciones) {
            sqlsrv_commit(BDConexion::getInstancia()->getConexion());
            $div = '<div class="alert alert-success text-center" role="alert"> Se realizó la modificación del RTE correctamente </div>';
        } else {
            $log = new Log();
            $log->writeLine("[Error al modificar sujetos vinculados en la BD]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
            $div = '<div class="alert alert-danger text-center" role="alert"> No se realizó la modificación del RTE </div>';
        }
    } else {
        /* NO SE MODIFICO LA TRANSACCION. SE CANCELA LA OPERACION */
        $log = new Log();
        $log->writeLine("[Error al modificar transaccion en la BD][QUERY: $queryTransaccion]");
        sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
        $div = '<div class="alert alert-danger text-center" role="alert"> No se realizó la modificación del RTE </div>';
    }

    $formulario = '
        <form id="formContinuarModRTE" name="formContinuarModRTE">
            <input type="hidden" id="transacciones" name="transacciones[]" value="' . $idOperacion . '">
        <form>
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <input type="button" class="btn btn-outline-secondary" id="btnContinuarModificandoRTE" name="btnContinuarModificandoRTE" value="Volver">
                     <a href="formBuscarRTE.php">
                        <input type="button" class="btn btn-outline-secondary" value="Buscar">
                    </a>
                </div>
            </div>
        </div>
        ';
}

echo '
<h4 class="text-center p-4">MODIFICAR RTE</h4>
<div class="container">
    ' . $div . '
    ' . $formulario . '
</div>';

