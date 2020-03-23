<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Aplicaciones {

    private static $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public static function getMensaje() {
        return self::$mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de aplicativos a taves del nombre, gerencia
     * propietaria, delegado de gerencia o subdelegado.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @param string $gerencia Nombre (o parte del nombre) de la gerencia.
     * @param string $delegado Nombre (o parte del nombre) del delegado.
     * @param string $subdelegado Nombre (o parte del nombre) del subdelegado.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function buscar($nombre, $gerencia, $delegado, $subdelegado) {
        $consulta = "SELECT * FROM [BD_Formulario].[dbo].[vw_aplicativo] WHERE nombreAplicacion LIKE ?";
        $consulta .= ($gerencia) ? " AND nombreGerencia LIKE ? " : "";
        $consulta .= ($delegado) ? " AND nombreDelegado = ? " : "";
        $consulta .= ($subdelegado) ? " AND nombreSubdelegado = ? " : "";
        $datos = array('%' . $nombre . '%');
        (!$gerencia) ?: $datos[] = '%' . $gerencia . '%';
        (!$delegado) ?: $datos[] = '%' . $delegado . '%';
        (!$subdelegado) ?: $datos[] = '%' . $subdelegado . '%';
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el resultado de la busqueda de aplicaciones a partir de un estado. El
     * resultado se otorga ordenado por nombre.
     * @param string $estado Estado de los servicios.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listar($estado) {
        $consulta = "SELECT * FROM vw_aplicativo WHERE estado = ? ORDER BY nombreAplicacion";
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
        $consulta = "SELECT TOP(?) * FROM vw_aplicativo";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$tope));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado de aplicaciones a partir de su nombre y nombre de la base
     * de datos.
     * @param string $nombre Nombre del aplicativo.
     * @param string $base Nombre de la base de datos o ARCHIVO.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function seleccionar($nombre, $base) {
        $consulta = " SELECT id, nombre FROM aplicativo WHERE nombre LIKE ? AND UPPER(nombreBase) = ? ";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%', &$base));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
