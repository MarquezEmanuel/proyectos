<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorAcceso {

    private $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public function getMensaje() {
        return $this->mensaje;
    }

    /**
     * Realiza la eliminacion de un registro de acceso usuario de la base de datos.
     * @param integer $id Identificador del acceso.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function borrar($id, $datos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new UsuarioAcceso($id);
            $eliminacion = $usuario->borrar();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($eliminacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("BORRAR ACCESO", "[ControladorAcceso] [Borrar] [ID: {$id} {$datos}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $eliminacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve el resultado de la busqueda de accessos de un usuario a partir del
     * legajo, nombre, perfil o aplicacion.
     * @param string $legajo Legajo del usuario.
     * @param string $nombre Nombre del usuario.
     * @param string $perfil Nombre del perfil.
     * @param string $aplicativo Nombre del aplicativo.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function buscar($legajo, $nombre, $perfil, $aplicativo) {
        $resultado = UsuariosAccesos::buscar($legajo, $nombre, $perfil, $aplicativo);
        $this->mensaje = UsuariosAccesos::getMensaje();
        return $resultado;
    }

    /**
     * Realiza la carga de multiples registros en la base de datos.
     * @param integer $idAplicacion Identificador de la aplicacion.
     * @param array $accesos Arreglo con los registros a cargar.
     */
    public function cargar($idAplicacion, $accesos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $carga = UsuariosAccesos::cargar($idAplicacion, $accesos);
            $this->mensaje = UsuariosAccesos::getMensaje();
            $confirmar = ($carga == 2) ? TRUE : FALSE;
            Log::guardarAccion("CARGA ARCHIVO", "[ControladorAcceso] [Cargar] [ID: {$idAplicacion}] [RES: {$carga}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $carga;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Realiza la creacion de un nuevo registro en la base de datos.
     * @param string $legajo Legajo del usuario.
     * @param string $nombre Nombre del usuario.
     * @param string $perfil Nombre dle perfil asignado.
     * @param string $estado Estado en el aplicativo.
     * @param integer $aplicacion Identificador de la aplicacion.
     */
    public function crear($legajo, $nombre, $perfil, $estado, $aplicacion) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new UsuarioAcceso(NULL, $legajo, $nombre, $perfil, $estado, $aplicacion);
            $creacion = $usuario->crear();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("CREAR ACCESO", "[ControladorAcceso] [Crear] [DAT: {$legajo} $nombre] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Realiza la modificacion del acceso en la base de datos. Se puede modificar
     * el nombre, legajo, perfil y/o estado de un accesos referenciado a partir del id.
     * @param integer $id Identificador de la aplicacion.
     * @param string $legajo Legajo del usuario.
     * @param string $nombre Nombre del usuario.
     * @param string $perfil Nombre del perfil asociado.
     * @param string $estado Estado del usuario.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se modifico o 2 para exito.
     */
    public function modificar($id, $legajo, $nombre, $perfil, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new UsuarioAcceso($id, $legajo, $nombre, $perfil, $estado);
            $creacion = $usuario->modificar();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("MODIFICAR ACCESO", "[ControladorAcceso] [Modificar] [DAT: {$id} {$legajo} {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarConTope($tope) {
        $resultado = UsuariosAccesos::listarConTope($tope);
        $this->mensaje = UsuariosAccesos::getMensaje();
        return $resultado;
    }

}
