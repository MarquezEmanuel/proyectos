<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorUsuario {

    private $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public function getMensaje() {
        return $this->mensaje;
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
    public function buscar($legajo, $nombre, $cargo, $gerencia) {
        $resultado = Usuarios::buscar($legajo, $nombre, $cargo, $gerencia);
        $this->mensaje = Usuarios::getMensaje();
        return $resultado;
    }

    public function crear($legajo, $nombre, $apellido, $cargo, $gerencia, $rol) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new Usuario(NULL, $nombre, $apellido, $legajo, $cargo, $gerencia, NULL, $rol);
            $creacion = $usuario->crear();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("CREAR USUARIO", "[ControladorUsuario] [Crear] [DAT: {$legajo} {$apellido}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve la informacion sobre la actividad de un usuario en el sistema.
     * @param string $legajo Legajo de usuario.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listarActividad($legajo) {
        $resultado = Usuarios::listarActividad($legajo);
        $this->mensaje = Usuarios::getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado con la cantidad de registros indicados.
     * @param integer $tope Tope de cantidad.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listarConTope($tope) {
        $resultado = Usuarios::listarConTope($tope);
        $this->mensaje = Usuarios::getMensaje();
        return $resultado;
    }

    public function modificar($id, $legajo, $nombre, $apellido, $cargo, $gerencia, $rol, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new Usuario($id, $nombre, $apellido, $legajo, $cargo, $gerencia, NULL, $rol, $estado);
            $modificacion = $usuario->modificar();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("MODIFICAR USUARIO", "[ControladorUsuario] [Modificar] [DAT: {$id} {$legajo} {$apellido}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function modificarMiPerfil($id, $foto) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $usuario = new Usuario($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $foto);
            $modificacion = $usuario->modificarMiPerfil();
            $this->mensaje = $usuario->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("MODIFICAR MI PERFIL", "[ControladorUsuario] [ModificarMiPerfil] [DAT: {$id} {$foto}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve el id y nombre de un usuario que cumpla las condiciones para ser
     * seleccionado como delegado de gerencia. Para ello, no debe estar asignado
     * como delegado a otra gerencia y poseer cargo GERENTE o similar.
     * @param string $nombre Nombre de usuario.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function seleccionarDelegadoGerencia($nombre) {
        $resultado = Usuarios::seleccionarDelegadoGerencia($nombre);
        $this->mensaje = Usuarios::getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el id y nombre de un usuario que cumpla las condiciones para ser
     * seleccionado como subdelegado de gerencia. Para ello, no debe estar asignado
     * como subdelegado a otra gerencia y no poseer cargo GERENTE o similar.
     * @param string $nombre Nombre de usuario.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function seleccionarSubdelegadoGerencia($nombre) {
        $resultado = Usuarios::seleccionarSubdelegadoGerencia($nombre);
        $this->mensaje = Usuarios::getMensaje();
        return $resultado;
    }

}
