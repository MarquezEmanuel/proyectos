<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Servicios {

    private static $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public static function getMensaje() {
        return self::$mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de servicios a taves del nombre.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function buscar($nombre) {
        $consulta = "SELECT * FROM servicio WHERE nombre LIKE ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el resultado de la busqueda de servicios a partir de un estado. El
     * resultado se otorga ordenado por nombre.
     * @param string $estado Estado de los servicios.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listar($estado) {
        $consulta = "SELECT * FROM servicio WHERE estado = ? ORDER BY nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$estado));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado con la cantidad de registros indicados.
     * @param integer $tope Tope de cantidad.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listarConTope($tope) {
        $consulta = "SELECT TOP(?) * FROM servicio";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$tope));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
