<?php

include_once '../../modelos/usuarios/Permiso.php';

/**
 * 
 * */
class Permisos
{
    /** @var mysqli_result */
    private $datos;
    
    /** @var Permiso[] */
    private $permisos = array();
    
    /** 
     * Constructor de clase. Cuando se crea obtiene todos los permisos que se
     * encuentran cargados en la base de datos.
     * */
    function __construct($todos = true) 
    {
        if ($todos) {
            $consulta = "SELECT * FROM ".Constantes::BD_USERS.".permiso";
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                for ($x = 0; $x < $this->datos->num_rows; $x++) {
                    $this->permisos[] = $this->datos->fetch_object("Permiso");
                }
            }
            $this->datos = null;
        }
       
    }
    /**
     * @return Permiso[] $permisos
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * @param Permiso[] $permisos
     */
    public function setPermisos($permisos)
    {
        $this->permisos = $permisos;
    }

    /**
     * Obtiene todos los permisos asociados a un determinado rol. Para ello, se
     * requiere conocer el identificador del rol. 
     * @var integer $idrol Identificador del rol (Obligatorio).
     * @author Márquez Emanuel.
     * */
    public function obtenerPermisosRol($idrol)
    {
        $this->permisos = array();
        $consulta = "SELECT p.idpermiso, p.nombre FROM ".Constantes::BD_USERS.".permiso p, ".Constantes::BD_USERS.".rol_permiso rp WHERE p.idpermiso=rp.idpermiso AND rp.idrol = ".$idrol;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i=0; $i<$tamanio; $i++) {
                $this->permisos[] = $this->datos->fetch_object("Permiso");
            }
        }
    }
    
}