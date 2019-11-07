<?php

class UsuarioGoogle extends Usuario {
    
    private $googleid;
    private $imagen;
    
    /**
     * Constructor de la clase.
     * */
    function __construct($idusuario = null) 
    {    
        try {
            
            parent::__construct($idusuario);
            if ($this->getIdusuario()) {
                $consulta = "SELECT * FROM usuario_google WHERE idusuario = ".$idusuario;
                $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
                $fila = $this->datos->fetch_row();
                $this->googleid = $fila[1];
                $this->imagen = $fila[2];
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /**
     * Devuelve el google id.
     * @return string $googleid
     */
    public function getGoogleid()
    {
        return $this->googleid;
    }

    /**
     * Devuelve la imagen del usuario google.
     * @return string $imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Modifica el google id del usuario.
     * @param String $googleid
     */
    public function setGoogleid($googleid)
    {
        $this->googleid = $googleid;
    }

    /**
     * Modifica la imagen del usuario.
     * @param String $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
    
    /**
     * Realiza la creación de un usuario google en la tabla usuario_google.
     * */
    public function crearUsuarioGoogle($idusuario, $googleid, $imagen)
    {
        $consulta = "INSERT INTO usuario_google VALUES ({$this->getIdusuario()},'{$googleid}','{$imagen}')";
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows) {
            $this->googleid = $googleid;
            $this->imagen = $imagen;
        } else {
            $this->googleid = null;
            $this->imagen = null;
        }
    }
    
    /**
     * Realiza la búsqueda de un usuario google a traves de su correo electronico.
     * Para ello primero realiza la busqueda del usuario que utiliza el metodo de
     * login Google. 
     * @param string $email Correo electronico del usuario (Obligatorio). 
     * */
    public function buscar($email, $metodo = self::METODO_GOOGLE) 
    {
        parent::buscar($email, $metodo);
        if ($this->getIdusuario()) {
            $consulta = "SELECT * FROM usuario_google WHERE idusuario = ".$this->getIdusuario();
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->googleid = $fila[1];
                $this->imagen = $fila[2];
            } else {
                $this->googleid = null;
                $this->imagen = null;
            }
        }
    }
    
    
    
}