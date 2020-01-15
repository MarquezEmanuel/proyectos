<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorActivoPadre {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $activo = new ActivoPadre($id, NULL, NULL, NULL, $estado, NULL);
            $modificacion = $activo->cambiarEstado();
            $this->mensaje = $activo->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($categoria, $sigla, $nombre, $hijos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $activo = new ActivoPadre(NULL, $categoria, $sigla, $nombre, NULL, $hijos);
            $creacion = $activo->crear();
            $this->mensaje = $activo->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function modificar($id, $categoria, $sigla, $nombre, $hijos) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $activo = new ActivoPadre($id, $categoria, $sigla, $nombre, NULL, $hijos);
            $modificacion = $activo->modificar();
            $this->mensaje = $activo->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimosCreados() {
        
    }

}
