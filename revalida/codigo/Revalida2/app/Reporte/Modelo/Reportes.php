<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reportes {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function listarCategorias() {
        $consulta = "SELECT DISTINCT modulo, icono FROM vw_reporte ORDER BY modulo";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function listarReportes($modulo) {
        $consulta = "SELECT DISTINCT modulo, reporte FROM vw_reporte WHERE modulo = ? ORDER BY modulo";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array($modulo));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    public static function obtenerReporte($modulo, $reporte, $tope) {
        $consulta = "SELECT TOP(?) * FROM vw_reporte WHERE modulo = ? AND reporte = ? ORDER BY cantidad DESC, nombre";
        $datos = array($tope, $modulo, utf8_decode($reporte));
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
