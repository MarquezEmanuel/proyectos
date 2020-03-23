<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorReporte {

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function listarCategorias() {
        $resultado = Reportes::listarCategorias();
        $this->mensaje = Reportes::getMensaje();
        return $resultado;
    }

    public function listarReportes($modulo) {
        $resultado = Reportes::listarReportes($modulo);
        $this->mensaje = Reportes::getMensaje();
        return $resultado;
    }

    public function obtenerReporte($modulo, $reporte, $tope) {
        $resultado = Reportes::obtenerReporte($modulo, $reporte, $tope);
        $this->mensaje = Reportes::getMensaje();
        return $resultado;
    }

}
