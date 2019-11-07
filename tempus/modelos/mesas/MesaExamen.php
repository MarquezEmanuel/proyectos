<?php

/**
 * 
 * */
class MesaExamen
{
    /** @var integer Identificador de la mesa en la base de datos. */
    private $idmesa;
    
    /** @var Plan Asignatura y Carrera a la que pertenece la mesa. */
    private $plan;
    
    /** @var Tribunal Tribunal de la mesa. */
    private $tribunal;
    
    /** @var Llamado Primer llamado. */
    private $primero;
    
    /**@var Llamado Segundo llamado.  */
    private $segundo;
    
    /** @var mysqli_result Resultado de una consulta a la base de datos. */
    private $datos;
    
    function __construct($idmesa = null)
    {
       
    }
    
    /**
     * @return integer $idmesa
     */
    public function getIdmesa()
    {
        return $this->idmesa;
    }

    /**
     * @return Plan $plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return Tribunal $tribunal
     */
    public function getTribunal()
    {
        return $this->tribunal;
    }

    /**
     * @return Llamado $primero
     */
    public function getPrimero()
    {
        return $this->primero;
    }

    /**
     * @return Llamado $segundo
     */
    public function getSegundo()
    {
        return $this->segundo;
    }

    /**
     * @param integer $idmesa
     */
    public function setIdmesa($idmesa)
    {
        $this->idmesa = $idmesa;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @param Tribunal $tribunal
     */
    public function setTribunal($tribunal)
    {
        $this->tribunal = $tribunal;
    }

    /**
     * @param Llamado $primero
     */
    public function setPrimero($primero)
    {
        $this->primero = $primero;
    }

    /**
     * @param Llamado $segundo
     */
    public function setSegundo($segundo)
    {
        $this->segundo = $segundo;
    }
    
    /**
     * Realiza la eliminacion de una mesa de examen. Junto con ella se deben eliminar los llamados
     * de la mesa indicada. El tribunal no se elimina porque puede estar relacionado con otra mesa
     * de examen.
     * @param MesaExamen $mesa Mesa de examen a eliminar.
     * @return boolean true o false.
     * */
    public function borrar($mesa)
    {
        if($mesa && $mesa->getIdmesa()) {
            $idmesa = $mesa->getIdmesa();
            $consulta = "DELETE FROM mesa_examen WHERE idmesa=".$idmesa;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $llamado = new Llamado();
                if($mesa->getPrimero() && $mesa->getPrimero()->getIdllamado()) {
                    $idllamado = $mesa->getPrimero()->getIdllamado();
                    $llamado->borrar($idllamado);
                }
                if($mesa->getSegundo() && $mesa->getSegundo()->getIdllamado()) {
                    $idllamado = $mesa->getSegundo()->getIdllamado();
                    $llamado->borrar($idllamado);
                }
                return true;
            }
        }
        return false;
    }
    
    /**
     * Realiza la búsqueda de una mesa de examen. Cuando se encuentra la mesa de examen
     * se obtiene toda la información asociada. En caso contrario, cada uno de sus atributos
     * seran nulos.
     * @param Plan $plan Recibe la asignatura y carrera de la mesa de examen (Obligatorio).
     * */
    public function buscar($plan)
    {
        $idasignatura = $plan->getAsignatura()->getIdasignatura();
        $idcarrera = $plan->getCarrera()->getCodigo();
        $consulta = "SELECT * FROM mesa_examen WHERE ";
        $consulta = $consulta."idasignatura = ".$idasignatura." AND idcarrera = ".$idcarrera;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            
            $fila = $this->datos->fetch_row();
            $this->idmesa = $fila[0];
            $this->plan = new Plan($fila[1], $fila[2]);
            $this->tribunal = new Tribunal($fila[3]);
            $this->primero = new Llamado($fila[4]);
            if($fila[5]) {
                $this->segundo = new Llamado($fila[5]);
            }
            
        } else {
            $this->cargar(null, null, null, null, null);
        }
        $this->datos = null;
    }
    
    /**
     *
     * */
    public function cargar($idmesa, $plan, $tribunal, $primero, $segundo) {
        $this->idmesa = $idmesa;
        $this->plan = $plan;
        $this->tribunal = $tribunal;
        $this->primero = $primero;
        $this->segundo = $segundo;
    }
    
    /**
     * Realiza la creacion de una nueva mesa de examen. Primero se realiza la búsqueda de 
     * mesa de examen. En caso que exista, se obtiene su información. En caso contrario, 
     * se crea un nuevo registro. Para ello, tambien se hace la creacion del tribunal, 
     * primer llamado y segundo llamado. 
     * @param Plan $plan El plan debe existir en la base de datos (Obligatorio).
     * @param Tribunal $tribunal El tribunal debe existir en la base de datos (Obligatorio).
     * @param Llamado $primero El llamado se crea (Obligatorio).
     * @param Llamado $segundo El llamado se crea (Opcional).
     * @return string Mensaje asociado a la operación.
     * */
    public function crear($plan, $tribunal, $primero, $segundo) 
    {
        $this->buscar($plan);
        if (is_null($this->idmesa)) {
            /* No se ha encontrado una mesa de examen - Se crea una nueva. */
            $idasignatura = $plan->getAsignatura()->getIdasignatura();
            $idcarrera = $plan->getCarrera()->getCodigo();
            $idprimero = 'null';
            $idsegundo = 'null';
            
            /* Crea el o los llamados para la mesa de examen */
            if ($primero) {
                $idaula = null;
                if ($primero->getAula()) {
                    $idaula = $primero->getAula()->getIdaula();
                }
                
                $primero->crear($primero->getFecha(), $primero->getHora(), $idaula);
                if ($primero->getIdllamado()) {
                    $idprimero = $primero->getIdllamado();
                } else {
                    $primero = null;
                }
            }
            if ($segundo) {
                $idaula = null;
                if ($segundo->getAula()) {
                    $idaula = $segundo->getAula()->getIdaula();
                }
                $segundo->crear($segundo->getFecha(), $segundo->getHora(), $idaula);
                if ($segundo->getIdllamado()) {
                    $idsegundo = $segundo->getIdllamado();
                } else {
                    $segundo = null;
                }
            }
            
            if ($primero || $segundo) {
                $consulta = "INSERT INTO mesa_examen VALUES ";
                $consulta = $consulta."(null,".$idasignatura.",".$idcarrera.",".$tribunal->getIdtribunal().",".$idprimero.",".$idsegundo.")";
                
                ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
                
                if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                    $this->idmesa = (Int) ObjetoDatos::getInstancia()->insert_id;
                    $this->plan = $plan;
                    $this->tribunal = $tribunal;
                    $this->primero = $primero;
                    $this->segundo = $segundo;
                    return "Se ha creado la mesa de examen correctamente";
                } else {
                    $this->cargar(null, null, null, null, null);
                    return "No se ha podido realizar la creación de la mesa de examen";
                }
            } else {
                $this->cargar(null, null, null, null, null);
                return "No se ha podido realizar la creación de llamado para la mesa de examen";
            }
        }
        return "Se ha encontrado una mesa de examen para la asignatura en la carrera indicada";
    }

    /**
     * Realiza la modificación de la mesa de examen. 
     * @param integer $idmesa Recibe el identificador de la mesa de examen a modificar.
     * @param Tribunal $tribunal Recibe el tribunal de la mesa de examen.
     * @param Llamado $primero Recibe el primer llamado de la mesa de examen.
     * @param Llamado $segundo Recibe el segundo llamado de la mesa de examen.
     * @return string Mensaje con el resultado de la operación.
     * */
    public function modificar($idmesa, $tribunal, $primero, $segundo) 
    {
        if ($idmesa && $tribunal) {
            
            if ($primero || $segundo) {
                
                ObjetoDatos::getInstancia()->autocommit(false);
                ObjetoDatos::getInstancia()->begin_transaction();
                try {
                    
                    $idtribunal = $tribunal->getIdtribunal();
                    $presidente = $tribunal->getPresidente();
                    $vocal1 = $tribunal->getVocal1();
                    $vocal2 = $tribunal->getVocal2();
                    $suplente = $tribunal->getSuplente();
                    
                    $mensaje = $tribunal->modificar($idtribunal, $presidente, $vocal1, $vocal2, $suplente);
                    
                    if ($tribunal->getIdtribunal()) {
                        
                        if ($primero) {
                            
                            
                        }
                        
                        if ($segundo) {
                            
                        }
                    }
                    
                } catch (Exception $exception) {
                    ObjetoDatos::getInstancia()->rollback();
                    ObjetoDatos::getInstancia()->autocommit(true);
                    return "No se ha podido realizar la modificación por un error durante la operación";
                }
                ObjetoDatos::getInstancia()->commit();
                ObjetoDatos::getInstancia()->autocommit(true);
            }
            return "No se ha recibido la información correspondiente al llamado";
        }
        return "No se ha recibido la información necesaria para modificar la mesa de examen";
    }
    
    /**
     * Realiza la modificacion del horario para el primer llamado, segundo llamado o ambos. Se debe
     * recibir por parametro al menos uno de los llamados, el restante puede ser nulo. Al recibir 
     * dos llamados, ambos tendran la hora indicada. El metodo devuelve verdadero cuando la operacion
     * en la base de datos se lleva a cabo, en caso contrario, devuelve falso. 
     * @param Llamado $primero Primer llamado de la mesa de examen.
     * @param Llamado $segundo Segundo llamado de la mesa de examen.
     * @param string $hora Recibe el horario a asignar a los llamados.
     * @return boolean
     * */
    public function modificarHora($primero, $segundo, $hora) 
    {
        if ($primero && $segundo) {
            $idprimero = $primero->getIdllamado();
            $idsegundo = $segundo->getIdllamado();
            $consulta = "UPDATE llamado SET hora='{$hora}', fechamod=NOW() WHERE idllamado=".$idprimero." OR idllamado=".$idsegundo;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) { 
                $primero->setHora($hora);
                $segundo->setHora($hora);
                return true;
            }
        } else {
            if ($primero) {
                $idprimero = $primero->getIdllamado();
                $primero->modificarHora($idprimero, $hora);
                if ($primero->getIdllamado()) {
                    return true;
                }
            } else {
                $idsegundo = $segundo->getIdllamado();
                $segundo->modificarHora($idsegundo, $hora);
                if ($segundo->getIdllamado()) {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * @param Tribunal $tribunal Tribunal original de la mesa de examen.
     * @param string $presidente Nombre del nuevo presidente.
     * @param string $vocal1 Nombre del nuevo vocal1.
     * @param string $vocal2 Nombre del nuevo vocal2.
     * @param string $suplente Nombre del nuevo suplente.
     * */
    public function modificarTribunal($tribunal, $nombrepresidente, $nombrevocal1, $nombrevocal2, $nombresuplente)
    {
        if ($tribunal && $nombrepresidente && $nombrevocal1) {
            $presidente = new Docente();
            $vocal1 = new Docente();
            $vocal2 = null;
            $suplente  = null;
            
            $presidente->crear($nombrepresidente);
            $vocal1->crear($nombrevocal1);
            if ($nombrevocal2) {
                $vocal2 = new Docente();
                $vocal2->crear($nombrevocal2);
                if ($nombresuplente) {
                    $suplente  = new Docente();
                    $suplente->crear($nombresuplente);
                }
            }
            /* VERIFICA QUE LOS DOS DOCENTES OBLIGATORIOS SE HAYAN CREADO */
            if ($presidente->getIdDocente() &&  $vocal1->getIdDocente()) {
                $idtribunal = $tribunal->getIdtribunal();
                if ($vocal2 && !$vocal2->getIdDocente()) {
                   /* HAY NOMBRE VOCAL 2, SE CREO EL DOCENTE PERO NO EL REGISTRO */
                   return false;
                } else {
                    if ($suplente && !$suplente->getIdDocente()) {
                        /* HAY NOMBRE SUPLENTE, SE CREO EL DOCENTE PERO NO EL REGISTRO */
                        return false;
                    }
                }
                $tribunal->modificar($idtribunal, $presidente, $vocal1, $vocal2, $suplente);
                if($tribunal->getIdtribunal()) {
                    return true;
                }
            }
        }
        return false;
    }

}
