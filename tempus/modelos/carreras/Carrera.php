<?php

/**
 * Esta clase corresponde con la tabla Carrera de la base de datos.
 * Contiene los metodos necesarios para crear, borrar, buscar o modificar una carrera.
 * Se relaciona con la clase Plan. (Relacion entre asignaturas y carreras).
 * 
 * Fecha de creación: 18-10-2017.
 * 
 * @version 1.0
 *
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Carrera 
{
    /** @var integer $codigo de carrera. */
    private $codigo;
    
    /** @var string $nombre de carrera. */
    private $nombre;
    
    /** @var mysqli_result $datos */
    private $datos;
    
    /**
     * Constructor de la clase. Si se ingresa un codigo de carrera, se obtiene la informacion de la
     * misma consultando la base de datos. En caso contrario, se crea la carrera con los atributos 
     * nulos.
     * @param integer $codigo Recibe el codigod de carrera.
     * */
    function __construct($codigo = null)
    {
        if($codigo) {
            $consulta = "SELECT * FROM carrera WHERE codigo=".$codigo;
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
     * Devuelve el codigo de la carrera.
     * @return integer $codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Deuvuelve el nombre de la carrera.
     * @return string $nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Modifica el codigo de la carrera.
     * @param integer $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Modifica el nombre de la carrera.
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $nombre = Utilidades::convertirCamelCase($nombre);
        $this->nombre = $nombre;
    }
    
    /**
     * Asigna los valores indicados por parametro a los atributos de clase.
     * @param integer $codigo Codigo de la carrera. 
     * @para string $nombre Nombre de la carrera. 
     * */
    public function cargar($codigo, $nombre)
    {
        $nombre = Utilidades::convertirCamelCase($nombre);
        $this->codigo = $codigo;
        $this->nombre = $nombre;
    }
    
    /**
     * Realiza la creacion de una nueva carrera en la base de datos. Para ello,
     * se hace una búsqueda para verificar que la carrera no exista. En caso que
     * la carrera exista, se obtienen sus datos. En caso contrario, se crea un
     * nuevo registro.
     * @param integer $codigo Codigo de la Carrera (Obligatorio).
     * @param string $nombre Nombre de la Carrera (Obligatorio).
     * */
    public function crear($codigo, $nombre)
    {
        $this->buscar($codigo, $nombre);
        if (!$this->codigo) {
            $nombre = Utilidades::convertirCamelCase($nombre);
            $consulta = "INSERT INTO carrera VALUES ({$codigo},'{$nombre}')";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $this->cargar($codigo, $nombre);
            } else {
                $this->cargar(null, null);
            }
        }
    }
    
    /**
     * Se borra al docente de la base de datos. En caso que se elimine correctamente,
     * el docente queda con los atributos nulos. Caso contrario, mantiene la informacion.
     * @return integer 
     * */
    public function borrar($codigo)
    {
        try {
            $consulta = "DELETE FROM carrera WHERE codigo = ".$codigo;
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $this->cargar(null, null);
            }
        } catch(Exception $exception) {
            return 0;
        }
        return 1;
    }
    
    /**
     * Busca a una carrera en la base de datos utilizando su nombre. Si la carrera
     * se encuentra cargada en la base de datos se actualizan los atributos codigo y
     * nombre. En caso contrario, los atributos serán nulos.
     * La búsqueda en la base de datos se realiza igualando los parametros dados con 
     * los campos de la tabla carrera. No se obtienen similares.
     * Se puede realizar la búsqueda combinando codigo y carrera. No se admite una
     * búsqueda para los dos campos nulos a la vez. Se puede usar la combinacion que
     * sigue codigo-null, null-nombre o codigo-nombre.
     * @param $codigo integer Recibe el codigo de la carrera (Opcional).
     * @param $nombre string Recibe el nombre de la carrera a buscar (Opcional).
     * */
    public function buscar($codigo = null, $nombre = null)
    {
        $consulta = "SELECT * FROM carrera WHERE ";
        if ($codigo) {
            $consulta = $consulta." codigo = ".$codigo. " ";
            if ($nombre) {
                $consulta = $consulta." AND nombre = '".$nombre."'";
            }
        } else {
            if ($nombre) {
                $consulta = $consulta." nombre = '".$nombre."'";
            }
        }
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
     * Modifica la informacion de la carrera.
     * @param integer $codigo Codigo de la carrera. 
     * @param integer $codigonuevo Codigo nuevo de la carrera.
     * @param string $nombre Nombre de la carrera.
     * */
    public function modificar($codigo, $codigonuevo, $nombre)
    {
        $nombre = Utilidades::convertirCamelCase($nombre);
        $consulta = "UPDATE carrera SET codigo=".$codigonuevo.", nombre='".$nombre."' WHERE codigo=".$codigo;
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            $this->cargar($codigonuevo, $nombre);
        } else {
            $this->cargar(null, null);
        }
    }

}
?>