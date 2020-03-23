<?php

class UsuariosAccesos {

    private static $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public static function getMensaje() {
        return self::$mensaje;
    }

    /**
     * Realiza la eliminacion de multiples registros en la base de datos. Todos los
     * accesos que pertenecen a un determinado aplicativo son eliminados.
     * @param integer $idAplicacion Identificador de la aplicacion.
     */
    public static function borrar($idAplicacion) {
        if ($idAplicacion) {
            $consulta = "DELETE FROM usuarioAcceso WHERE aplicativo = ?";
            $eliminacion = SQLServer::instancia()->borrar($consulta, array(&$idAplicacion));
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $eliminacion;
        }
        self::$mensaje = "No se pudo hacer referencia a la aplicación";
        return 0;
    }

    /**
     * Realiza la carga de multiples registros en la base de datos.
     * @param integer $idAplicacion Identificador de la aplicacion.
     * @param array $accesos Arreglo con los registros a cargar.
     */
    public static function cargar($idAplicacion, $accesos) {
        if ($idAplicacion && !empty($accesos)) {
            $eliminacion = UsuariosAccesos::borrar($idAplicacion);
            if ($eliminacion == 0) {
                return $eliminacion;
            }
            $registros = "";
            foreach ($accesos as $acceso) {
                $registros .= "('{$acceso[0]}','{$acceso[1]}','{$acceso[2]}','{$acceso[3]}',{$acceso[4]}, GETDATE()),";
            }
            $consulta = "INSERT INTO usuarioAcceso VALUES " . substr($registros, 0, -1);
            $creacion = SQLServer::instancia()->ejecutar($consulta);
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        self::$mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Realiza la busqueda de los perfiles a los que tiene acceso un usuario.
     * @param string $legajo Legajo del usuario.
     * @param string $nombre Nombre del usuario.
     * @param string $perfil Nombre del perfil.
     * @param string $aplicativo Nombre del aplicativo.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public static function buscar($legajo, $nombre, $perfil, $aplicativo) {
        $consulta = "SELECT * FROM vw_usuarioAcceso "
                . "WHERE legajo LIKE ? AND nombreUsuario LIKE ? AND perfil LIKE ? AND nombreAplicativo LIKE ? "
                . "ORDER BY nombreUsuario";
        $datos = array('%' . $legajo . '%', '%' . $nombre . '%', '%' . $perfil . '%', '%' . $aplicativo . '%');
        $resultado = SQLServer::instancia()->seleccionar($consulta, $datos);
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

    /**
     * Realiza la busqueda de los primeros permisos en la base de datos.
     * @param integer $tope Tope de la cantidad de registros a obtener.
     */
    public static function listarConTope($tope) {
        $consulta = "SELECT TOP(?) *  FROM vw_usuarioAcceso";
        $resultado = SQLServer::instancia()->seleccionar($consulta, array(&$tope));
        self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    }

}
