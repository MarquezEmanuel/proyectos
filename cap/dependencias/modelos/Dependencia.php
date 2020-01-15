<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dependencia {

    private static $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }

    public static function borrar($idActivoPadre) {
        if ($idActivoPadre) {
            $consulta = "DELETE FROM dep_dependencia WHERE idPerfil = ?";
            $eliminacion = SQLServer::$instancia->borrar($consulta, array($idActivoPadre));
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $eliminacion;
        }
        self::$mensaje = "No se pudo hacer referencia al activo padre";
        return 0;
    }

    public static function crear($idActivoPadre, $hijos) {
        if ($idActivoPadre && !empty($hijos)) {
            $registros = "";
            foreach ($hijos as $idActivoHijo) {
                $registros .= "({$idActivoPadre}, {$idActivoHijo}),";
            }
            $consulta = "INSERT INTO dep_dependencia VALUES " . substr($registros, 0, -1);
            $creacion = SQLServer::instancia()->ejecutar($consulta);
            self::$mensaje = SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        self::$mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

}
