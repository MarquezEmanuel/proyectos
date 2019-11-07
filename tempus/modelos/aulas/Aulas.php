<?php
/**
 * 
 * */
class Aulas
{
    /** @var Aula[] $aulas */
    private $aulas;
    
    /** @var mysqli_result $datos */
    private $datos;
    
    /**
     * 
     * */
    function __construct()
    {
        $this->aulas = array();
        $consulta = "SELECT * FROM aula WHERE 1 ORDER BY sector ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $aula = new Aula();
                $aula->cargar($fila[0], $fila[1], $fila[2]);
                $this->aulas[] = $aula;
            }
        } else {
            $this->aulas[] = null;
        }
    }
    
    /**
     * @return multitype:Aula
     */
    public function getAulas()
    {
        return $this->aulas;
    }

    /**
     * @param multitype:Aula $aulas
     */
    public function setAulas($aulas)
    {
        $this->aulas = $aulas;
    }
    
    /**
     * 
     * */
    public function obtenerAulasDisponiblesClases($dia, $hora) {
        
        $this->aulas = array();
        $consulta = "SELECT * FROM aula WHERE `idaula` NOT IN ( SELECT idaula  FROM clase WHERE dia={$dia} 
                     AND ((desde>'{$hora}' AND desde<ADDTIME('{$hora}','3:00:00')) OR (hasta>'{$hora}' AND hasta<ADDTIME('{$hora}','3:00:00'))) ) 
                     ORDER BY `sector` ASC, `nombre` ASC";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $fila = $this->datos->fetch_row();
                $aula = new Aula();
                $aula->cargar($fila[0], $fila[1], $fila[2]);
                $this->aulas[] = $aula;
            }
        } else {
            $this->aulas[] = null;
        }
    }

    
    
}
