<?php

/* INCLUYE LOS ARCHIVOS A UTILIZAR */
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

if (isset($_POST['transaccion'])) {
    $referencia = $_POST['transaccion'];
    $rfondos = $_POST['rfondos'];
    $rproducto = $_POST['rproducto'];
    $cuil = $_POST['cuit'];
    $tipoPersona = utf8_decode($_POST['tipop']);
    $apellidos = utf8_decode($_POST['apellidos']);
    $nombres = utf8_decode($_POST['nombres']);
    $tipodoc = isset($_POST['tipodoc']) ? $_POST['tipodoc'] : "";
    $dni = isset($_POST['dni']) ? $_POST['dni'] : "";

    if ($_POST['tipop'] === "Vinculado al producto operado") {
        if ($tipoPersona === "Persona física") {
            $queryVinculado = "INSERT INTO rte_vinculado (referencia, relacionFondo, relacionProducto, cuil, tipoPersona, apellido, nombre, tipoDocumento, numeroDocumento) VALUES ('$referencia', '$rfondos', '', '$cuil', '$tipoPersona', '$apellidos', '$nombres', '$tipodoc', '$dni')";
        } else {
            $queryVinculado = "INSERT INTO rte_vinculado (referencia, relacionFondo, relacionProducto, cuil, tipoPersona, apellido, nombre, tipoDocumento, numeroDocumento) VALUES ('$referencia', '$rfondos', '', '$cuil', '$tipoPersona', '$apellidos', '', '', '')";
        }
    } else {
        if ($_POST['tipop'] === "Persona física") {
            $queryVinculado = "INSERT INTO rte_vinculado (referencia, relacionFondo, relacionProducto, cuil, tipoPersona, apellido, nombre, tipoDocumento, numeroDocumento) VALUES ('$referencia', '$rfondos', '$rproducto', '$cuil', '$tipoPersona', '$apellidos', '$nombres', '$tipodoc', '$dni')";
        } else {
            $queryVinculado = "INSERT INTO rte_vinculado (referencia, relacionFondo, relacionProducto, cuil, tipoPersona, apellido, nombre, tipoDocumento, numeroDocumento) VALUES ('$referencia', '$rfondos', '$rproducto', '$cuil', '$tipoPersona', '$apellidos', '', '', '')";
        }
    }
     $log = new Log();
     $log->writeLine("[ -------][QUERY: $queryVinculado]");
    $resultVinculado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryVinculado);
    if ($resultVinculado) {
        $div = '<div class="alert alert-success text-center" role="alert"> Se agregó el sujeto vinculado al RTE <div>';
    } else {
        $log = new Log();
        $log->writeLine("[Error al inserta sujeto vinculado][QUERY: $queryVinculado]");
        $div = '<div class="alert alert-danger text-center" role="alert"> No se agregó  el sujeto vinculado al RTE <div>';
    }
}

echo '
<h4 class="text-center p-4">AGREGAR SUJETO VINCULADO PARA RTE</h4>
<div class="container">
    ' . $div . '
</div>';
