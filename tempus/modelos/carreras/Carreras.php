<?php

class Carreras 
{
    /** @var Carrera[] $carreras */
    private $carreras;
    
    /** @var mysqli_result $datos */
    private $datos;
    
    /**
     * Constructor de la clase Carreras. Obtiene todas las carreras que se encuentren cargadas en la
     * tabla carrera de la base de datos. Los registros se encuentran ordenados por nombre en forma
     * ascendente. Los registros obtenidos se almacenan en el arreglo de carreras. Cuando no se 
     * obtienen datos el arreglo sera nulo.
     * */
    function __construct() 
    {
        $this->carreras = array();
        $consulta = "SELECT * FROM carrera WHERE 1 ORDER BY nombre ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $carrera = new Carrera();
                $carrera->cargar($fila[0], $fila[1]);
                $this->carreras[] = $carrera;
            }
        } else {
            $this->carreras[] = null;
        }
    }
    
    /**
     * @return multitype:Carrera 
     */
    public function getCarreras()
    {
        return $this->carreras;
    }

    /**
     * @param multitype:Carrera  $carreras
     */
    public function setCarreras($carreras)
    {
        $this->carreras = $carreras;
    }

    
    
}