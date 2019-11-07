<?php

/**
 * Esta clase sirve para trabajar sobre un conjunto de mesas de examen. Con ella
 * se puede realizar la creación, búsqueda y eliminacion de mesas de examen. 
 * Fecha de creación = 28/10/2017.
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @authos Marquez Emanuel.Fecha de creación = 28/10/2017.
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @authos Marquez Emanuel.
 * */
class Mesas 
{
    /** @var MesaExamen[] */
    private $mesas;
    
    /** @var mysqli_result */
    private $datos;
    
    /**
     * Constructor de clase.
     * */
    function _construct()
    {
        $this->mesas = array();
    }
    
    /**
     * @return MesaExamen[] $mesas
     */
    public function getMesas()
    {
        return $this->mesas;
    }

    /**
     * @param MesaExamen[] $mesas
     */
    public function setMesas($mesas)
    {
        $this->mesas = $mesas;
    }

    /**
     * Agrega una mesa de examen al arreglo.
     * @param MesaExamen $mesa
     * */
    public function agregarMesa($mesa) 
    {
        $this->mesas[] = $mesa;   
    }
    
    /**
     * Realiza la creación de un conjunto de mesas de examen. Antes de hacer la
     * operacion verifica que se haya definido el array que se recibe. Luego, 
     * hace la eliminación de los registros actuales. Cuando el borrado de los 
     * registros es correcta procede a la creacion de cada uno de los elementos
     * del array. El resultado de este método se devuelve en un array.
     * @param array $mesas Recibe las filas del archivo a cargar.
     * @return array Contiene el resultado, mensaje y datos.
     * */
    public function crear($mesas) 
    {
        /* Indica un mensaje a mostrar */
        $mensaje = "";
        /* Indica si se ha realizado la creacion o fallo */
        $creacion = true;
        /* Contiene las mesas que no se han cargado durante la creacion */
        $datos = null;
        
        if (isset($mesas)) {
            if ($this->borrar()) {
                /* Se han borrado todos los registros existentes */
                $tamanio = count($mesas);
                $columnas = count($mesas[0]);
                $contadorexitos = 0;
                
                /* Crea los objetos que se van a utilizar */
                $carrera = new Carrera();
                $asignatura = new Asignatura();
                $plan = new Plan();
                $plan->setAsignatura($asignatura);
                $plan->setCarrera($carrera);
                $presidente = new Docente();
                $vocal1 = new Docente();
                $vocal2 = new Docente();
                $suplente = new Docente();
                $tribunal = new Tribunal();
                $mesa = new MesaExamen();
                $primero = new Llamado();
                
                if ($columnas == 10) {
                    /* Se debe hacer la creacion para dos llamados */
                    $segundo = new Llamado();
                    
                    for ($i=0; $i < $tamanio; ++$i) {
                        /* lee la primer fila */
                        $fila = $mesas[$i];
                        /* obtiene los datos de la fila */
                        $codigocarrera = $fila[0];
                        $nombrecarrera = $fila[1];
                        $nombreasignatura = $fila[2];
                        $nombrepresidente = $fila[3];
                        $nombrevocal1 = $fila[4];
                        $nombrevocal2 = $fila[5];
                        $nombresuplente = $fila[6];
                        $fechaprimero = $fila[7];
                        $fechasegundo = $fila[8];
                        $hora = $fila[9];
                        
                        /* Se verifica si la carrera ya se uso en la fila anterior */
                        if($codigocarrera != $carrera->getCodigo()) {
                            $carrera->crear($codigocarrera, $nombrecarrera);
                        }
                        /* Se verifica si la asignatura ya se uso en la fila anterior */
                        if ($nombreasignatura != $asignatura->getNombre()) {
                            $asignatura->crear($nombreasignatura);
                        }
                        
                        $plan->crear($asignatura->getIdasignatura(), $carrera->getCodigo(), 1);
                        $plan->setAsignatura($asignatura);
                        $plan->setCarrera($carrera);
                        
                        $presidente->crear($nombrepresidente);
                        $vocal1->crear($nombrevocal1);
                        
                        $vocal2->setIdDocente(null);
                        $vocal2->setNombre(null);
                        $suplente->setIdDocente(null);
                        $suplente->setNombre(null);
                        
                        if ($nombrevocal2) {
                            /* Solo si hay vocal1 se verifica que haya suplente */
                            $vocal2->crear($nombrevocal2);
                            if ($nombresuplente) {
                                $suplente->crear($nombresuplente);
                            }
                        }
                        
                        $tribunal->setPresidente($presidente);
                        $tribunal->setVocal1($vocal1);
                        $tribunal->setVocal2($vocal2);
                        $tribunal->setSuplente($suplente);
                        
                        $tribunal->crear($presidente->getIdDocente(), $vocal1->getIdDocente(), $vocal2->getIdDocente(), $suplente->getIdDocente());
                        
                        $primero->setFecha(null);
                        $primero->setHora(null);
                        if ($fechaprimero) {
                            $primero->setFecha($fechaprimero);
                            $primero->setHora($hora);
                            $primero->setAula(null);
                        }
                        
                        $segundo->setFecha(null);
                        $segundo->setHora(null);
                        if ($segundo) {
                            $segundo->setFecha($fechasegundo);
                            $segundo->setHora($hora);
                            $segundo->setAula(null);
                        }
                        
                        $mesa->crear($plan, $tribunal, $primero, $segundo);
                        
                        if ($mesa->getIdmesa()) {
                            /* Se ha creado correctamente la mesa de examen */
                            $contadorexitos = $contadorexitos + 1;
                        } else {
                            $datos [] = $fila;
                        }
                        $mesa->setIdmesa(null);
                    }
                    
                } else {
                    /* Se debe hacer la creacion para un solo llamado */
                    $segundo = null;
                    
                    for ($i=0; $i < $tamanio; ++$i) {
                        $fila = $mesas[$i];
                        $codigocarrera = $fila[0];
                        $nombrecarrera = $fila[1];
                        $nombreasignatura = $fila[2];
                        $nombrepresidente = $fila[3];
                        $nombrevocal1 = $fila[4];
                        $nombrevocal2 = $fila[5];
                        $nombresuplente = $fila[6];
                        $fechaprimero = $fila[7];
                        $hora = $fila[8];
                        
                        /* Se verifica si la carrera ya se uso en la fila anterior */
                        if($codigocarrera != $carrera->getCodigo()) {
                            $carrera->crear($codigocarrera, $nombrecarrera);
                        }
                        /* Se verifica si la asignatura ya se uso en la fila anterior */
                        if ($nombreasignatura != $asignatura->getNombre()) {
                            $asignatura->crear($nombreasignatura);
                        }
                        
                        $plan->crear($asignatura->getIdasignatura(), $carrera->getCodigo(), 1);
                        $plan->setAsignatura($asignatura);
                        $plan->setCarrera($carrera);
                        
                        $presidente->crear($nombrepresidente);
                        $vocal1->crear($nombrevocal1);
                        $vocal2->setIdDocente(null);
                        $vocal2->setNombre(null);
                        $suplente->setIdDocente(null);
                        $suplente->setNombre(null);
                        
                        if ($nombrevocal2) {
                            /* Solo si hay vocal1 se verifica que haya suplente */
                            $vocal2->crear($nombrevocal2);
                            if ($nombresuplente) {
                                $suplente->crear($nombresuplente);
                            }
                        }
                        
                        $tribunal->setPresidente($presidente);
                        $tribunal->setVocal1($vocal1);
                        $tribunal->setVocal2($vocal2);
                        $tribunal->setSuplente($suplente);
                        
                        $tribunal->crear($presidente->getIdDocente(), $vocal1->getIdDocente(), $vocal2->getIdDocente(), $suplente->getIdDocente());
                        
                        $primero->setFecha($fechaprimero);
                        $primero->setHora($hora);
                        $primero->setAula(null);
                        
                        $mesa->crear($plan, $tribunal, $primero, $segundo);
                        
                        if ($mesa->getIdmesa()) {
                            $contadorexitos = $contadorexitos + 1;
                        } else {
                            $datos [] = $fila;
                        }
                        
                        $mesa->setIdmesa(null);
                    }
                    /* Fin del for para un solo llamado */
                }
                /* Fin del else para un solo llamado */
                
                if ($contadorexitos > 0) {
                    $mensaje = "Se han creado ".$contadorexitos." mesas de examen sobre ".$tamanio." recibidas";
                    
                } else {
                    $mensaje = "No se han creado mesas de examen para un total de ".$tamanio." mesas recibidas";
                }
                
                
            } else {
                /* No se han borrado todos los registros existentes */
                $mensaje = 'No se ha podido realizar la eliminación de las mesas de examen actuales';
                $creacion = false;
            }
        } else {
            /* El parametro mesas no esta definido o es nulo (ISSET) */
            $mensaje = 'No se han recibido las mesas de examen a crear';
            $creacion = false;
        }
        
        $resultado = array('resultado'=>$creacion,'mensaje'=>$mensaje, 'datos'=>$datos);
        return $resultado;
    } 
    
    /**
     * Realiza la búsqueda de un conjunto de mesas de examen. Cuando se indica un nombre de
     * asignatura, se busca las mesas de dicha asignatura. En caso contrario, se realiza la
     * búsqueda de todas las mesas de examen cargadas en el sistema.
     * @param string $asignatura Nombre de la asignatura que se desea saber las mesas.
     * */
    public function buscar($asignatura = null)
    {
        $consulta = "SELECT me.idmesa, me.idasignatura, me.idcarrera, me.idtribunal, me.primero, me.segundo ";
        $consulta = $consulta."FROM mesa_examen me, asignatura a WHERE me.idasignatura=a.idasignatura ";            
        if ($asignatura) {
            $consulta = $consulta."AND a.nombre LIKE '%".$asignatura."%'";
        }
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        $tamanio =  $this->datos->num_rows;
        if($tamanio > 0) {
            $datos = array();
            while ($fila = mysqli_fetch_array($this->datos)) {
                $mesa = new MesaExamen();
                $mesa->setIdmesa($fila[0]);
                $plan = new Plan($fila[1], $fila[2]);
                $mesa->setPlan($plan);
                $tribunal = new Tribunal($fila[3]);
                $mesa->setTribunal($tribunal);
                $primero = new Llamado($fila[4]);
                $mesa->setPrimero($primero);
                if($fila[5]) {
                    $segundo = new Llamado($fila[5]);
                    $mesa->setSegundo($segundo);
                } else {
                    $mesa->setSegundo(null);
                }
                $datos[] = $mesa;
            }
            $mensaje = "Se han encontrado resultados para la búsqueda";
            return array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>$datos);
            
        } else {
            $mensaje = "No se han encontrado resultados para el campo ingresado";
            if ($asignatura) {
                $mensaje = $mensaje." (".$asignatura.") ";
            }
            return array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
    }
    
    /**
     * Realiza la eliminacion de todas las mesas de examen cargadas en la base 
     * de datos. Para ello se realiza la eliminación de los registros de la tabla
     * mesa de examen, llamado, tribunal y docente.
     * @author Marquez Emanuel.
     * */
    public function borrar()
    {
        ObjetoDatos::getInstancia()->autocommit(false);
        ObjetoDatos::getInstancia()->begin_transaction();
        try {
            
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM mesa_examen WHERE 1");
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM llamado WHERE 1");
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM tribunal WHERE 1");
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM docente WHERE 1");
            
        } catch (Exception $exception) {
            return false;
        }
        ObjetoDatos::getInstancia()->commit();
        ObjetoDatos::getInstancia()->autocommit(true);
        return true;
    }
    
    /**
     * Realiza la cuenta de la cantidad de mesas de examen que tienen segundo llamado.
     * Cuando el conteo es cero significa que no hay mesas con dos llamados, por lo
     * tanto la cantidad de llamados para el turno será uno.
     * @return integer Cero si tiene un llamado, entero mayor a cero en caso contrario.
     * */
    public function cantidadLlamados()
    {
        $consulta = "SELECT COUNT(idmesa) FROM mesa_examen WHERE segundo IS NOT NULL";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows) {
            $fila = mysqli_fetch_array($this->datos);
            return $fila[0];
        }
        return 0;
    }
   
    /**
     * @param string $fecha Fecha de las mesas a consultar.
     * @param string $hora Hora de las mesas a consultar.
     * @param string $sector Sector de las mesas a consultar.
     * @param boolean $modificada Mesa que ha sido modificada.
     * */
    public function informe($fecha, $hora, $sector, $modificada)
    {
        $this->mesas = null;
        $consulta = "SELECT * FROM mesa_examen WHERE 1";
        if($fecha != "todas" || $hora != "todas" || $sector!= "todos" || $modificada) {
            $consulta = "SELECT * FROM mesa_examen m, llamado l ";
            $confecha = $conhora = $conmod = "";
            if($fecha != "todas") {
                $confecha = "AND l.fecha='{$fecha}' ";
            }
            if($hora != "todas") {
                $conhora = "AND l.hora='{$hora}' ";
            }
            if($modificada) {
                $conmod = "AND l.fechamod IS NOT NULL ";
            }
            if($sector != "todos") {
                $consulta = $consulta.", aula a WHERE (m.primero=l.idllamado OR m.segundo=l.idllamado) AND l.idaula=a.idaula AND a.sector='{$sector}' ";
                
            } else {
                $consulta =$consulta."WHERE (m.primero=l.idllamado OR m.segundo=l.idllamado) ";
            }
            $consulta = $consulta.$confecha.$conhora.$conmod;
        }
        echo "<br>".$consulta;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if($this->datos->num_rows > 0) {
            $this->mesas = array();
            while ($fila = mysqli_fetch_array($this->datos)) {
                $mesa = new MesaExamen();
                $plan = new Plan($fila[1], $fila[2]);
                $tribunal = new Tribunal($fila[3]);
                $primero = $segundo = null;
                if($fila[4]) {
                    $primero = new Llamado($fila[4]);
                }
                if($fila[5]) {
                    $segundo = new Llamado($fila[5]);
                }
                $mesa->cargar($fila[0], $plan, $tribunal, $primero, $segundo);
                $this->mesas[] = $mesa;
            }   
        }
    }
    
    /**
     * Se obtienen las mesas del dia y que no tengan asignada un aula.
     * */
    public function obtenerMesasDeHoy() 
    {
        $this->mesas = null;
        $consulta = "SELECT m.idmesa, m.idasignatura, m.idcarrera, m.idtribunal, m.primero, m.segundo 
                     FROM mesa_examen m, llamado l 
                     WHERE (m.primero=l.idllamado OR m.segundo=l.idllamado) AND l.idaula IS NULL AND l.fecha=CURDATE()";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $this->mesas = array();
            $tamanio = $this->datos->num_rows;
            for ($i = 0; $i < $tamanio; $i++) {
                $mesa = new MesaExamen();
                $fila = $this->datos->fetch_row();
                $plan = new Plan($fila[1], $fila[2]);
                $tribunal = new Tribunal($fila[3]);
                $primero = $segundo = null;
                if($fila[4]) {
                    $primero = new Llamado($fila[4]);
                }
                if($fila[5]) {
                    $segundo = new Llamado($fila[5]);
                }
                $mesa->cargar($fila[0], $plan, $tribunal, $primero, $segundo);
                $this->mesas[] = $mesa;
            }
        }
    }
}
