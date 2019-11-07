<?php

/**
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Llamado {
    
    /** @var integer */
    private $idllamado;
    
    /** @var string */
    private $fecha;
    
    /** @var string */
    private $hora;
    
    /** @var Aula */
    private $aula;
    
    /** @var string Fecha de modificacion */
    private $fechamod;
    
    /** @var mysqli_result */
    private $datos;

    /**
     * Constructor de clase. Cuando recibe el identificador del llamado realiza la busqueda de la 
     * informacion en la base de datos. En caso contrario, se crea con sus atributos nulos.
     * @param integer $idllamado Identificador del llamado.
     * */
    function __construct($idllamado = NULL){
        if($idllamado) {
            $consulta = "SELECT idllamado, DATE_FORMAT(fecha, '%d/%m/%Y'), DATE_FORMAT(hora, '%H:%i'), idaula, DATE_FORMAT(fechamod, '%d/%m/%Y') FROM llamado WHERE idllamado = ".$idllamado;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->idllamado = $fila[0];
                $this->fecha = $fila[1];
                $this->hora = $fila[2];
                $this->aula = null;
                if($fila[3]) {
                    $this->aula = new Aula($fila[3]);
                }
                $this->fechamod = $fila[4];
            }
            $this->datos = null;
        }
    }
    /**
     * @return integer $idllamado
     */
    public function getIdllamado()
    {
        return $this->idllamado;
    }

    /**
     * @return string $fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return string $hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @return Aula $aula
     */
    public function getAula()
    {
        return $this->aula;
    }
    
    /**
     * @return string $fechamod
     * */
    public function getFechamod()
    {
        return $this->fechamod;
    }
    
    /**
     * @param integer $idllamado
     */
    public function setIdllamado($idllamado)
    {
        $this->idllamado = $idllamado;
    }

    /**
     * @param string $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @param string $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }
    
    /**
     * @param Aula $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }
    
    /**
     * @param string $fechamod
     * */
    public function setFechamod($fechamod)
    {
        $this->fechamod = $fechamod;
    }
    
    /**
     * Realiza la creacion de una nueva fecha de llamado para una mesa de examen. 
     * @param string $fecha Fecha en formato YYYY-MM-DD (Obligatorio).
     * @param string $hora Hora en formato HH:MM (Obligatorio).
     * @param integer $aula Identificador de aula (Opcional).
     * @author Marquez Emanuel.
     * */
    public function crear($fecha, $hora, $aula = NULL)
    {
        if (!$aula) {
            $aula = "NULL";
        }
        ObjetoDatos::getInstancia()->ejecutarQuery("INSERT INTO llamado VALUES (null,'".$fecha."','".$hora."',".$aula.", NULL)");
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            $this->idllamado = (Int) ObjetoDatos::getInstancia()->insert_id;
            $this->fecha = date('d/m/Y', strtotime($fecha));
            $this->hora = $hora;
            if ($aula) {
                $this->aula = new Aula($aula);
            } else {
                $this->aula = null;
            }
        } else {
            $this->cargar(null, null, null, null, null);
        }
    }
    
    /**
     * Realiza la eliminacion de un llamado en la base de datos a partir de su identificador. Se
     * devuelve verdadero en caso de realizar la eliminacion correctamente y falso en caso contrario.
     * @param integer $idllamado Identificador del llamado.
     * @return boolean true o false.
     * */
    public function borrar($idllamado)
    {
        if($idllamado) {
            $consulta = "DELETE FROM llamado WHERE idllamado=".$idllamado;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Asigna los valores indicados por parametro a cada uno de los atributos del llamado.
     * @param integer $idllamado Identificador del llamado.
     * @param string $fecha Fecha del llamado.
     * @param string $hora Hora del llamado.
     * @param Aula $aula Aula donde se dicta la mesa.
     * @param string $fechamod Fecha de ultima modificacion.
     * */
    private function cargar($idllamado, $fecha, $hora, $aula, $fechamod)
    {
        $this->idllamado = $idllamado;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->aula = $aula;
        $this->fechamod = $fechamod;
    }
    
    /**
     * Realiza la modificación del llamado indicado. Cuando la operación se hace correctamente, se 
     * asignan los parametros recibidos al llamado. En caso contrario, los atributos del llamado 
     * seran todos nulos.
     * @param integer $idllamado Recibe el identificador del llamado a modificar.
     * @param string $fecha Recibe la fecha en formato YYYY-MM-DD. 
     * @param string $hora Recibe la hora en formato HH:MM. 
     * @param Aula $aula Recibe el aula.
     * */
    public function modificar($idllamado, $fecha, $hora, $aula)
    {
        if ($idllamado && $fecha && $hora) {
            $consulta = "UPDATE llamado SET fecha='{$fecha}', hora='{$hora}', fechamod=NOW() WHERE idllamado=".$idllamado;
            if ($aula && $aula->getIdaula()) {
                $idaula = $aula->getIdaula();
                $consulta = "UPDATE llamado SET fecha='{$fecha}', hora='{$hora}', idaula={$idaula}, fechamod=NOW() WHERE idllamado=".$idllamado;
            }
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                if ($aula) {
                    $this->cargar($idllamado, $fecha, $hora, $aula);
                } else {
                    $this->cargar($idllamado, $fecha, $hora, null);
                }
            } else {
                $this->cargar(null, null, null, null);
            }
        } else {
            $this->cargar(null, null, null, null);
        }
    }
    
    /**
     * Realiza la modificacion del aula para el llamado que se indica. Cuando la operacion se
     * hace correctamente se asigna la nueva aula al objeto, en caso contrario los atributos del
     * mismo seran nulos. La modificacion del horario actualiza la fechamod en la base de datos
     * con la fecha actual.
     * @param integer $idllamado Identificador del llamado a modificar.
     * @param Aula $aula Horario del llamado en formato HH:MM.
     * */
    public function modificarAula($idllamado, $aula) {
        if ($idllamado && $aula) {
            $idaula = $aula->getIdaula();
            $consulta = "UPDATE llamado SET idaula={$idaula}, fechamod=NOW() WHERE idllamado=".$idllamado;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $this->aula = $aula;
            } else {
                $this->cargar(null, null, null, null);
            }
        } else {
            $this->cargar(null, null, null, null);
        }
    }
    
    /**
     * Realiza la modificacion del horario para el llamado que se indica. Cuando la operacion se 
     * hace correctamente se asigna el nuevo horario al objeto, en caso contrario los atributos
     * del mismo seran nulos. La modificacion del horario actualiza la fechamod en la base de datos
     * con la fecha actual.
     * @param integer $idllamado Identificador del llamado a modificar.
     * @param string $hora Horario del llamado en formato HH:MM.  
     * */
    public function modificarHora($idllamado, $hora) {
        if ($idllamado && $hora) {
            $consulta = "UPDATE llamado SET hora='{$hora}', fechamod=NOW() WHERE idllamado=".$idllamado;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) { 
                $this->hora = $hora;
                $this->fechamod = date("d/m/Y",time());
            } else {
                $this->cargar(null, null, null, null);
            }
        } else {
            $this->cargar(null, null, null, null);
        }
    }
    
    /**
     * Realiza la modificacion de la fecha para el llamado que se indica. Cuando la operacion se
     * hace correctamente se asigna la nueva fecha al objeto, en caso contrario, los atributos del
     * mismo seran nulos. La modificacion de la fecha para un llamado actualiza la fechamod en la
     * base de datos con la fecha actual.
     * @param integer $idllamado Identificador del llamado a modificar.
     * @param string $fecha Nueva fecha en formato AAAA-MM-DD.  
     * */
    public function modificarFecha($idllamado, $fecha) 
    {
        if ($idllamado && $fecha) {
            $consulta = "UPDATE llamado SET fecha='{$fecha}', fechamod=NOW() WHERE idllamado=".$idllamado;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $this->fecha = date('d/m/Y', strtotime($fecha));
                $this->fechamod = date("d/m/Y",time());
            } else {
                $this->cargar(null, null, null, null);
            }
        } else {
            $this->cargar(null, null, null, null);
        }
    }

}