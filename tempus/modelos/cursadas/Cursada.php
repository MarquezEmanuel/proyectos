<?php

/**
 * La clase Cursada corresponde a la tabla "Cursada" de la base de datos. Dicha tabla representa una
 * relacion muchos a muchos entre un plan (asignatura-carrera) y clases. 
 * 
 * */
class Cursada 
{
    /** @var Plan  */
    private $plan;
    
    /** @var Clase[] */
    private $clases;
    
    /** @var mysqli_result */
    private $datos;
   
    /**
     * Constructor de clase.
     * */ 
    function __construct()
    {
        $this->clases = array();
    }
    
    /**
     * @return Plan $plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return Clase[] $clases
     */
    public function getClases()
    {
        return $this->clases;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @param Clase[] $clases
     */
    public function setClases($clases)
    {
        $this->clases = $clases;
    }

    
    /**
     * Se crea la clase y la relacion entre el plan y la nueva clase. Si se crea la clase y la 
     * relacion devuelve verdadero. En caso de no crearse la clase o la relacion entonces se
     * retorna falso.
     * @param Plan $plan Informacion de la carrera y asignatura.
     * @param Clase $clase Informacion de la clase a crear.
     * @return integer Identifcador de clase o nulo.
     * */
    public function agregarClase($plan, $clase) 
    {
        $dia = $clase->getDia();
        $desde = $clase->getDesde();
        $hasta = $clase->getHasta();
        $aula = $clase->getAula();
        $clase->crear($dia, $desde, $hasta, $aula);
        if($clase->getIdclase()) {
            $asignatura = $plan->getAsignatura();
            $carrera = $plan->getCarrera();
            $idasignatura = $asignatura->getIdasignatura();
            $idcarrera = $carrera->getCodigo();
            $idclase = $clase->getIdclase();
            $crearelacion = $this->crearRelacion($idasignatura, $idcarrera, $idclase);
            if($crearelacion){
                return $idclase;
            } else {
                $clase->borrar($idclase);
                return null;
            }
        } else {
            return null;
        }
    }
    
    public function cargar($plan, $clases)
    {
        $this->plan = $plan;
        $this->clases = $clases;
    }
    
    /**
     * Realiza la creacion completa de una cursada. Este metodo se encarga de crear la carrera, la 
     * asignatura, plan, clases y cursada. Si la creacion exitosa el objeto tendra asignado el plan
     * y horarios de clase, en caso contrario seran nulos. Cuando la cursada solo contenga un plan
     * y no las clases significa que ya existia la cursasa entre la asignatura y carrera.
     * @param integer $codigoCarrera Codigo de la nueva o existente Carrera.
     * @param string $nombreCarrera Nombre de la nueva o exitente Carrera.
     * @param string $nombreAsignatura Nombre de la nueva o existente Asignatura.
     * @param integer $anio Anio al que pertenece la Asignatura en la Carrera.
     * @param array $clases Horarios de clases.
     * */
    public function crearCursada($codigoCarrera, $nombreCarrera, $nombreAsignatura, $anio, $clases)
    {
        if ($codigoCarrera && $nombreCarrera && $nombreAsignatura && $anio && $clases) {
            $carrera = new Carrera();
            $asignatura = new Asignatura();
            $carrera->crear($codigoCarrera, $nombreCarrera);
            $asignatura->crear($nombreAsignatura);
            if ($asignatura->getIdasignatura() && $carrera->getCodigo()) {
                $idasignatura = $asignatura->getIdasignatura();
                $idcarrera = $carrera->getCodigo();
                $plan = new Plan();
                $plan->buscar($idasignatura, $idcarrera);
                if(!$plan->getAsignatura() && !$plan->getCarrera()) {
                    /* NO EXISTE UN PLAN ENTRE LA ASIGNATRA Y CARRERA*/
                    $creacion = $plan->crear($idasignatura, $idcarrera, $anio);
                    if ($creacion) {
                        $plan->cargar($asignatura, $carrera, $anio);
                        $creaClases = $this->crear($plan, $clases);
                        if($creaClases) {
                            $this->cargar($plan, $clases);
                        } else {
                            $this->cargar(null, null);
                        }
                    } else {
                        $this->cargar(null, null);
                    }
                } else {
                    $this->cargar($plan, null);
                }
            } else {
                $this->cargar(null, null);
            }
        } else {
            $this->cargar(null, null);
        }
    }
    
    /**
     * Realiza la creación de una cursada. Para ello realiza la creacion de cada una de las clases 
     * del arreglo y luego crea la relación entre el plan y la clase. Devuelve verdadero cuando 
     * ambos registros se crean, falso cuando no se crea la clase o la relación (tabla cursada de 
     * la base de datos).
     * @param Plan $plan Asignatura y Carrera para la Cursada (Obligatorio).
     * @param Clase[] $clases Recibe el conjunto de clases para el plan (Obligatorio).
     * @return boolean true o false.
     * */
    public function crear($plan, $clases = array())
    {
        $creacion = false;
        if (isset($clases)) {
            $tamanio = count($clases);
            $idasignatura = $plan->getAsignatura()->getIdasignatura();
            $idcarrera = $plan->getCarrera()->getCodigo();
            $contadorexitos = 0;
            for ($i=0; $i < $tamanio; $i++) {
                $clase =  $clases[$i];
                $dia = $clase->getDia();
                $desde = $clase->getDesde();
                $hasta = $clase->getHasta();
                $aula = $clase->getAula();
                $clase->crear($dia, $desde, $hasta, $aula);
                $idclase = $clase->getIdclase();
                if ($idclase) {
                    $resultado = $this->crearRelacion($idasignatura, $idcarrera, $idclase);
                    if ($resultado) {
                        $creacion = true;
                        $this->clases [] = $clase;
                    }
                }
            }
        }
        return $creacion;
    }
    
    /**
     * Crea una nueva relacion entre cursada y clase.
     * @param integer $idasignatura Identificador de la asignatura.
     * @param integer $idcarrera Identificador de la carrera.
     * @param integer $idclase Identificador de la clase.
     * */
    private function crearRelacion($idasignatura, $idcarrera, $idclase)
    {
        $resultado = $this->buscarRelacion($idasignatura, $idcarrera, $idclase);
        if (!$resultado) { 
            $consulta = "INSERT INTO cursada VALUES (".$idasignatura.",".$idcarrera.",".$idclase.")";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $resultado = true;
            } else {
                $resultado = false;
            }
        }
        return $resultado;
    }
    
    /**
     * 
     * */
    public function borrar($idasignatura, $idcarrera)
    {
        $consulta = "DELETE FROM cursada WHERE idasignatura={$idasignatura} AND idcarrera={$idcarrera}";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            return true;
        }
        return false;
    }
    
    
    /**
     * Controla que no exista cargada la relacion entre cursada y clase.
     * @return boolean Verdadero si existe o Falso en caso contrario.
     * */
    private function buscarRelacion($idasignatura, $idcarrera, $idclase)
    {
        $consulta = "SELECT * FROM cursada WHERE idasignatura = ".$idasignatura." AND idcarrera = ".$idcarrera." AND idclase = ".$idclase."";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            return true;
        }
        return false;
    }
    
    /**
     * Elimina una relacion entre asignatura y clase. Se mantiene la clase dado que puede estar
     * asociada a otras carreras. Cuando se realiza la eliminacion el metodo devuelve true. Si no
     * se hace la eliminacion, devuelve false.
     * @param integer $idasignatura Identificador de la Asignatura.
     * @param integer $idcarrera Identificador de la Carrera.
     * @param integer $idclase Identificador de la Clase.
     * @retun boolean true o false.
     * */
    private function borrarRelacion($idasignatura, $idcarrera, $idclase)
    {
        $consulta = "DELETE FROM cursada WHERE idasignatura=".$idasignatura." AND idcarrera=".$idcarrera." AND idclase=".$idclase;
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            return true;
        }
        return false;
    }
    
    /**
     * Obtiene las clases de una asignatura para una determinada carrera.
     * */
    public function obtenerHorarios($idasignatura, $idcarrera)
    {
        $consulta = "SELECT idclase FROM cursada WHERE idasignatura={$idasignatura} AND idcarrera=".$idcarrera;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $this->clases = array(6);
            while ($fila = mysqli_fetch_array($this->datos)) {
                $clase = new Clase($fila[0]);
                $this->clases [$clase->getDia()] = $clase;
            }
        } else {
            $this->clases = null;
        }
        $this->datos = null;
    }
    
    /**
     * Realiza la eliminacion de una clase para la asignatura correspondiente. Se debe considerar
     * que la clase puede ser dictada en muchas carreras. Por ello el parametro todas debe indicar
     * si la eliminacion se aplica a todas las carreras (true) o solo a una (false). En caso de
     * estar en una sola carrera, se elimina la clase y la relacion (cursada).
     * @param Plan @plan Informacion de la carrera y asignatura.
     * @param Clase @clase Informacion de la clase a eliminar.
     * @param boolean @todas Indica si borrar para todas las clases o solo la del plan.
     * */
    public function quitarClase($plan, $clase, $todas) 
    {
        $idclase = $clase->getIdclase();
        $numcarreras = $clase->contarCarreras($idclase);
        if ($numcarreras > 1) {
            if (!$todas) {
                $idasignatura = $plan->getAsignatura()->getIdasignatura();
                $idcarrera = $plan->getCarrera()->getCodigo();
                return $this->borrarRelacion($idasignatura, $idcarrera, $idclase);
            }
        }
        $clase->borrar($idclase);
        if($clase->getIdclase()) {
            return false;
        }
        return true;
    }
    
}