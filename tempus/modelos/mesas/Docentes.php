<?php

class Docentes
{
    /** @var Docente[] */
    private $docentes;
    
    /** @var mysqli_result $datos */
    private $datos;
    
    /**
     * Constructor de la clase Docentes. Obtiene todos los docentes que se encuentren cargados en la
     * base de datos. Los registros se encuentran ordenados por nombre en forma ascendente.
     * */
    function __construct()
    {
        $this->docentes = array();
        $consulta = "SELECT * FROM docente WHERE 1 ORDER BY nombre ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $docente = new Docente();
                $docente->cargar($fila[0], $fila[1]);
                $this->docentes[] = $docente;
            }
        } else {
            $this->docentes[] = null;
        }
    }
    
    /**
     * @return multitype:Docente 
     */
    public function getDocentes()
    {
        return $this->docentes;
    }

    /**
     * @param multitype:Docente  $docentes
     */
    public function setDocentes($docentes)
    {
        $this->docentes = $docentes;
    }
    
    
}