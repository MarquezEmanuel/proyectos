<?php
require_once 'Carrera.php';
require_once 'Asignatura.php';

/**
 * Esta clase corresponde con la tabla asignaturas-carreras de la base de datos.
 * Contiene los metodos necesarios para crear, borrar, buscar o modificar una relación.
 * Se relaciona con la clase Asignatura y Carrera.
 *
 * Fecha de creación: 18-10-2017.
 *
 * @version 1.0
 *
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Plan 
{
    /** @var Asignatura */
    private $asignatura;
    
    /** @var Carrera */
    private $carrera;
    
    /** @var integer */
    private $anio;
    
    /** @var mysqli_result Resultado de una consulta a la base de datos. */
    private $datos;
    
    /**
     * Constructor de clase.
     * @param integer $idasignatura Identificador de la Asignatura (Opcional).
     * @param integer $idcarrera Identificador de la Carrera (Opcional).
     * */
    function __construct($idasignatura = null, $idcarrera = null) 
    {
        if($idasignatura && $idcarrera) {
            $consulta = "SELECT * FROM asignatura_carrera WHERE idasignatura = ".$idasignatura." AND idcarrera =".$idcarrera;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->asignatura = new Asignatura($fila[0]);
                $this->carrera = new Carrera($fila[1]);
                $this->anio = $fila[2];
            } 
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve la asignatura del plan.
     * @return Asignatura $asignatura
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Devuelve la carrera del plan.
     * @return Carrera $carrera
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Devuelve el anio al que pertenece la asignatura dentro de la carrera.
     * @return integer $anio
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Modifica la asignatura que pertenece a la carrera.
     * @param Asignatura $asignatura
     */
    public function setAsignatura($asignatura)
    {
        $this->asignatura = $asignatura;
    }

    /**
     * Modifica la carrera.
     * @param carrera $carrera
     */
    public function setCarrera($carrera)
    {
        $this->carrera = $carrera;
    }

    /**
     * Modifica el anio.
     * @param integer $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }
    
    /**
     * @param Asignatura $asignatura Asignatura del plan para la carrera. 
     * @param Carrera $carrera Carrera del plan. 
     * @param integer $anio Anio al que pertenece la carrera.
     * */
    public function cargar($asignatura, $carrera, $anio)
    {
        $this->asignatura = $asignatura;
        $this->carrera = $carrera;
        $this->anio = $anio;
    }

    /**
     * Realiza la creación de una nueva relación asignatura-carrera.
     * @param integer $idasignatura Identificador de la Asignatura
     * @param integer $idcarrera Identificador de la Carrera.
     * @param integer $anio Anio al que pertenece la carrera.
     * @return boolean true o false.
     * */
    public function crear($idasignatura, $idcarrera, $anio)
    {
        $resultado = true;
        $this->buscar($idasignatura, $idcarrera);
        if(!$this->asignatura && !$this->carrera) {
            $consulta = "INSERT INTO asignatura_carrera VALUES (".$idasignatura.",".$idcarrera.",".$anio.")";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $resultado = true;
            } else {
                $resultado = false;
            }
        }
        $this->datos = null;
        return $resultado;
    }
    
    public function borrar($idasignatura, $idcarrera)
    {
        
    }
    
    /**
     * Realiza la busqueda de una relación asignatura-carrera.
     * @param integer $idasignatura Recibe el identificador de la Asignatura.
     * @param integer $idcarrera Recibe el identificador de la Carrera.
     * */
    public function buscar($idasignatura, $idcarrera)
    {
        $consulta = "SELECT * FROM asignatura_carrera WHERE idasignatura = ".$idasignatura." AND idcarrera = ".$idcarrera;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $fila = $this->datos->fetch_row();
            $this->asignatura = new Asignatura($fila[0]);
            $this->carrera = new Carrera($fila[1]);
            $this->anio = $fila[2];
        } else {
            $this->cargar(null, null, null);
        }
        $this->datos = null;
    }
   
}