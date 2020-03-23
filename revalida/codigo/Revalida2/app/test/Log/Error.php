<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../Conexion/Modelo/Constantes.php';
require_once '../../Conexion/Modelo/Log.php';
require_once '../../Conexion/Modelo/Encriptador.php';
require_once '../../Conexion/Modelo/ConfiguracionBD.php';
require_once '../../Conexion/Modelo/SQLServer.php';

$consulta = "insert into usuarioAcceso WHERE ids=?";
$resultado = SQLServer::instancia()->insertar($consulta, array());

echo "Resultado " . $resultado;
