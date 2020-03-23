<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

$cuenta = $_POST['cuenta'];
$fecha = $_POST['fecha'];
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
    $log->writeLine("[Error al inicializar la transaccion (begin_transaction)]");
    echo '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
} else {
    $personas = count($fondos);

    $query = "INSERT INTO rte_operacion VALUES ('$cuenta', '$fecha', '$tipo', '$moneda', '$montoMO', '$montoPesos', $personas, '$provincia', '$localidad', '$calle', '$numero')";
    $insertOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

    if ($insertOperacion) {

        $query = "SELECT SCOPE_IDENTITY() id";
        $lastId = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
        if ($lastId) {
            $row = sqlsrv_fetch_array($lastId);
            $idOperacion = $row['id'];
            $query = "INSERT INTO rte_sujeto VALUES";
            $values = "";
            $posicion = 0;
            for ($i = 0; $i < $personas; $i++) {

                $tipoPersona = utf8_decode($tipop[$i]);
                $apellido = utf8_decode($apellidos[$i]);
                
                if ($fondos[$i] === "Vinculado al producto operado") {
                    if ($tipop[$i] === "Persona física") {
                        $nombre = utf8_decode($nombres[$i]);
                        $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                        $posicion++;
                        $values = $values . "($idOperacion, '$fondos[$i]', '', '$cuit[$i]', '$tipoPersona', '$apellido', '$nombre', '$tipoDocumento', '$dni[$i]'),";
                    } else {
                        $values = $values . "($idOperacion, '$fondos[$i]', '', '$cuit[$i]', '$tipoPersona', '$apellido', '', '', ''),";
                    }
                } else {
                    if ($tipop[$i] === "Persona física") {
                        $nombre = utf8_decode($nombres[$i]);
                        $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                        $posicion++;
                        $values = $values . "($idOperacion, '$fondos[$i]', '$producto', '$cuit[$i]', '$tipoPersona', '$apellido', '$nombre', '$tipoDocumento', '$dni[$i]'),";
                    } else {
                        $values = $values . "($idOperacion, '$fondos[$i]', '$producto', '$cuit[$i]', '$tipoPersona', '$apellido', '', '', ''),";
                    }
                }
            }
            $query = $query . substr($values, 0, -1);
            $insertSujetos = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if ($insertOperacion && $insertSujetos) {
                sqlsrv_commit(BDConexion::getInstancia()->getConexion());
                echo '<div class="alert alert-success text-center" role="alert"> Se realizó la creación del RTE correctamente <div>';
            } else {
                $log->writeLine("[Error al crear operacion o sujetos en la BD][QUERY: $query]");
                sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
                echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación del RTE <div>';
            }
        } else {
            $log->writeLine("[Error al obtener el identificador de operacion desde la BD][QUERY: $query]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
            echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación de la operación indicada<div>';
        }
    } else {
        $log->writeLine("[Error al realizar la insercion en la BD][QUERY: $query]");
        echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la creación de la operación <div>';
    }
}






