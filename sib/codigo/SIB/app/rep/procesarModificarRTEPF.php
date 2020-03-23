<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (!empty($_POST)) {
    if (sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion()) === false) {
        $log = new Log();
        $log->writeLine("[Error al inicializar la transaccion (begin_transaction)]");
        echo '<div class="alert alert-danger text-center" role="alert"> No se inicializó la transacción con la base de datos </div>';
    } else {

        $idOperacion = $_POST['idOperacion'];
        $cuenta = $_POST['cuenta'];
        $fecha = $_POST['fecha'];
        $tipo = utf8_decode($_POST['tipot']);
        $moneda = utf8_decode($_POST['moneda']);
        $montoMO = $_POST['montomo'];
        $montoPesos = $_POST['montop'];
        $personas =$_POST['nroPersonas'];
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

        $query = "UPDATE rte_operacion SET cuenta='$cuenta', fecha='$fecha', tipo='$tipo', "
                . "moneda='$moneda', montoMo=$montoMO, montoPesos=$montoPesos, provincia='$provincia', "
                . "localidad='$localidad', calle='$calle', numero='$numero' WHERE idOperacion=" . $idOperacion;
        $resultOperacion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
        $posicion = 0;
        $modificaciones = true;
        for ($i = 0; $i < $personas; $i++) {

            $idSujeto = $idSujetos[$i];
            $tipoPersona = utf8_decode($tipop[$i]);
            $apellido = utf8_decode($apellidos[$i]);
            if ($fondos[$i] === "Vinculado al producto operado") {
                if ($tipop[$i] === "Persona física") {
                    
                    $nombre = utf8_decode($nombres[$i]);
                    $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                    $posicion++;
                    
                    $set = "UPDATE rte_sujeto "
                         . "SET relacionFondo='$fondos[$i]', relacionProducto='', "
                         . "cuit='$cuit[$i]', tipoPersona='$tipoPersona', apellidos='$apellido', "
                         . "nombres='$nombre', tipoDocumento='$tipoDocumento', "
                         . "numeroDocumento='$dni[$i]' WHERE idSujeto=$idSujeto";
                } else {
                    $set = "UPDATE rte_sujeto "
                         . "SET relacionFondo='$fondos[$i]', relacionProducto='', "
                         . "cuit='$cuit[$i]', tipoPersona='$tipoPersona', apellidos='$apellido', "
                         . "nombres='', tipoDocumento='', numeroDocumento='' WHERE idSujeto=$idSujeto";
                }
            } else {
                if ($tipop[$i] === "Persona física") {
                    $nombre = utf8_decode($nombres[$i]);
                    $tipoDocumento = isset($tipoDoc[$posicion]) ? utf8_decode($tipoDoc[$posicion]) : "";
                    $posicion++;
                    $set = "UPDATE rte_sujeto "
                         . "SET relacionFondo='$fondos[$i]', relacionProducto='$producto', "
                         . "cuit='$cuit[$i]', tipoPersona='$tipoPersona', apellidos='$apellido', "
                         . "nombres='$nombre', tipoDocumento='$tipoDocumento', "
                         . "numeroDocumento='$dni[$i]' WHERE idSujeto=$idSujeto";
                } else {
                    $set = "UPDATE rte_sujeto "
                         . "SET relacionFondo='$fondos[$i]', relacionProducto='$producto', "
                         . "cuit='$cuit[$i]', tipoPersona='$tipoPersona', apellidos='$apellido', "
                         . "nombres='', tipoDocumento='', numeroDocumento='' WHERE idSujeto=$idSujeto";
                }
            }
            $resultSujeto = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $set);
            if(!$resultSujeto) {
                $modificaciones = false;
            }
        }
        if ($resultOperacion && $modificaciones) {
            sqlsrv_commit(BDConexion::getInstancia()->getConexion());
            echo '<div class="alert alert-success text-center" role="alert"> Se realizó la modificación del RTE correctamente <div>';
        } else {
            $log->writeLine("[Error al modificar operacion o sujetos en la BD][QUERY: $query]");
            sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
            echo '<div class="alert alert-danger text-center" role="alert"> No se realizó la modificación del RTE <div>';
        }
    }
} else {
    $log->writeLine("[Error al recibir el formulario por POST]");
    echo '<div class="alert alert-danger text-center" role="alert"> No se recibió el formulario de modificación </div>';
}
