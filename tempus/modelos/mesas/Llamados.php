<?php
/**
 * 
 * */
class Llamados
{
    /** @var string[] */
    private $primero;
    
    /** @var string[] */
    private $segundo;
    
    /** @var mysqli_result $datos */
    private $datos;
    
    function __construct() {
        
    }
    
    /**
     * @return multitype:string 
     */
    public function getPrimero()
    {
        return $this->primero;
    }

    /**
     * @return multitype:string 
     */
    public function getSegundo()
    {
        return $this->segundo;
    }

    /**
     * @param multitype:string  $primero
     */
    public function setPrimero($primero)
    {
        $this->primero = $primero;
    }

    /**
     * @param multitype:string  $segundo
     */
    public function setSegundo($segundo)
    {
        $this->segundo = $segundo;
    }

    public function fechasPrimerLlamado()
    {
        $consulta = "SELECT DISTINCT DATE_FORMAT(ll.fecha, '%d/%m/%Y') FROM mesa_examen me, llamado ll WHERE me.primero=ll.idllamado ORDER BY ll.fecha ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $this->primero[] = $fila[0];
            }
        } else {
            $this->primero = null;
        }
    }
    
    public function fechasSegundoLlamado()
    {
        $consulta = "SELECT DISTINCT DATE_FORMAT(ll.fecha, '%d/%m/%Y') FROM mesa_examen me, llamado ll WHERE me.segundo=ll.idllamado ORDER BY ll.fecha ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $this->segundo[] = $fila[0];
            }
        } else {
            $this->segundo = null;
        }
    }
    
    public function obtenerHorarios()
    {
        $horarios = array();
        $consulta = "SELECT DISTINCT DATE_FORMAT(ll.hora, '%H:%i') FROM mesa_examen me, llamado ll WHERE me.primero=ll.idllamado OR me.segundo=ll.idllamado ORDER BY ll.hora ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $horarios[] = $fila[0];
            }
            return $horarios;
        } else {
            return null;
        }
    }
}