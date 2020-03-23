<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Aplicacion {

    private $id;
    private $nombre;
    private $propietario;
    private $base;
    private $estado;
    private $mensaje;

    public function __construct($id = NULL, $nombre = NULL, $propietario = NULL, $estado = NULL, $base = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->propietario = $propietario;
        $this->estado = $estado;
        $this->base = utf8_decode($base);
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getPropietario() {
        return $this->propietario;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getBase() {
        return $this->base;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPropietario($propietario) {
        $this->propietario = $propietario;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setBase($base) {
        $this->base = $base;
    }

    /**
     * Realiza la creacion del aplicativo en la base de datos. Se requiere del nombre
     * y de la gerencia propietaria de los datos para llevar a cabo la operacion.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se creo o 2 para exito.
     */
    public function crear() {
        if ($this->nombre) {
            $consulta = "INSERT INTO aplicativo OUTPUT INSERTED.id VALUES (?, ?, '', 1)";
            $datos = array(&$this->nombre, &$this->propietario);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Realiza la modificacion del aplicativo en la base de datos. Se puede modificar
     * el nombre, gerencia propietaria y/o estado de un aplicativo referenciado a partir del id.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se modifico o 2 para exito.
     */
    public function modificar() {
        if ($this->id && $this->nombre && $this->propietario) {
            $consulta = "UPDATE aplicativo SET nombre = ?, propietario = ?, estado = ? WHERE id = ?";
            $datos = array($this->nombre, $this->propietario, $this->estado, $this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Obtiene un aplicativo a partir de su id. Se asocia al objeto la informacion que
     * se obtiene desde la base de datos.
     * @return integer 0 cuando faltan datos, 1 cuando no hay resultados o 2 para exito.
     */
    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM aplicativo WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array($this->id));
            if (gettype($fila) == 'array') {
                $this->nombre = $fila['nombre'];
                $this->base = $fila['nombreBase'];
                $this->estado = $fila['estado'];
                return $this->obtenerGerencia($fila['propietario']);
            }
            $this->mensaje = "No se obtuvo la información del servicio";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al servicio";
        return 0;
    }

    /**
     * Obtiene los datos de la gerencia propietaria del sistema a partir de su id.
     * @param integer $idGerencia Identificador de la gerencia.
     * @return integer 0 cuando faltan datos, 1 cuando no hay resultados o 2 para exito.
     */
    private function obtenerGerencia($idGerencia) {
        $gerencia = new Gerencia($idGerencia);
        $resultado = $gerencia->obtener();
        $this->propietario = ($resultado == 2) ? $gerencia : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la gerencia";
        return $resultado;
    }

}
