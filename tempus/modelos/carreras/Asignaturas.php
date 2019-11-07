<?php


class Asignaturas 
{
    
    /** @var Asignatura[] $asignaturas */
    private $asignaturas;
    
    /** @var mysqli_result $datos */
    private $datos;
    
    /**
     * Constructor de la clase Asignaturas. Obtiene todas las asignaturas que se encuentren cargadas
     * en la tabla asignatura de la base de datos. Los registros se encuentran ordenados por 
     * nombre en forma ascendente. Los registros obtenidos se almacenan en el arreglo de asignaturas. 
     * Cuando no se obtienen datos el arreglo sera nulo.
     * */
    function __construct() 
    {
        $this->asignaturas = array();
        $consulta = "SELECT * FROM asignatura WHERE 1 ORDER BY nombre ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $asignatura = new Asignatura();
                $asignatura->cargar($fila[0], $fila[1]);
                $this->asignaturas[] = $asignatura;
            }
        } else {
            $this->asignaturas[] = null;
        }
    }
    
    /**
     * @return multitype:Asignatura 
     */
    public function getAsignaturas()
    {
        return $this->asignaturas;
    }

    /**
     * @param multitype:Asignatura  $asignaturas
     */
    public function setAsignaturas($asignaturas)
    {
        $this->asignaturas = $asignaturas;
    }

    
    
    
}