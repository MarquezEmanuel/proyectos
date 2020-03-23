<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorServicio {

    private $mensaje;

    /**
     * Retorna el mensaje asociado a la ultima operacion realizada.
     * @return string Mensaje de la operacion realizada.
     */
    public function getMensaje() {
        return $this->mensaje;
    }

    /**
     * Devuelve el resultado de la busqueda de servicios a taves del nombre.
     * @param string $nombre Nombre (o parte del nombre) a buscar.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function buscar($nombre) {
        $resultado = Servicios::buscar($nombre);
        $this->mensaje = Servicios::getMensaje();
        return $resultado;
    }

    /**
     * Realiza la creacion del servicio en la base de datos. Se requiere del nombre
     * para llevar a cabo la operacion.
     * @param string $nombre Nombre del servicio.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se creo o 2 para exito.
     */
    public function crear($nombre) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servicio = new Servicio(NULL, $nombre);
            $creacion = $servicio->crear();
            $this->mensaje = $servicio->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("CREAR SERVICIO", "[ControladorServicio] [Crear] [DAT: {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    /**
     * Devuelve el resultado de la busqueda de servicios a partir de un estado. El
     * resultado se otorga ordenado por nombre.
     * @param string $estado Estado de los servicios.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listar($estado) {
        $resultado = Servicios::listar($estado);
        $this->mensaje = Servicios::getMensaje();
        return $resultado;
    }

    /**
     * Devuelve un listado con la cantidad de registros indicados.
     * @param integer $tope Tope de cantidad.
     * @return resource Retorna el recurso, 0 para error, 1 cuando no hay resultados.
     */
    public function listarConTope($tope) {
        $resultado = Servicios::listarConTope($tope);
        $this->mensaje = Servicios::getMensaje();
        return $resultado;
    }

    /**
     * Realiza la modificacion del servicio en la base de datos. Se puede modificar
     * el nombre y/o estado de un servicio referenciado a partir del id.
     * @param integer $id Identificador del servicio.
     * @param string $nombre Nombre del servicio.
     * @param integer $estado Estado del servicio.
     * @return integer 0 cuando faltan datos o falla, 1 cuando no se modifico o 2 para exito.
     */
    public function modificar($id, $nombre, $estado) {
        if (SQLServer::instancia()->iniciarTransaccion()) {
            $servicio = new Servicio($id, $nombre, $estado);
            $creacion = $servicio->modificar();
            $this->mensaje = $servicio->getMensaje();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Log::guardarAccion("MODIFICAR SERVICIO", "[ControladorServicio] [Modificar] [DAT: {$id} {$nombre}] [RES: {$confirmar}]");
            SQLServer::instancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
