<?php
/**
 * Esta clase corresponde con la tabla Docente de la base de datos.
 * Contiene los metodos necesarios para crear, borrar, buscar o modificar un docente.
 * Se relaciona con la clase Tribunal. (Un tribunal posee docentes).
 * 
 * Fecha de creación: 18-10-2017.
 * 
 * @version 1.0
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Docente 
{
    /** @var integer $iddocente */
    private $iddocente;
    
    /** @var string $nombre */
    private $nombre;
    
    /** @var mysqli_result $datos */
    private $datos;
        
    /**
     * Constructor de la clase. Si se introduce el identificador del docente,
     * se obtiene su informacion desde la base de datos. En caso contrario, se
     * crea con los atributos nulos.
     * @param $iddocente Integer Recibe el identificador del docente.
     * */
    function __construct($iddocente = null)
    {
        if($iddocente) {
            $consulta = "SELECT * FROM docente WHERE iddocente = ".$iddocente." LIMIT 1";
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                /* Se ha encontrado un docente que cumple la condicion de busqueda */
                $fila = $this->datos->fetch_row();
                $this->iddocente = $fila[0];
                $this->nombre = $fila[1];
            }
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve el identificador del docente. 
     * */
    public function getIdDocente() 
    {
        return $this->iddocente;
    }
    
    /**
     * Devuelve el nombre del docente.
     * */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    /**
     * Modifica el identificador del docente.
     * */
    public function setIdDocente($iddocente)
    {
        $this->iddocente = $iddocente;
    }

    /**
     * Modifica el nombre del docente.
     * */
    public function setNombre($nombre)
    {
        $nombre = Utilidades::convertirCamelCase($nombre);
        $this->nombre = $nombre;
    }
    
    /**
     * Asigna los datos indicados por parametro a los atributos de clase.
     * @param integer $iddocente Identificador del docente.
     * @param string $nombre Nombre del docente.
     * */
    public function cargar($iddocente, $nombre)
    {
        $nombre = Utilidades::convertirCamelCase($nombre);
        $this->iddocente = $iddocente;
        $this->nombre = $nombre;
    }
    
    /**
     * Crea el nuevo docente en la base de datos. Se realiza la busqueda
     * del docente para verificar que no exista. Si no existe el docente
     * se crea un nuevo. En caso contrario, se obtiene la información del
     * docente existente.
     * */
    public function crear($nombre)
    {
        if ($nombre) {
            $this->buscar($nombre);
            if (is_null($this->iddocente)) {
                $nombre = Utilidades::convertirCamelCase($nombre);
                ObjetoDatos::getInstancia()->ejecutarQuery("INSERT INTO docente VALUES (null,'{$nombre}')");
                if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                    $iddocente = (Int) ObjetoDatos::getInstancia()->insert_id;
                    $this->cargar($iddocente, $nombre);
                }
            }
        }
    }
    
    /**
     * Se borra al docente de la base de datos. En caso que se elimine correctamente,
     * el docente queda con los atributos nulos. Caso contrario, mantiene la informacion.
     * @param integer $iddocente Identificador del docente a borrar (Obligatorio).
     * */
    public function borrar($iddocente)
    {
        if($iddocente) {
            $consulta = "DELETE FROM docente WHERE iddocente = ".$iddocente;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $this->cargar(null, null);
            }
        }
    }
    
    /**
     * Busca a un docente en la base de datos utilizando su nombre. Si el docente se encuentra 
     * cargado en la base de datos se actualizan los atributos id y nombre. En caso contrario, los
     * atributos serán nulos. La búsqueda en la base de datos se realiza igualando el parametro 
     * ingresado con el campo nombre de la tabla docente. No se obtienen similares.
     * @param $nombre String Recibe el nombre del docente a buscar.
     * */
    public function buscar($nombre)
    {
        $consulta = "SELECT * FROM docente WHERE nombre='{$nombre}' LIMIT 1";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $fila = $this->datos->fetch_row();
            $this->cargar($fila[0], $fila[1]);
        } else {
            $this->cargar(null, null);
        }
        $this->datos = null;
    }
    
}

?>