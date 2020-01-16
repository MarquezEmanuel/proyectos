<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Personales {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function buscar($nombre, $estado) {
        $consulta = "SELECT * FROM vwper_personal WHERE pnombre LIKE ? AND pestado = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', $estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarUltimosCreados() {
        $consulta = "SELECT TOP(10) * FROM vwper_personal WHERE pestado = 'Activo' ORDER BY id DESC";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
