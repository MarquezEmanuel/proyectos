<?php

class PrincipalSolicitudes{

    private $mensaje;

    public static function getMensaje() {
        return self::$mensaje;
    }


    public static function buscar($estado){
     
        $consulta = "SELECT * FROM [BD_Formulario].[dbo].[vw_formulario] WHERE estado LIKE ?";
        $datos= array('%'.$estado.'%');
        $resultado = SQLServer::instancia()->seleccionar($consulta,$datos);
        // self::$mensaje = SQLServer::instancia()->getMensaje();
        return $resultado;
    
    }


}

?>