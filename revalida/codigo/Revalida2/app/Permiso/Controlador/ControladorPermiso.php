<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorPermiso {

    private $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public function getMensaje() {
        return $this->mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de permisos a taves del nombre.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function buscar($nombre) {
        $resultado = Permisos::buscar($nombre);
        $this->mensaje = Permisos::getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el listado completo de permisos cargados en la base de datos.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listar() {
        $resultado = Permisos::listar();
        $this->mensaje = Permisos::getMensaje();
        return $resultado;
    }

    /**
     * Devuelve el listado con la cantidad indicada de permisos cargados en la base de datos.
     * @param integer $tope Cantidad tope de registros a listar.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listarConTope($tope) {
        $resultado = Permisos::listarConTope($tope);
        $this->mensaje = Permisos::getMensaje();
        return $resultado;
    }

    public function modificar($id, $nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $permiso = new Permiso($id, $nombre);
            $edicion = $permiso->modificar();
            $this->mensaje = $permiso->getMensaje();
            $confirmar = ($edicion == 2) ? TRUE : FALSE;
            Log::guardarAccion("MODIFICAR PERMISO", "[ControladorPermiso] [Modificar] [DAT: {$id} {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $edicion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
