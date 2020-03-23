<?php

class Permisos {

    private static $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public static function getMensaje() {
        return self::$mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de permisos a taves del nombre.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function buscar($nombre) {
        $consulta = "SELECT * FROM permiso WHERE nombre LIKE ?";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array('%' . $nombre . '%'));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve los permisos de nivel uno de un determinado perfil.
     * @param integer $idPerfil Identificador del perfil.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listarMenu($idPerfil) {
        $consulta = "SELECT id, nombre FROM permiso PER INNER JOIN rol_permiso "
                . "REL ON REL.id_permiso = PER.id AND REL.id_rol = ? "
                . "WHERE PER.nivel = 1 ORDER BY nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idPerfil));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve los permisos de nivel dos de un determinado perfil y padre.
     * @param integer $idPerfil Identificador del perfil.
     * @param integer $idPadre Identificador del padre (permiso de nivel uno).
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listarSubMenu($idPerfil, $idPadre) {
        $consulta = "SELECT id, nombre, link FROM permiso PER INNER JOIN rol_permiso "
                . "REL ON REL.id_permiso = PER.id AND REL.id_rol = ? "
                . "WHERE PER.nivel = 2 AND padre = ? ORDER BY nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$idPerfil, &$idPadre));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el listado completo de permisos cargados en la base de datos.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listar() {
        $consulta = "SELECT * FROM permiso ORDER BY nivel, nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array());
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el listado con la cantidad indicada de permisos cargados en la base de datos.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function listarConTope($tope) {
        $consulta = "SELECT TOP(?) * FROM permiso ORDER BY nivel, nombre";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$tope));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
