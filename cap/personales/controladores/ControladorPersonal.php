<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorPersonal {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function buscar($nombre, $estado) {
        $resultado = Personales::buscar($nombre, $estado);
        $this->mensaje = Personales::getMensaje();
        return $resultado;
    }

    public function cambiarEstado($id, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $personal = new Personal($id, NULL, NULL, NULL, NULL, $estado);
            $modificacion = $personal->cambiarEstado();
            $this->mensaje = $personal->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function crear($sigla, $nombre, $departamento, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $personal = new Personal(NULL, $sigla, $nombre, $departamento, $rti);
            $creacion = $personal->crear();
            $this->mensaje = $personal->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimosCreados() {
        $resultado = Personales::listarUltimosCreados();
        $this->mensaje = Personales::getMensaje();
        return $resultado;
    }

    public function modificar($id, $sigla, $nombre, $departamento, $rti) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $personal = new Personal($id, $sigla, $nombre, $departamento, $rti);
            $modificacion = $personal->modificar();
            $this->mensaje = $personal->getMensaje();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
