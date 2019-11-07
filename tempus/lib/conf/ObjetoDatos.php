<?php

require_once('ConfiguracionesBD.php');

/**
 * Esta clase extiende de mysqli. Tiene la logica necesaria para conectarse a 
 * la base de datos del sistema.
 *
 * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>
 *
 */
class ObjetoDatos extends mysqli {
    
    protected $datos;
    protected $consulta;
    public static $instancia;
    
    /**
     * Constructor de la clase. Crea una nueva conexion con la base de datos
     * usando la informacion de ConfiguracionesBD.
     * 
     * @see ConfiguracionesBD
     * */
    function __construct() 
    {
        parent::__construct(ConfiguracionesBD::BD_HOST, ConfiguracionesBD::BD_USUARIO, ConfiguracionesBD:: BD_CLAVE, ConfiguracionesBD::BD_SCHEMA);
        if ($this->connect_error) {
            throw new Exception($this->connect_error, $this->connect_errno);
        }
    }
    
    /**
     * Devuelve la consulta.
     * */
    function getQuery() 
    {
        return $this->consulta;
    }
    
    /**
     * Modifica la consulta.
     * */
    function setQuery($query) 
    {
        $this->consulta = $query;
    }
    
    /**
     * Devuelve los datos.
     * @return mysqli_result
     */
    static function getDatos() {
        return $this->datos;
    }
    
    /**
     * Ejecuta una consulta en la base de datos y se asigna al atributo de clase datos.
     * @param mysqli_result $consulta_ Consulta SQL que se desea realizar. 
     * */
    function setDatos($consulta_ = null) 
    {
        $this->datos = $this->query(isset($consulta_) ? $consulta_ : $this->consulta);
    }
    
    /**
     * Ejecuta una consulta en la base de datos y devuelve el resultado.
     * @param string $consulta_
     * @return mysqli_result
     */
    function ejecutarQuery($consulta_ = null) 
    {
        return $this->query(isset($consulta_) ? $consulta_ : $this->consulta);
    }
    
    /**
     * Devuelve la instancia de la conexion a la base de datos.
     * @return ObjetoDatos
     */
    public static function getInstancia() 
    {
        if (!self::$instancia instanceof self) {
            try {
                self::$instancia = new self;
            } catch (Exception $e) {
                die("Error de conexión a la base de datos: " . $e->getCode() . ".");
            }
        }
        return self::$instancia;
    }
    
}