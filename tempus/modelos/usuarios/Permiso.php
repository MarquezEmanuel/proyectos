<?php

/**
 * 
 * @since 28/10/2017.
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Márquez Emanuel.
 * */
class Permiso 
{
    /** @var integer */
    private $idpermiso;
    
    /** @var string */
    private $nombre;
    
    /** @var mysqli_result */
    private $datos;
    
    /** Constructor de la clase. */
    function __construct($idpermiso = null) 
    {
        if ($idpermiso) {
            
            $consulta = "SELECT * FROM ".Constantes::BD_USERS.".permiso WHERE idpermiso = ".$idpermiso;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                    $this->{$atributo} = $valor;
                }
            }
            $this->datos = null;
        }
    }
    
    function getIdPermiso() 
    {
        return $this->idpermiso;
    }
    
    function getNombre()
    {
        return $this->nombre;
    }
    
    function setIdPermiso($idpermiso) 
    {
        $this->idpermiso = $idpermiso;
    }
    
    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}