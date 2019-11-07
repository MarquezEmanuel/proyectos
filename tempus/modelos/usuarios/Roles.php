<?php

include_once '../../modelos/usuarios/Permisos.php';
include_once '../../modelos/usuarios/Rol.php';

/**
 * 
 * */
class Roles
{
    /** @var mysqli_result */
    private $datos;
    
    /** @var Rol[] */
    private $roles = array();
    
    /**
     * Constructor de la clase. Por defecto se traen todos los roles que existan
     * cargados en la base de datos junto con los permisos correspondientes a cada
     * uno. En caso que se indique un valor falso, no se buscan los roles de la 
     * base de datos al crear un objeto.
     * @param boolean $todos true o false (Opcional).
     * */
    function __construct($todos = true) 
    {
        if ($todos) {
            $consulta = "SELECT * FROM ".Constantes::BD_USERS.".rol ";
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $tamanio = $this->datos->num_rows;
                $permisos = new Permisos(false);
                for ($i=0; $i<$tamanio; $i++) {
                    $fila = $this->datos->fetch_row();
                    $rol = new Rol();
                    $rol->setIdRol($fila[0]);
                    $rol->setNombre($fila[1]);
                    $permisos->obtenerPermisosRol($fila[0]);
                    $rol->setPermisos($permisos->getPermisos());
                    $this->roles[] = $rol;
                    $rol = null;
                }
            }
        }
    }
    
    /**
     * @return Rol[] $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Rol $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
    
    /**
     * Obtiene todos los roles de un usuario. Ademas, para cada rol que tenga el
     * usuario se obtienen los permisos asociados.
     * @param integer $idusuario Identificador de usuario (Obligatorio).
     * */
    public function obtenerRolesUsuario($idusuario)
    {
        $this->roles = array();
        $consulta = "SELECT r.idrol, r.nombre FROM ".Constantes::BD_USERS.".rol r, ".Constantes::BD_USERS.".usuario_rol ur WHERE r.idrol=ur.idrol AND ur.idusuario=".$idusuario;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            $permisos = new Permisos(false);
            
            for ($i=0; $i<$tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $rol = new Rol();
                $rol->setIdRol($fila[0]);
                $rol->setNombre($fila[1]);
                $permisos->obtenerPermisosRol($fila[0]);
                $rol->setPermisos($permisos->getPermisos());
                $this->roles[] = $rol;
                $rol = null;
            }
        }
    }

    
    
    
}