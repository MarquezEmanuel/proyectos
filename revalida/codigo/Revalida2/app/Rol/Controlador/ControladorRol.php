<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorRol {

    private $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public function getMensaje() {
        return $this->mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de roles a taves del nombre.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function buscar($nombre) {
        $resultado = Roles::buscar($nombre);
        $this->mensaje = Roles::getMensaje();
        return $resultado;
    }

    /**
     * Realiza la creacion de un nuevo rol en la base de datos.
     * @param string $nombre Nombre del rol.
     * @param array $permisos Permisos asociados al rol.
     */
    public function crear($nombre, $permisos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $perfil = new Rol(NULL, $nombre, $permisos);
            $creacion = $perfil->crear();
            $this->mensaje = $perfil->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("CREAR ROL", "[ControladorRol] [Crear] [DAT: {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve el listado completo de roles cargados en la base de datos.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listar() {
        $resultado = Roles::listar();
        $this->mensaje = Roles::getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado con la cantidad de registros indicados.
     * @param integer $tope Tope de cantidad.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listarConTope($tope) {
        $resultado = Roles::listarConTope($tope);
        $this->mensaje = Roles::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre, $permisos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $perfil = new Rol($id, $nombre, $permisos);
            $modificacion = $perfil->modificar();
            $this->mensaje = $perfil->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("MODIFICAR ROL", "[ControladorRol] [Modificar] [DAT: {$id} {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve un listado de todas los roles activos ordenados por nombre.
     * @param string $nombre Nombre (o parte del nombre) del rol.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function seleccionar($nombre) {
        $resultado = Roles::seleccionar($nombre);
        $this->mensaje = Roles::getMensaje();
        return $resultado;
    }

}
