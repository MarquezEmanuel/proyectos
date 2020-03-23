<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Gerencias {

    private static $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public static function getMensaje() {
        return self::$mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de gerencias a taves del nombre.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @param string $delegado Nombre del delegado.
     * @param string $subdelegado Nombre del subdelegado.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function buscar($nombre, $delegado, $subdelegado) {
        $consulta = "SELECT * FROM vw_gerencia WHERE nombre_gerencia LIKE ?";
        $consulta .= ($delegado) ? " AND nombre_delegado LIKE ? " : "";
        $consulta .= ($subdelegado) ? " AND nombre_subdelegado LIKE ? " : "";
        $consulta .= " ORDER BY nombre_gerencia";
        $datos = array('%' . $nombre . '%');
        (!$delegado) ?: $datos[] = '%' . $delegado . '%';
        (!$subdelegado) ?: $datos[] = '%' . $subdelegado . '%';
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado de todos las gerencias ordenados por nombre.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listar() {
        $consulta = "SELECT * FROM gerencia ORDER BY nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }
    
    /**
     * Devuelve un listado con la cantidad de registros indicados.
     * @param integer $tope Tope de cantidad.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listarConTope($tope) {
        $consulta = "SELECT TOP(?)* FROM vw_gerencia ORDER BY nombre_gerencia";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$tope));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado de todas las gerencias activas ordenadas por nombre.
     * @param string $nombre Nombre (o parte del nombre) de la gerencia
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function seleccionar($nombre) {
        $consulta = "SELECT * FROM gerencia WHERE nombre LIKE ? ORDER BY nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
