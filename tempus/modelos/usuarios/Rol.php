<?php

class Rol 
{
    /** @var integer */
    private $idrol;
    
    /** @var string */
    private $nombre;
    
    /** @var mysqli_result */
    private $datos;
    
    /** @var Permiso[] */
    private $permisos = array();
    
    public function __construct($idrol_ = null) {
        
        if ($idrol_) {
            $this->idrol = $idrol_;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery(""
                . "SELECT * "
                . "FROM " . Constantes::BD_USERS . ".ROL "
                . "WHERE idrol = " . $this->idrol);
            foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                $this->{$atributo} = $valor;
            }
            $this->datos = null;
            
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery(""
                . "SELECT rp.idpermiso, p.nombre "
                . "FROM " . Constantes::BD_USERS . ".ROL_PERMISO rp "
                . "INNER JOIN " . Constantes::BD_USERS . ".PERMISO p ON (p.idpermiso=rp.idpermiso) "
                . "WHERE rp.idrol = " . $this->idrol);
            
            for ($x = 0; $x < $this->datos->num_rows; $x++) {
                $this->addPermiso($this->datos->fetch_object("WorkflowPermiso"));
            }
        }
    }
    
    function getIdRol() 
    {
        return $this->idrol;
    }
    
    function getNombre() 
    {
        return $this->nombre;
    }
    
    /**
     * @return Permiso[] 
     * */
    function getPermisos() 
    {
        return $this->permisos;
    }
    
    function setIdRol($idrol) 
    {
        $this->idrol = $idrol;
    }
    
    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    /**
     * @param Permiso[] $permisos 
     * */
    function setPermisos($permisos)
    {
        $this->permisos = $permisos;
    }
    
    function addPermiso($permiso) {
        $this->permisos[] = $permiso;
    }
    
    function poseePermiso($idPermiso_) {
        foreach ($this->permisos as $Permiso)
            if ($idPermiso_ == $Permiso->getIdPermiso())
                return true;
                return false;
    }
}
