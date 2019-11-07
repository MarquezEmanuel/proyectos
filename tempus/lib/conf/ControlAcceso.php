<?php
    
    include_once 'Constantes.php';
    include_once 'ObjetoDatos.php';
    include_once '../../modelos/usuarios/Usuario.php';
    include_once '../../modelos/usuarios/UsuarioGoogle.php';
    session_start();
    
    $control = new ControlAcceso();

/**
 * 
 *  $_SERVER["PHP_SELF"] = Obtiene la pagina desde donde se proviene.
 *  
 * */
class ControlAcceso {
    
    /** @var string $ubicacion */
    private $ubicacion;
    
    function __construct()
    {
       
        $this->ubicacion = Constantes::SERVER.$_SERVER["PHP_SELF"];
        
        if ($this->ubicacion != Constantes::HOMEURL) {
       
            unset($_SESSION["HTTP_REFERER"]);
            self::verificaLogin();
            
        } else {
            $_SESSION["HTTP_REFERER"] = Constantes::HOMEURL;
        }
        
        /* Condiciones que se evaluan:
         *    Que se haya declarado HTTP_REFERER.
         *    Que HTTP_REFERER sea igual al HOMEURL.
         *    Que se haya pasado por el index e ingresado con correo. 
         */
        if (isset($_SESSION["HTTP_REFERER"]) && ($_SESSION["HTTP_REFERER"] == Constantes::HOMEURL) && isset($_POST['email'])) {
            try {
                
                $email = $_POST['email'];
                $metodologin = Usuario::METODO_GOOGLE;
                $googleid =  $_POST['googleid'];
                $imagen = $_POST['imagen'];
                $nombre = $_POST['nombre'];
                
                $this->creaSesion($email, $metodologin, $googleid, $imagen, $nombre);
                
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        
        if ( ($this->ubicacion == Constantes::HOMEURL) && (isset($_SESSION['usuario'])) && (is_a($_SESSION['usuario'], 'Usuario')) ) {
            
            $this->redireccionaPaginaAutorizada();
        }
        
    }
    
    /**
     * Verifica si existe un usuario cargado en la sesion. En caso que no este
     * el usuario cargado en la sesion se lo redirecciona al index para que se
     * loguee.
     * */
    static function verificaLogin()
    {
        if (!isset($_SESSION['usuario']) || (!is_a($_SESSION['usuario'], "Usuario"))) {
            header("Location: " . Constantes::HOMEURL);
        }
        return null;
    }
    
    /**
     * Verifica si el usuario posee un permiso y en caso contrario lo redirecciona a la Home.
     *
     * @param String $permiso
     * @return void
     * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>.
     */
    static function requierePermiso($permiso) 
    {
        if (!self::verificaPermiso($permiso, $_SESSION['usuario'])) {
            header("Location: " . Constantes::HOMEURL);
        }
    }
    
    /**
     * Verifica si un usuario posee un permiso especifico. Si el usuario no esta 
     * cargado en la sesion devuelve falso. Luego, recorre los roles del usuario
     * y los permisos asociados. Si el permiso es encontrado, devuelve verdadero.
     * En caso contrario devuelve falso.
     * 
     * @static
     *
     * @param String $permiso
     * @return boolean true o false.
     * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>
     */
    static function verificaPermiso($permiso) 
    {
        $Usuario = $_SESSION['usuario'];
        if ($Usuario == null) {
            return false;
        }
        
        return $Usuario->poseePermiso($permiso);
        
    }
    
    /**
     * Hace la redireccion a la pagina autorizada.
     * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>.
     * @see Constantes
     * */
    function redireccionaPaginaAutorizada() 
    {    
        $this->ubicacion = Constantes::HOMEAUTH;
        header("Location: {$this->ubicacion}");
    }
    
    /**
     * Realiza la creación de una sesion para el usuario. Para ello primero hace la busqueda
     * del usuario en la base de datos. Si el usuario se encuentra cargado, crea el usuario
     * con su informacion y lo almacena en la sesion. Luego, lo redirecciona. 
     * En caso que no se encuentre en la base de datos lo redirecciona.
     * @param string $email 
     * @param string $metodo
     * @param string $googleid
     * @param string $imagen
     * @param string $nombre
     * 
     * @static
     *
     * @todo [15/06/2017] El método está pensado para instanciar usuarios Google. Se debe generalizar.
     * @since v. 2.0 2017-08-14 - El método deja de ser estático. Autoregistro desactivado.
     *
     * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>.
     *
     */
    function creaSesion($email, $metodo_ = Usuario::METODO_MANUAL, $googleid = null, $imagen = null, $nombre = null) {
        try {
            /* Crea un usuario y lo busca en la base de datos. */
            $Usuario = new UsuarioGoogle();
            $Usuario->buscar($email);
            
            if ($Usuario->getIdusuario()) {
                /* El usuario se encuentra en la base de datos. Se guarda en la sesion.  */
                $_SESSION['usuario'] = $Usuario;
                
                if (!$Usuario->getGoogleid()) {
                    $Usuario->crearUsuarioGoogle($Usuario->getIdusuario(), $googleid, $imagen);
                }
            } else {
                /* El usuario no se encuentra en la base de datos. */
                $_SESSION['usuario'] = null;
                $this->ubicacion = Constantes::APPURL."/vistas/estructura/sinacceso.php";
                header("Location: {$this->ubicacion}");
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }
    
}