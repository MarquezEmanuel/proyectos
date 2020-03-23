<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Servicio {

    private $id;
    private $nombre;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $estado = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = utf8_decode($nombre);
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    /**
     * Realiza la creacion del servicio en la base de datos. Se requiere del nombre
     * para llevar a cabo la operacion.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se creo o 2 para exito.
     */
    public function crear() {
        if ($this->nombre) {
            $consulta = "INSERT INTO servicio OUTPUT INSERTED.id VALUES (?, 1)";
            $datos = array(&$this->nombre);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Realiza la modificacion del servicio en la base de datos. Se puede modificar
     * el nombre y/o estado de un servicio referenciado a partir del id.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se modifico o 2 para exito.
     */
    public function modificar() {
        if ($this->id && $this->nombre && $this->estado) {
            $consulta = "UPDATE servicio SET nombre = ?, estado = ? WHERE id = ?";
            $datos = array($this->nombre, $this->estado, $this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Obtiene un servicio a partir de su id. Se asocia al objeto la informacion que
     * se obtiene desde la base de datos.
     * @return integer 0 cuando faltan datos, 1 cuando no hay resultados o 2 para exito.
     */
    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM servicio WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array($this->id));
            if (gettype($fila) == 'array') {
                $this->nombre = $fila['nombre'];
                $this->estado = $fila['estado'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información del servicio";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al servicio";
        return 0;
    }

}
