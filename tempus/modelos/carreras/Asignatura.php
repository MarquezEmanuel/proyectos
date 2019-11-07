<?php

/**
 * Esta clase corresponde con la tabla Asignatura de la base de datos.
 * Contiene los metodos necesarios para crear, borrar, buscar o modificar una asignatura.
 * Se relaciona con la clase Plan. (Relacion entre asignaturas y carreras).
 * 
 * Fecha de creación: 19-10-2017.
 * 
 * @version 1.0
 *
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Asignatura 
{
    /** @var integer */
    private $idasignatura;
    
    /** @var string */
    private $nombre;
    
    /** @var mysqli_result */
    private $datos;
    
    /**
     * Constructor de la clase. Si se ingresa un identificador de asignatura, se
     * realiza la busqueda de su informacion en la base de datos. En caso contrario,
     * se crea la asignatura con sus atributos nulos.
     * @param integer $idasignatura Recibe el identificador de la asignatura.
     * @author Márquez Emanuel.
     * */
    function __construct($idasignatura = null)
    {
        if($idasignatura) {
            $consulta = "SELECT * FROM asignatura WHERE idasignatura=".$idasignatura;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                    $this->{$atributo} = $valor;
                }
            }
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve el identificador de asignatura.
     * @return integer $idasignatura
     */
    public function getIdasignatura()
    {
        return $this->idasignatura;
    }

    /**
     * Devuelve el nombre de asignatura.
     * @return string $nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Modifica el identificador de la asignatura.
     * @param integer $idasignatura
     */
    public function setIdasignatura($idasignatura)
    {
        $this->idasignatura = $idasignatura;
    }

    /**
     * Modifica el nombre de la asignatura.
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    /***/
    public function borrar($idasignatura)
    {
        
    }
    
    /**
     * Realiza la búsqueda de una asignatura en la base de datos a traves del nombre
     * de la misma. Si la asignatura se encuentra en la base de datos, se actualizan
     * el id y nombre. En caso contrario, los atributos serán nulos.
     * La búsqueda se realiza igualando el parámetro ingresado con el campo nombre de
     * la tabla asignatura de la base de datos. Por lo tanto, no se traen resultados
     * similares.
     * @param string $nombre Recibe el nombre de la asignatura a buscar.
     * */
    public function buscar($nombre)
    {
        $consulta = "SELECT * FROM asignatura WHERE nombre='".$nombre."'";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                $this->{$atributo} = $valor;
            }
        } else {
            $this->cargar(null, null);
        }
        $this->datos = null;
    }
    
    /**
     * Asigna los valores indicados a los atributos del objeto.
     * @param integer $idasignatura Identificador de la Asignatura.
     * @param string $nombre Nombre de la Asignatura.
     * */
    public function cargar($idasignatura, $nombre)
    {
        $this->idasignatura = $idasignatura;
        $this->nombre = $nombre;
    }
    
    /**
     * Realiza la creación de una nueva asignatura en la base de datos. Para ello,
     * primero se realiza la búsqueda de la misma para verificar que no exista ya.
     * En caso que la asignatura sea creada, se asigna un idasignatura. En caso
     * contrario, se obtiene la información de la asignatura existente.
     * @param string $nombre Recibe el nombre de la Asignatura a crear.
     * */
    public function crear($nombre)
    {
        $this->buscar($nombre);
        if (is_null($this->idasignatura)) {
            $nombre = Utilidades::convertirCamelCase($nombre);
            ObjetoDatos::getInstancia()->ejecutarQuery("INSERT INTO asignatura VALUES (null,'{$nombre}')");
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $idasignatura = (Int) ObjetoDatos::getInstancia()->insert_id;
                $this->cargar($idasignatura, $nombre);
            } else {
                $this->cargar(null, null);
            }
        }
    }
    
    /**
     * 
     * */
    public function modificar($idasignatura, $nombre)
    {
        $consulta = "UPDATE asignatura SET nombre='".$nombre."' WHERE idasignatura=".$idasignatura;
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            $this->cargar($idasignatura, $nombre);
        } else {
            $this->cargar(null, null);
        }
    }
}

?>