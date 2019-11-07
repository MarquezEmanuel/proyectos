<?php

/**
 * 
 * */
class Aula 
{
    /** @var integer Identificador del aula en la base de datos. */
    private $idaula;
    
    /** @var string Nombre del aula. */
    private $nombre;
    
    /** @var string Sector donde se ubica el aula. */
    private $sector;
    
    /** @var mysqli_result Resultado de una consulta a la base de datos. */
    private $datos;
    
    /**
     * Constructor de clase. Cuando se indica un identificador de aula, se realiza
     * la búsqueda de la informacion en la base de datos. En caso contrario, se
     * hace la creacion del aula con los atributos nulos.
     * @param integer $idaula Identificador del aula (Opcional). 
     * */
    function __construct($idaula = null)
    {
        if ($idaula) {
            $consulta = "SELECT * FROM aula WHERE idaula = ".$idaula;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->idaula = $fila[0];
                $this->nombre = $fila[1];
                $this->sector = $fila[2];
            }
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve el identificador del aula. 
     * @return integer $idaula
     */
    public function getIdaula()
    {
        return $this->idaula;
    }
    
    /**
     * Devuelve el nombre del aula.
     * @return string $nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Devuelve el sector del aula.
     * @return string $sector
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Modifica el identificador del aula.
     * @param integer $idaula
     */
    public function setIdaula($idaula)
    {
        $this->idaula = $idaula;
    }
    
    /**
     * Modifica el nombre del aula.
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Modifica el sector del aula.
     * @param string $sector
     */
    public function setSector($sector)
    {
        $this->sector = $sector;
    }
    
    /**
     * Realiza la búsqueda de un aula en la base de datos. Busca un aula usando el sector y nombre.
     * Si el aula se encuentra cargada en la base de datos, se actualizan los atributos. En caso
     * contrario, los atributos serán nulos. La busqueda en la base de datos se realiza igualando
     * los parametros ingresados con los campos de la tabla Aula. No se obtienen similares.
     * @param string $nombre Nombre del aula (Obligatorio).
     * @param string $sector Sector donde se ubica el aula (Obligatorio).
     * */
    public function buscar($nombre, $sector)
    {
        $consulta = "SELECT * FROM aula WHERE nombre = '".$nombre."' AND sector = '".$sector."' ";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $fila = $this->datos->fetch_row();
            $this->cargar($fila[0], $fila[1], $fila[2]);
        } else {
            $this->cargar(null,null,null);
        }
        $this->datos = null;
    }
    
    /**
     * Asigna los valores indicados por parametro a los atributos de la clase.
     * @param integer $idaula Identificador de aula. 
     * @param string $nombre Nombre del aula.
     * @param string $sector Nombre del sector.
     * */
    public function cargar($idaula, $nombre, $sector)
    {
        $this->idaula = $idaula;
        $this->nombre = $nombre;
        $this->sector = $sector;
    }
    
    /**
     * Se realiza la creacion de una nueva aula en la base de datos. Primero se verifica que no 
     * exista el aula mediante una busqueda. Si el aula existe, se obtiene la informacion y se 
     * asigna a los atributos de clase. En caso contrario, se crea y se obtiene su identificador.
     * @param string $nombre Nombre del Aula (Obligatorio).
     * @param string $sector Nombre del sector donde se ubica el Aula (Obligatorio).
     * */
    public function crear($nombre, $sector)
    {
        $this->buscar($nombre, $sector);
        if (is_null($this->idaula)) {
            $consulta = "INSERT INTO aula VALUES (NULL,'".$nombre."','".$sector."')";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $idaula = (Int) ObjetoDatos::getInstancia()->insert_id;
                $this->cargar($idaula, $nombre, $sector);
            } else {
                $this->cargar(null,null,null);
            }
        }
    }
    
    /**
     * Modifica la informacion del aula. Si la informacion corresponde con otra aula no se modifica
     * la indicada, se obtiene la informacion de la existente.
     * @param integer $idaula Identificador del aula.
     * @param string $nombre Nombre del aula.
     * @param string $sector Nombre del sector.
     * */
    public function modificar($idaula, $nombre, $sector)
    {
        $this->buscar($nombre, $sector);
        if (is_null($this->idaula)) {
            $consulta = "UPDATE aula SET nombre='".$nombre."', sector='".$sector."' WHERE idaula=".$idaula;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $this->cargar($idaula, $nombre, $sector);
            } else {
                $this->cargar(null,null,null);
            }
        }
    }
    
    public function obtenerHorarios($idaula)
    {
        $consulta = "SELECT DISTINCT(a.idasignatura), cl.dia, a.nombre, DATE_FORMAT(cl.desde, '%H:%i'), DATE_FORMAT(cl.hasta, '%H:%i') 
                    FROM asignatura a, cursada cu, clase cl 
                    WHERE a.idasignatura = cu.idasignatura AND cu.idclase = cl.idclase AND cl.idaula = {$idaula} 
                    ORDER BY cl.dia ASC, cl.desde ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        $filas = $this->datos->num_rows;
        if ($filas > 0) {
            $lunes = array();
            $martes = array();
            $miercoles = array();
            $jueves = array();
            $viernes = array();
            $horarios = array();
            
            while ($fila = mysqli_fetch_array($this->datos)) {
                
                switch ($fila[1]) {
                    case 1:
                        $lunes[] = array ('nombre'=>$fila[2], 'inicio'=>$fila[3], 'fin'=>$fila[4]);
                        break;
                    case 2:
                        $martes[] = array ('nombre'=>$fila[2], 'inicio'=>$fila[3], 'fin'=>$fila[4]);
                        break;
                    case 3:
                        $miercoles[] = array ('nombre'=>$fila[2], 'inicio'=>$fila[3], 'fin'=>$fila[4]);
                        break;
                    case 4:
                        $jueves[] = array ('nombre'=>$fila[2], 'inicio'=>$fila[3], 'fin'=>$fila[4]);
                        break;
                    case 5:
                        $viernes[] = array ('nombre'=>$fila[2], 'inicio'=>$fila[3], 'fin'=>$fila[4]);
                        break;
                }
            }
            $horarios[] = new Aula($idaula);
            $horarios[] = $lunes;
            $horarios[] = $martes;
            $horarios[] = $miercoles;
            $horarios[] = $jueves;
            $horarios[] = $viernes;
            return $horarios;
        }
        return null;
    }
    
    /**
     * Verifica la disponilidad del aula para un determinado dia. Se controla que exista una clase 
     * en el mismo horario que el indicado. Devuelve falso si el aula esta ocupada y verdadero si 
     * esta disponible en ese horario.
     * @param integer $idaula Identificador de aula.
     * @param integer $dia Dia de la semana (1,2,3,4,5,6).
     * @param string $desde Hora de inicio HH:MM:SS.
     * @param string $hasta Hora de fin HH:MM:SS.
     * @return boolean True o false.
     * */
    public function verificarDisponibilidad ($idaula, $dia, $desde, $hasta) 
    {
        $consulta = "SELECT idclase FROM clase WHERE dia=".$dia." AND idaula=".$idaula." AND (desde='".$desde."' AND hasta='".$hasta."')";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Verifica la disponibilidad del aula para un dia determinado. Este metodo controla que una 
     * clase no empiece o termine entre las horas de inicio y fin indicadas. No muestra si hay una
     * clase que inicie a la misma hora y finalice a la misma hora. Esto se realiza como opcion 
     * intermedia dado que puede haber clases distintas en la misma aula. El metodo devuelve falso 
     * si no esta dispobible y verdadero si esta disponible.
     * @param integer $idaula Identificador de aula.
     * @param integer $dia Dia de la semana (1,2,3,4,5,6).
     * @param string $desde Hora de inicio HH:MM:SS.
     * @param string $hasta Hora de fin HH:MM:SS.
     * @return boolean True o false.
     * */
    public function verificarDisponibilidadFranja($idaula, $dia, $desde, $hasta)
    {
        $consulta = "SELECT idclase FROM clase WHERE dia=".$dia." AND idaula=".$idaula." AND ((desde>'".$desde."' AND desde<'".$hasta."') OR (hasta>'".$desde."' AND hasta<'".$hasta."'))";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }
    
}