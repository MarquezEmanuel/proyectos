<?php

/**
 * Esta clase contiene el conjunto de Cursadas. Se puede realizar la creacion,
 * busqueda y eliminacion de un conjunto de cursadas sobre la base de datos.
 * 
 * Fecha de creación = 28/10/2017.
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @authos Marquez Emanuel.
 * */
class Cursadas 
{
    /** @var Cursada[] */
    private $cursadas;
    
    /** @var mysqli_result */
    private $datos;
    
    /**
     * Constructor de clase.
     * */
    function  __construct()
    {
        $this->cursadas = array();
    }
    
    /**
     * @return multitype:Cursada 
     */
    public function getCursadas()
    {
        return $this->cursadas;
    }

    /**
     * @param multitype:Cursada  $cursadas
     */
    public function setCursadas($cursadas)
    {
        $this->cursadas = $cursadas;
    }

    /**
     * Realiza la creacion de un conjunto de horarios de cursada.
     * @param Cursada[] $cursadas
     * */
    public function crear($cursadas)
    {
        /* Indica un mensaje a mostrar */
        $mensaje = "";
        /* Indica si se han creado las cursadas */
        $creacion = true;
        /* Indica las cursadas que no se han creado */
        $datos = null;
        
        if(isset($cursadas)) {
            /* Se han borrado todos los registros */
            if($this->borrar()) {
                
                $tamanio = count($cursadas);
                /* Contador con la cantidad de cursadas que se han creado */
                $contadorexitos = 0;
                foreach ($cursadas as $cursada) {
                    
                    $plan = $cursada->getPlan();
                    $asignatura = new Asignatura();
                    $asignatura->crear($plan->getAsignatura()->getNombre());
                    
                    $carrera = new Carrera();
                    $carrera->crear($plan->getCarrera()->getCodigo(), $plan->getCarrera()->getNombre());
                    
                    $plan->crear($asignatura->getIdasignatura(), $carrera->getCodigo(), $plan->getAnio());
                    $plan->setAsignatura($asignatura);
                    $plan->setCarrera($carrera);
                    
                    $clases = $cursada->getClases();
                    
                    foreach ($clases as $clase) {
                        $aula = $clase->getAula();
                        $aula->crear($aula->getNombre(), $aula->getSector());
                    }
                    
                    $creada = $cursada->crear($plan, $clases);
                    
                    if ($creada) {
                        /* Se ha creado correctamente la cursada */
                        $contadorexitos = $contadorexitos + 1;
                    } else {
                        $datos [] = $cursada;
                    }
                }
                
                if ($contadorexitos > 0) {
                    $mensaje = "Se han creado ".$contadorexitos." horarios de cursada sobre ".$tamanio." recibidos";
                    
                } else {
                    $mensaje = "No se han creado horarios de cursada para un total de ".$tamanio." recibidos";
                }
                
            } else {
                /* No se han borrado todos los registros existentes */
                $mensaje = 'No se ha podido realizar la eliminación de los horarios de cursada actuales';
                $creacion = false;
            }
        } else {
            /* El parametro cursadas no esta definido o es nulo (ISSET) */
            $mensaje = 'No se han recibido los horarios de cursada a crear';
            $creacion = false;
        }
       
        $resultado = array('resultado'=>$creacion,'mensaje'=>$mensaje, 'datos'=>$datos);
        return $resultado;
    }
    
    /**
     * Realiza la eliminacion de todas las cursadas cargadas en la base de datos.
     * Para ello realiza la eliminación de cada uno de los registros de las tablas
     * clase y cursada.
     * @return boolean true o false.
     * @author Márquez Emanuel.
     * */
    public function borrar()
    {
        ObjetoDatos::getInstancia()->autocommit(false);
        ObjetoDatos::getInstancia()->begin_transaction();
        try {
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM clase WHERE 1");
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM cursada WHERE 1");
        } catch (Exception $exception) {
            return false;
        }
        ObjetoDatos::getInstancia()->commit();
        ObjetoDatos::getInstancia()->autocommit(true);
        return true;
    }
    
    /**
     * Realiza la búsqueda de horarios de cursada para una asignatura. Cuando 
     * no se establece el nombre de la asignatura, se obtienen todos los 
     * horarios cargados.
     * @param string $asignatura Nombre de la Asignatura.
     * @return array resultado, mensaje y datos.
     * @author Márquez Emanuel.
     * */
    public function buscar($asignatura) 
    {
        $consulta =  " SELECT cu.idasignatura, cu.idcarrera " 
                    ." FROM cursada cu, asignatura a, carrera ca WHERE "
                    ." cu.idasignatura=a.idasignatura AND cu.idcarrera=ca.codigo ";
        if ($asignatura) {
            $consulta = $consulta." AND a.nombre LIKE '%{$asignatura}%' ";
        }
        
        $consulta = $consulta." ORDER BY cu.idcarrera ASC, a.nombre ASC ";
        
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        $tamanio =  $this->datos->num_rows;
        if($tamanio > 0) {
            
            $registros = array();
            $plan = new Plan();
            while ($fila = mysqli_fetch_array($this->datos)) {
                
                $idasignatura = $fila[0];
                $idcarrera = $fila[1];
               
                
                if ($plan->getAsignatura() && $plan->getCarrera()) {
                    
                    $asignaturaplan = $plan->getAsignatura()->getIdasignatura();
                    $carreraplan = $plan->getCarrera()->getCodigo();
                    
                    if(($idasignatura != $asignaturaplan) || ($idcarrera != $carreraplan)) {
                        
                        $plan = new Plan($idasignatura, $idcarrera);
                        $cursada = new Cursada();
                        $cursada->setPlan($plan);
                        $cursada->obtenerHorarios($idasignatura, $idcarrera);
                        $registros [] = $cursada;
                    }
                    
                } else {
                    $plan = new Plan($idasignatura, $idcarrera);
                    $cursada = new Cursada();
                    $cursada->setPlan($plan);
                    $cursada->obtenerHorarios($idasignatura, $idcarrera);
                    $registros [] = $cursada;
                }
            }
            
            $mensaje = "Se han encontrado resultados para la búsqueda";
            if ($asignatura) {
                $mensaje = " '{$asignatura}' ";
            }
            return array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>$registros);
        } else {
            $mensaje = "No se han encontrado resultados para el campo ingresado";
            if ($asignatura) {
                $mensaje = " ({$asignatura}) "; 
            }
            return array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
    }
    
    
    public function informe($idcarrera, $dia, $inicio, $fin) 
    {
        $this->cursadas = null;
        $consulta = "SELECT idcarrera, idasignatura FROM cursada WHERE 1 GROUP BY idcarrera, idasignatura";
        if($idcarrera != 'todas' || $dia != 'todos' || $inicio != 'todas' || $fin != 'todas') {
            $consulta = "SELECT cu.idcarrera, cu.idasignatura FROM cursada cu, clase cl WHERE cu.idclase=cl.idclase ";
            if($idcarrera != 'todas') {
                $consulta = $consulta."AND cu.idcarrera=".$idcarrera." ";
            }
            if($dia != 'todos') {
                $consulta = $consulta."AND cl.dia=".$dia." ";
            }
            if($inicio != 'todas') {
                $consulta = $consulta."AND cl.desde='".$inicio."' ";
            }
            if($fin != 'todas') {
                $consulta = $consulta."AND cl.hasta='".$fin."' ";
            }
            $consulta = $consulta."GROUP BY cu.idcarrera, cu.idasignatura";
        }
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if($this->datos->num_rows > 0) {
            $this->cursadas = array();
            while ($fila = mysqli_fetch_array($this->datos)) {
                $plan = new Plan($fila[1], $fila[0]);
                $cursada = new Cursada();
                $cursada->setPlan($plan);
                $cursada->obtenerHorarios($fila[1], $fila[0]);
                $this->cursadas[]=$cursada;
            }
        }
        
    }
    
}
