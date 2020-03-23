<?php

/* INCLUYE LOS ARCHIVOS PARA UTILIZAR */
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* LEE LOS CAMPOS (Y ARREGLOS)DESDE EL FORMULARIO */
$cuenta = $_POST['cuenta'];
$fecha = $_POST['fecha'] . "T00:00:00";
$tipo = utf8_decode($_POST['tipot']);
$moneda = utf8_decode($_POST['moneda']);
$montoMO = $_POST['montomo'];
$montoPesos = $_POST['montop'];
$provincia = utf8_decode($_POST['provincia']);
$localidad = utf8_decode($_POST['localidad']);
$calle = utf8_decode($_POST['calle']);
$numero = $_POST['numero'];
$fondos = $_POST['rfondos'];
$producto = $_POST['rproducto'];
$cuit = $_POST['cuit'];
$tipop = $_POST['tipop'];
$apellidos = $_POST['apellidos'];
$nombres = $_POST['nombres'];
$tipoDoc = isset($_POST['tipodoc']) ? $_POST['tipodoc'] : NULL;
$dni = $_POST['dni'];
$log = new Log();

if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
    /* NO SE INICIALIZO LA TRANSACCION POR LO QUE NO SE PUEDE OPERAR SOBRE LA BD */
    $log->writeLine("[Error al inicializar la transaccion (begin_transaction)]");
    $div =  '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
} else {

    $personas = count($fondos);

    $queryTransaccion = "INSERT INTO rte_transaccion (cuenta, referencia, fecha, tipo, moneda, montoOrigen, montoPesos, numeroPersonas, provincia, localidad, calle, numero) OUTPUT INSERTED.id  VALUES ('$cuenta', NULL, '$fecha', '$tipo', '$moneda', '$montoMO', '$montoPesos', $personas, '$provincia', '$localidad', '$calle', '$numero')";
    $resultTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryTransaccion);

    if ($resultTransaccion) {
        /* OBTIENE EL IDENTIFICADOR DE LA TRANSACCION CREADA */
        $transaccion = sqlsrv_fetch_array($resultTransaccion, SQLSRV_FETCH_ASSOC);
        $id = $transaccion['id'];
        $query = "INSERT INTO rte_vinculado (referencia, relacionFondo, relacionProducto, cuil, tipoPersona, apellido, nombre, tipoDocumento, numeroDocumento) VALUES";
        $values = "";
        $posicion = 0;
        for ($i = 0; $i < $personas; $i++) {
            /* RECORRE LOS ARREGLOS PARA CADA SUJETO VINCULADO */
            $tipoPersona = utf8_decode($tipop[$i]);
            $apellido = utf8_decode($apellidos[$i]);
            if ($fondos[$i] === "Vinculado al producto operado") {
                if ($tipop[$i] === "Persona física") {
                    $nombre = utf8_decode($nombres[$i]);
                    $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                    $posicion++;
                    $values = $values . "('SIB$id', '$fondos[$i]', '', '$cuit[$i]', '$tipoPersona', '$apellido', '$nombre', '$tipoDocumento', '$dni[$i]'),";
                } else {
                    $values = $values . "('SIB$id', '$fondos[$i]', '', '$cuit[$i]', '$tipoPersona', '$apellido', '', '', ''),";
                }
            } else {
                if ($tipop[$i] === "Persona física") {
                    $nombre = utf8_decode($nombres[$i]);
                    $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                    $posicion++;
                    $values = $values . "('SIB$id', '$fondos[$i]', '$producto', '$cuit[$i]', '$tipoPersona', '$apellido', '$nombre', '$tipoDocumento', '$dni[$i]'),";
                } else {
                    $values = $values . "('SIB$id', '$fondos[$i]', '$producto', '$cuit[$i]', '$tipoPersona', '$apellido', '', '', ''),";
                }
            }
        }
        $queryVinculado = $query . substr($values, 0, -1);
        $resultVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryVinculado);
        if ($resultVinculado) {
            $queryUpdate = "UPDATE rte_transaccion SET referencia='SIB$id' WHERE id=$id";
            $resultUpdate = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryUpdate);
            if ($resultUpdate) {
                /* SE CREO LA TRANSACCION, LOS SUJETOS VINCULADOS Y SE ACTUALIZO LA REFERENCIA */
                sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                $div =  '<div class="alert alert-success text-center" role="alert"> Se realizó la creación del RTE correctamente <div>';
            } else {
                /* NO SE REALIZO LA ACTUALIZACION DE LA TRANSACCION. SE CANCELA LA TRANSACCION A LA BD */
                $log->writeLine("[Error al realizar update de transaccion en la BD][QUERY: $queryUpdate]");
                sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
                $div =  '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación del RTE <div>';
            }
        } else {
            /* FALLO EL INSERT DE LOS SUJETOS VINCULADOS. SE CANCELA LA TRANSACCION A LA BD */
            $log->writeLine("[Error al realizar insert de sujetos en la BD][QUERY: $queryVinculado]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
            $div =  '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación del RTE <div>';
        }
    } else {
        /* FALLO EL INSERT SOBRE LA TABLA DE TRANSACCIONES */
        $log->writeLine("[Error al realizar insert de transaccion en la BD][QUERY: $queryTransaccion]");
        $div = '<div class="alert alert-danger text-center" role="alert">No se realizó la creación de la transacción<div>';
    }
}

echo "<div class='container'> $div </div>";
