<?php

class UsuarioAcceso {

    private $id;
    private $legajo;
    private $nombre;
    private $perfil;
    private $estado;
    private $aplicacion;
    private $mensaje;

    public function __construct($id = NULL, $legajo = NULL, $nombre = NULL, $perfil = NULL, $estado = NULL, $aplicacion = NULL) {
        $this->id = $id;
        $this->legajo = utf8_decode($legajo);
        $this->nombre = utf8_decode($nombre);
        $this->perfil = utf8_decode($perfil);
        $this->estado = utf8_decode($estado);
        $this->aplicacion = $aplicacion;
    }

    public function getId() {
        return $this->id;
    }

    public function getLegajo() {
        return utf8_encode($this->legajo);
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getPerfil() {
        return utf8_encode($this->perfil);
    }

    public function getEstado() {
        return utf8_encode($this->estado);
    }

    public function getAplicacion() {
        return $this->aplicacion;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLegajo($legajo) {
        $this->legajo = $legajo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setAplicacion($aplicacion) {
        $this->aplicacion = $aplicacion;
    }

    public function borrar() {
        if ($this->id) {
            $consulta = "DELETE FROM usuarioAcceso WHERE id = ?";
            $creacion = SQLServer::instancia()->borrar($consulta, array(&$this->id));
            $this->mensaje = SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function crear() {
        if ($this->legajo && $this->nombre && $this->perfil && $this->estado && $this->aplicacion) {
            $consulta = "INSERT INTO usuarioAcceso OUTPUT INSERTED.id VALUES (?, ?, ?, ?, ?, GETDATE())";
            $datos = array(&$this->legajo, &$this->nombre, &$this->perfil, &$this->estado, &$this->aplicacion);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificar() {
        if ($this->id && $this->legajo && $this->nombre && $this->perfil && $this->estado) {
            $consulta = "UPDATE usuarioAcceso SET legajo = ?, nombre = ?, perfil = ?, estado = ?, fechaActualizacion = GETDATE() WHERE id = ?";
            $datos = array(&$this->legajo, &$this->nombre, &$this->perfil, &$this->estado, &$this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Obtiene un acceso a partir de su id. Se asocia al objeto la informacion que
     * se obtiene desde la base de datos.
     * @return integer 0 cuando faltan datos, 1 cuando no hay resultados o 2 para exito.
     */
    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM usuarioAcceso WHERE id = ?";
            Log::escribirLineaError($consulta . " " . $this->id);
            $fila = SQLServer::instancia()->obtener($consulta, array($this->id));
            if (gettype($fila) == 'array') {
                $this->legajo = $fila['legajo'];
                $this->nombre = $fila['nombre'];
                $this->perfil = $fila['perfil'];
                $this->estado = $fila['estado'];
                $this->aplicacion = $fila['aplicativo'];
                return 2;
            }
            $this->mensaje = "No se obtuvo la información del acceso";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al acceso";
        return 0;
    }

}
