<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Usuarios {

    private static $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public static function getMensaje() {
        return self::$mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de usuarios a taves del legajo, nombre,
     * cargo y gerencia.
     * @param string $legajo Legajo de usuario.
     * @param string $nombre Nombre (o parte del nombre) del usuario a buscar.
     * @param string $cargo Nombre del cargo del usuario.
     * @param string $gerencia Nombre de la gerencia del usuario.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function buscar($legajo, $nombre, $cargo, $gerencia) {
        $consulta = "SELECT * FROM vw_usuario WHERE legajo LIKE ? AND "
                . "nombre_usuario LIKE ? AND cargo LIKE ? AND nombre_gerencia LIKE ?";
        $datos = array('%' . $legajo . '%', '%' . $nombre . '%', '%' . $cargo . '%', '%' . $gerencia . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el id y nombre de un usuario que cumpla las condiciones para ser
     * seleccionado como delegado de gerencia. Para ello, no debe estar asignado
     * como delegado a otra gerencia y poseer cargo GERENTE o similar.
     * @param string $nombre Nombre de usuario.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function seleccionarDelegadoGerencia($nombre) {
        $consulta = "SELECT id, nombre +', '+apellido nombre FROM usuario WHERE UPPER(cargo) LIKE '%GERENTE%' "
                . "AND id NOT IN (SELECT delegado FROM gerencia WHERE delegado IS NOT NULL) "
                . "AND (nombre +', '+apellido) LIKE ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el id y nombre de un usuario que cumpla las condiciones para ser
     * seleccionado como subdelegado de gerencia. Para ello, no debe estar asignado
     * como subdelegado a otra gerencia y no poseer cargo GERENTE o similar.
     * @param string $nombre Nombre de usuario.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function seleccionarSubdelegadoGerencia($nombre) {
        $consulta = "SELECT id, nombre +', '+apellido nombre FROM usuario WHERE UPPER(cargo) <> 'GERENTE' "
                . "AND id NOT IN (SELECT subDelegado FROM gerencia WHERE subDelegado IS NOT NULL) "
                . "AND (nombre +', '+apellido) LIKE ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve la informacion sobre la actividad de un usuario en el sistema.
     * @param string $legajo Legajo de usuario.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listarActividad($legajo) {
        $consulta = "SELECT * FROM (
            SELECT 'Login total' dato, usuario, count(usuario) cantidad FROM [logsConexionBD] 
            WHERE usuario <> 'DESC' AND operacion = 'INGRESO' GROUP BY usuario
            UNION ALL
            SELECT 'Actividad total' dato, usuario, count(usuario) cantidad FROM [logsConexionBD] 
            WHERE usuario <> 'DESC' GROUP BY usuario
            UNION ALL
            SELECT 'Login semanal' dato, usuario, count(usuario) cantidad FROM [logsConexionBD] 
            WHERE usuario <> 'DESC' AND operacion = 'INGRESO' AND fecha > GETDATE()-7  GROUP BY usuario
            UNION ALL
            SELECT 'Actividad semanal' dato, usuario, count(usuario) cantidad FROM [logsConexionBD] 
            WHERE usuario <> 'DESC' AND fecha > GETDATE()-7 GROUP BY usuario) TAB WHERE TAB.usuario = ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array($legajo));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado con la cantidad de registros indicados.
     * @param integer $tope Tope de cantidad.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listarConTope($tope) {
        $consulta = "SELECT TOP(?) * FROM vw_usuario";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$tope));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
