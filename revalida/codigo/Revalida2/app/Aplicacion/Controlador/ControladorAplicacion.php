<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorAplicacion {

    private $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public function getMensaje() {
        return $this->mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de aplicativos a taves del nombre, gerencia
     * propietaria, delegado de gerencia o subdelegado.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @param string $gerencia Nombre (o parte del nombre) de la gerencia.
     * @param string $delegado Nombre (o parte del nombre) del delegado.
     * @param string $subdelegado Nombre (o parte del nombre) del subdelegado.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function buscar($nombre, $gerencia, $delegado, $subdelegado) {
        $resultado = Aplicaciones::buscar($nombre, $gerencia, $delegado, $subdelegado);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

    /**
     * Realiza la creacion del aplicativo en la base de datos. Se requiere del nombre
     * y de la gerencia propietaria de los datos para llevar a cabo la operacion.
     * @param string $nombre Nombre de la aplicacion.
     * @param integer $propietario Identificador de la gerencia propietaria de datos.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se creo o 2 para exito.
     */
    public function crear($nombre, $propietario) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $aplicacion = new Aplicacion(NULL, $nombre, $propietario);
            $creacion = $aplicacion->crear();
            $this->mensaje = $aplicacion->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("CREAR APLICACION", "[ControladorAplicacion] [Crear] [DAT: {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve el resultado de la busqueda de aplicaciones a partir de un estado. El
     * resultado se otorga ordenado por nombre.
     * @param string $estado Estado de los servicios.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listar($estado) {
        $resultado = Aplicaciones::listar($estado);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado con la cantidad de registros indicados.
     * @param integer $tope Tope de cantidad.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listarConTope($tope) {
        $resultado = Aplicaciones::listarConTope($tope);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

    /**
     * Realiza la modificacion del aplicativo en la base de datos. Se puede modificar
     * el nombre, gerencia propietaria y/o estado de un aplicativo referenciado a partir del id.
     * @param integer $id Identificador de la aplicacion.
     * @param string $nombre Nombre de la aplicacion.
     * @param integer $propietario Identificador del propietario de datos.
     * @param integer $estado Estado de la aplicacion.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se modifico o 2 para exito.
     */
    public function modificar($id, $nombre, $propietario, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $aplicacion = new Aplicacion($id, $nombre, $propietario, $estado);
            $creacion = $aplicacion->modificar();
            $this->mensaje = $aplicacion->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("MODIFICAR APLICACION", "[ControladorAplicacion] [Modificar] [DAT: {$id} {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve un listado de aplicaciones a partir de su nombre y nombre de la base
     * de datos.
     * @param string $nombre Nombre del aplicativo.
     * @param string $base Nombre de la base de datos o ARCHIVO.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function seleccionar($nombre, $base) {
        $resultado = Aplicaciones::seleccionar($nombre, $base);
        $this->mensaje = Aplicaciones::getMensaje();
        return $resultado;
    }

}
