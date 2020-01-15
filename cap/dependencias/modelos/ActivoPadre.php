<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActivoPadre {

    private $id;
    private $categoria;
    private $sigla;
    private $nombre;
    private $estado;
    private $hijos;
    private $mensaje;

    public function __construct($id = NULL, $categoria = NULL, $sigla = NULL, $nombre = NULL, $estado = NULL, $hijos = NULL) {
        $this->id = $id;
        $this->categoria = utf8_decode($categoria);
        $this->sigla = utf8_decode($sigla);
        $this->nombre = utf8_decode($nombre);
        $this->estado = $estado;
        $this->hijos = $hijos;
    }

    public function getId() {
        return $this->id;
    }

    public function getCategoria() {
        return utf8_encode($this->categoria);
    }

    public function getSigla() {
        return utf8_encode($this->sigla);
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getHijos() {
        return $this->hijos;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCategoria($categoria) {
        $this->categoria = utf8_decode($categoria);
    }

    public function setSigla($sigla) {
        $this->sigla = utf8_decode($sigla);
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setHijos($hijos) {
        $this->hijos = $hijos;
    }

    public function cambiarEstado() {
        if ($this->id && $this->estado) {
            $consulta = "UPDATE dep_activo_padre SET estado = ? WHERE id = ?";
            $modificacion = SQLServer::instancia()->modificar($consulta, array(&$this->estado, &$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                $operacion = ($this->estado == 'Activo') ? "ALTA" : "BAJA";
                $modificacion = $this->registrarActividad($operacion, $this->id);
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->categoria && $this->sigla && $this->nombre && $this->hijos) {
            $consulta = "INSERT INTO dep_activo_padre OUTPUT INSERTED.id VALUES (?, ?, ?, 'Activo')";
            $datos = array(&$this->nombre, &$this->descripcion);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($creacion == 2) {
                $this->id = SQLServer::instancia()->getUltimoId();
                $creaRelacion = Dependencia::crear($this->id, $this->hijos);
                $this->mensaje = ($creaRelacion == 2) ? $this->mensaje : Dependencia::getMensaje();
                return ($creaRelacion == 2) ? $this->registrarActividad("CREACION", $this->id) : $creaRelacion;
            }
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificar() {
        if ($this->id && $this->categoria && $this->sigla && $this->nombre && $this->hijos) {
            $consulta = "UPDATE dep_activo_padre SET categoria=?, sigla = ?, nombre = ? WHERE id = ?";
            $datos = array(&$this->categoria, &$this->sigla, &$this->nombre, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            if ($modificacion == 2) {
                
            }
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM dep_activo_padre WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->categoria = $fila['categoria'];
                $this->sigla = $fila['sigla'];
                $this->nombre = $fila['nombre'];
                $this->estado = $fila['estado'];
                return $this->obtenerActivosHijos();
            }
            $this->mensaje = "No se obtuvo la información del activo padre";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al activo padre";
        return 0;
    }

    private function obtenerActivosHijos() {
        
    }

    private function registrarActividad($operacion, $id) {
        $creacion = Log::guardarActividad("dep_activo_padre", $operacion, $id);
        $this->mensaje = ($creacion == 2) ? $this->mensaje : "No se pudo registrar actividad";
        return $creacion;
    }

}
