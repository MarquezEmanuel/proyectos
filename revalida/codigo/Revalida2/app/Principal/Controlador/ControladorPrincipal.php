<?php

class ControladorPrincipal{

    private $mensaje;

    public function getMensaje() {
        return $this->mensaje;
    }
    
    public function buscarEspApro($estado) {

        $resultado = PrincipalSolicitudes::buscar($estado);
        // $this->mensaje = PrincipalSolicitudes::getMensaje();
        return $resultado;
        
    }

}

?>