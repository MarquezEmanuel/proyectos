<?php

include_once 'Roles.php';
include_once 'Rol.php';

class Usuario {

    const METODO_MANUAL = "Manual";
    
    const METODO_GOOGLE = "Google";
    
    /** @var int */
    private $idusuario;
    
    /** @var string */
    private $email;
    
    /** @var string */
    private $nombre;
    
    /** @var string */
    private $metodologin;
    
    /** @var string */
    private $estado;
    
    /** @var Rol[] */
    private $roles = array();
    
    /** @var mysqli_result */
    private $datos; 
    
    /**
     * Constructor de la clase.
     * */
    function __construct($idusuario = null) 
    {
        if ($idusuario) {
            
            $consulta = "SELECT * FROM usuario WHERE idusuario = ".$idusuario;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            
            if ($this->datos->num_rows > 0) {
                foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                    $this->{$atributo} = $valor;
                }
                $roles->obtenerRolesUsuario($this->idusuario);
                $this->roles = $roles->getRoles();
            }
        }
    }
    
    /**
     * Devuelve el identidicador del usuario.
     * @return integer $idusuario
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return the $nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return the $metodoLogin
     */
    public function getMetodoLogin()
    {
        return $this->metodologin;
    }

    /**
     * @return the $estado
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    /**
     * return Rol[] $roles
     * */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param number $idusuario
     */
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }

    /**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param field_type $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param field_type $metodoLogin
     */
    public function setMetodoLogin($metodoLogin)
    {
        $this->metodoLogin = $metodoLogin;
    }

    /**
     * @param field_type $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @param Rol[] $roles
     * */
    public function setRoles($roles) 
    {
       $this->roles = $roles;
    }
    
    /**
     * Verifica si el usuario posee un determinado rol. Devuelve verdadero en
     * caso que lo posea, sino devuelve falso.
     * @param integer $idRol
     * @return boolean
     */
    public function poseeRol($idRol) 
    {
        foreach ($this->roles as $Rol) {
            if ($idRol == $Rol->getIdRol()) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Verifica si el usuario posee un determinado permiso. Devuelve verdadero
     * en caso que alguno de los roles del usuario contenga el permiso buscado.
     * @param integer $nombre Nombre del permiso (Obligatorio).
     * @return boolean
     * */
    public function poseePermiso($nombre)
    {
        foreach ($this->roles as $rol) {
            foreach ($rol->getPermisos() as $permiso) {
                if ($nombre = $permiso->getNombre()) {
                    return true;
                }
                
            }
        }
        return false;
    }
    
    /**
     * Realiza la creación de un nuevo usuario en la base de datos.
     * */
    public function crear($email, $nombre, $metodo = self::METODO_MANUAL)
    {
        $this->buscar($email);
        if (is_null($this->idusuario)) {
            $consulta = "INSERT INTO usuario VALUES (null,'{$email}','{$nombre}','{$metodo}','Activo')";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows) {
                $this->idusuario = (Int) ObjetoDatos::getInstancia()->insert_id;
                $this->email = $email;
                $this->nombre = $nombre;
                $this->metodologin = $metodo;
                $this->estado = "Activo";
            }
        }
    }
    
    /**
     * Realiza la busqueda de un usuario en la base de datos.
     * @param string $email Correo electronico del usuario (Obligatorio).
     * @param string $metodo Forma en que se loguea el usuario (Obligatorio).
     * */
    public function buscar($email, $metodo = self::METODO_MANUAL) 
    {
        $consulta = "SELECT * FROM usuario WHERE email = '{$email}' AND metodologin = '{$metodo}'";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        
        if ($this->datos->num_rows > 0) {
            /* Se ha encontrado un usuario que cumple la condicion de busqueda */
            foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                $this->{$atributo} = $valor;
            }
            $roles = new Roles(false);
            $roles->obtenerRolesUsuario($this->idusuario);
            $this->roles = $roles->getRoles();
        } else {
            $this->idusuario = null;
            $this->email = null;
            $this->nombre = null;
            $this->metodologin = null;
            $this->estado = null;
            $this->roles = null;
        }
        
        $this->datos = null;
    }
    
}

