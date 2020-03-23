<?php

class Usuario {

    private $id;
    private $nombre;
    private $apellido;
    private $legajo;
    private $cargo;
    private $gerencia;
    private $firma;
    private $rol;
    private $foto;
    private $estado;
    private $mensaje;

    public function __construct($id = null, $nombre = null, $apellido = null, $legajo = null, $cargo = null, $gerencia = null, $firma = null, $rol = null, $estado = null, $foto = NULL) {
        $this->id = $id;
        $this->nombre = utf8_decode($nombre);
        $this->apellido = utf8_decode($apellido);
        $this->legajo = $legajo;
        $this->cargo = utf8_decode($cargo);
        $this->gerencia = $gerencia;
        $this->firma = $firma;
        $this->rol = $rol;
        $this->foto = $foto;
        $this->estado = $estado;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return utf8_encode($this->nombre);
    }

    public function getApellido() {
        return utf8_encode($this->apellido);
    }

    public function getLegajo() {
        return $this->legajo;
    }

    public function getCargo() {
        return utf8_encode($this->cargo);
    }

    public function getGerencia() {
        return $this->gerencia;
    }

    public function getFirma() {
        return $this->firma;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFoto() {
        return $this->foto;
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

    public function setApellido($apellido) {
        $this->apellido = utf8_decode($apellido);
    }

    public function setLegajo($legajo) {
        $this->legajo = $legajo;
    }

    public function setCargo($cargo) {
        $this->cargo = utf8_decode($cargo);
    }

    public function setGerencia($gerencia) {
        $this->gerencia = $gerencia;
    }

    public function setFirma($firma) {
        $this->firma = $firma;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function crear() {
        if ($this->legajo && $this->nombre && $this->apellido && $this->rol) {
            $consulta = "INSERT INTO usuario VALUES (?, ?, ?, ?, ?, '', 1, ?, 'usuario.png')";
            $datos = array($this->legajo, $this->nombre, $this->apellido, $this->cargo, $this->gerencia, $this->rol);
            $creacion = SQLServer::instancia()->insertar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $creacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificar() {
        if ($this->id && $this->nombre && $this->apellido && $this->rol) {
            $consulta = "UPDATE usuario SET legajo = ?, nombre = ?, apellido = ?, cargo = ?, gerencia = ?, id_rol = ?, estado = ? WHERE id = ?";
            $datos = array($this->legajo, $this->nombre, $this->apellido, $this->cargo, $this->gerencia, $this->rol, $this->estado, $this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = utf8_encode($this->nombre) . ": " . SQLServer::instancia()->getMensaje();
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    public function modificarMiPerfil() {
        if ($this->id && $this->foto) {
            $consulta = "UPDATE usuario SET foto = ? WHERE id = ?";
            $datos = array($this->foto, $this->id);
            $modificacion = SQLServer::instancia()->modificar($consulta, $datos);
            $this->mensaje = SQLServer::instancia()->getMensaje();
            return $modificacion;
        }
        $this->mensaje = "No se recibieron los campos obligatorios";
        return 0;
    }

    /**
     * Obtiene los datos del usuario a partir de su numero de legajo. Es necesario
     * para cuando solo se conoce este dato del usuario como al ingresar.
     */
    public function obtener() {
        if ($this->legajo) {
            $consulta = "SELECT * FROM usuario WHERE legajo = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->legajo));
            if (gettype($fila) == "array") {
                $this->id = $fila['id'];
                $this->nombre = $fila['nombre'];
                $this->apellido = $fila['apellido'];
                $this->cargo = $fila['cargo'];
                $this->estado = $fila['estado'];
                $this->foto = $fila['foto'];
                $orol = $this->obtenerRol($fila['id_rol']);
                $oger = $this->obtenerGerencia($fila['gerencia']);
                return ($orol == 2 && $oger == 2) ? 2 : 1;
            }
            $this->mensaje = "No se obtuvo la información del usuario";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al usuario";
        return 0;
    }

    /**
     * Obtiene los datos del usuario a partir de su identificador. Se requiere para
     * su uso cuando el usuario pertenece a otro objeto. Se debe tener en cuenta
     * que en este metodo no se obtiene la gerencia para no generar un bucle.
     */
    public function obtenerPorID() {
        if ($this->id) {
            $consulta = "SELECT * FROM usuario WHERE id = ?";
            $fila = SQLServer::instancia()->obtener($consulta, array(&$this->id));
            if (gettype($fila) == "array") {
                $this->id = $fila['id'];
                $this->nombre = $fila['nombre'];
                $this->apellido = $fila['apellido'];
                $this->cargo = $fila['cargo'];
                $this->estado = $fila['estado'];
                $this->foto = $fila['foto'];
                return $this->obtenerRol($fila['id_rol']);
            }
            $this->mensaje = "No se obtuvo la información del usuario";
            return 1;
        }
        $this->mensaje = "No se pudo hacer referencia al usuario";
        return 0;
    }

    private function obtenerRol($idRol) {
        $perfil = new Rol($idRol);
        $resultado = $perfil->obtener();
        $this->rol = ($resultado == 2) ? $perfil : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener el rol";
        return $resultado;
    }

    private function obtenerGerencia($idGerencia) {
        $gerencia = new Gerencia($idGerencia);
        $resultado = $gerencia->obtener();
        $this->gerencia = ($resultado == 2) ? $gerencia : NULL;
        $this->mensaje = ($resultado == 2) ? $this->mensaje : "No se pudo obtener la gerencia";
        return $resultado;
    }

}
