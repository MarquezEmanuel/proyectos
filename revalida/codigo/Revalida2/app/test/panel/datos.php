<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/AutoCargador.php';

AutoCargador::cargarModulos();

$consulta = "SELECT count(*) cantidad FROM vw_formulario where UPPER(estado) = '" . $_POST['estado'] . "' ";
$resultado = SQLServer::instancia()->seleccionar($consulta, array());

if (gettype($resultado)) {
    while ($panel = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
        echo "<div>" . utf8_encode($panel['cantidad']) . "<div><br>";
    }
}

