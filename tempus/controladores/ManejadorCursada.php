<?php
include_once '../lib/conf/Constantes.php';
include_once '../lib/conf/ObjetoDatos.php';
include_once '../lib/conf/Utilidades.php';
include_once '../modelos/aulas/Aula.php';
include_once '../modelos/cursadas/Clase.php';
include_once '../modelos/cursadas/Cursada.php';
include_once '../modelos/cursadas/Cursadas.php';
include_once '../modelos/carreras/Plan.php';
    
session_start();
    
$redireccion = Constantes::HOMEURL;

$accion = $_POST['accion'];
  
switch ($accion) {
    case "importar":
        $redireccion = "/tempus/vistas/cursadas/cursada_resultado_importar.php";
        $filas = $_SESSION['cursadas'];
        $resultado = null;
        if ($filas) {
            $cursadas = new Cursadas();
            $resultado = $cursadas->crear($filas);
        } else {
            $mensaje = "No se pudo obtener la información a cargar";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
        $_SESSION['cursadas'] = NULL;
        $_SESSION['resultado'] = $resultado;
        break;
    case "crear":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_resultado_crear.php";
        $codigocarrera = $_POST['codigoCarrera'];
        $nombrecarrera = $_POST['txtCarrera'];
        $nombreasignatura = $_POST['txtAsignatura'];
        $anio = $_POST['selectAnio'];
        $clases = array();
        for ($i=1; $i<7; ++$i) {
            $dia = 'cbDiasClase'.$i;
            if (isset($_POST[$dia])) {
                $aula = new Aula();
                $nombresector = $_POST['txtSector'.$i];
                $nombreaula = $_POST['txtAula'.$i];
                $aula->crear($nombreaula, $nombresector);
                if ($aula->getIdaula()) {
                    $desde = $_POST['selectHoraInicio'.$i];
                    $hasta = $_POST['selectHoraFin'.$i];
                    $clase = new Clase();
                    $clase->cargar(null, $i, $desde, $hasta, $aula, null);
                    $clases [] = $clase;
                }
            }
        }
        $cursada = new Cursada();
        $cursada->crearCursada($codigocarrera, $nombrecarrera, $nombreasignatura, $anio, $clases);
        if($cursada->getPlan() && $cursada->getClases()) {
            $mensaje = "Se ha realizado la creación de la cursada correctamente";
            $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
        } else {
            if ($cursada->getPlan() && !$cursada->getClases()) {
                $mensaje = "No se ha realizado la creación de la cursada dado que ya existe";
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            } else {
                $mensaje = "No se pudo realizar la creación de la cursada. Intente nuevamente";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
            }
        }
        $_SESSION['resultado'] = $resultado;
        break;
    case "buscar":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_resultado_buscar.php";
        $cursadas = new Cursadas();
        $asignatura = $_POST['txtAsignatura'];
        $_SESSION['resultado'] = $cursadas->buscar($asignatura);
        break;
    case "borrar":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_borrar.php";
        if (isset($_SESSION['resultado']) && isset($_SESSION['resultado']['datos'])) {
            $resultado = $_SESSION['resultado'];
            
            $indice = $_POST['radioCursadas'];
            $cursadas = $resultado['datos'];
            $cursada = $cursadas[$indice];
            $idasignatura = $cursada->getPlan()->getAsignatura()->getIdasignatura();
            $idcarrera = $cursada->getPlan()->getCarrera()->getCodigo();
            $borrado = $cursada->borrar($idasignatura, $idcarrera);
            if($borrado) {
                $mensaje = "Se ha realizado la eliminación de la cursada correctamente";
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            } else {
                $mensaje = "No se ha realizado la eliminación de la cursada";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            }
        } else {
            $mensaje = "No se pudo obtener la información de la cursada seleccionada";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
        break;
    case "informe":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_resultado_informe.php";
        $carrera = $_POST['selectCarrera'];
        $dia = $_POST['selectDia'];
        $inicio = $_POST['selectHoraInicio'];
        $fin = $_POST['selectHoraFin'];
        $cursadas = new Cursadas();
        $cursadas->informe($carrera, $dia, $inicio, $fin);
        $filtro = array('carrera'=>$carrera,'dia'=>$dia,'inicio'=>$inicio,'fin'=>$fin);
        $_SESSION['cursadaInformeResultado'] =  array('filtro'=>$filtro, 'datos'=>$cursadas->getCursadas()) ;
        break;
    case "modificar":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if (isset($resultado)) {
            if (isset($resultado['datos'])) {
                $indice = $_POST['radioCursadas'];
                if (isset($indice)) {
                    $cursadas = $resultado['datos'];
                    $cursada = $cursadas[$indice];
                    $resultado = array('resultado'=>TRUE,'mensaje'=>NULL, 'datos'=>$cursada);
                } else {
                    $mensaje = "No se pudo obtener el indice del horario de cursada seleccionado";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                }
            } else {
                $mensaje = "No se pudo obtener la información de los horarios de cursadas que se han buscado";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
        } else {
            $mensaje = "No se pudo obtener la información del horario de cursada seleccionado";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
        $_SESSION['resultado'] = $resultado;
        break;
    case "modificarCursada":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if (isset($resultado) && isset($resultado['datos'])) {
            
            $cursada = $resultado['datos'];
            $codigocarrera = $_POST['numCarrera'];
            $nombrecarrera = $_POST['txtCarrera'];
            $nombreasignatura = $_POST['txtAsignatura'];
            $anio = $_POST['selAnio'];
            
            
            
        } else {
            $mensaje = "No se pudo obtener la información de la cursada a modificar";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
        
        $_SESSION['resultado'] = $resultado;
        break;
    case "crearclase":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if (isset($resultado) && isset($resultado['datos'])) {
            $cursada = $resultado['datos'];
            $dia = $_POST['radDias'];
            $horainicio = $_POST['selectHoraInicio'.$dia];
            $horafin = $_POST['selectHoraFin'.$dia];
            $sector = $_POST['txtSector'.$dia];
            $nombreaula = $_POST['txtAula'.$dia];
            $aula = new Aula();
            $aula->crear($nombreaula, $sector);
            if($aula->getIdaula()) {
                $idaula = $aula->getIdaula();
                if($aula->verificarDisponibilidadFranja($idaula, $dia,  $horainicio, $horafin)) {
                    $plan = $cursada->getPlan();
                    $clase = new Clase();
                    $clase->cargar(null, $dia, $horainicio, $horafin, $aula, null);
                    $idclase = $cursada->agregarClase($plan, $clase);
                    if($idclase) {
                        $clase->setIdclase($idclase);
                        $clases = $cursada->getClases();
                        $clases[$dia] = $clase;
                        $cursada->setClases($clases);
                        $mensaje = "Se ha realizado la creación de la clase correctamente";
                        if($aula->verificarDisponibilidad($idaula, $dia, $horainicio, $horafin)) {
                            $mensaje = $mensaje.". El aula es compartida con otra clase";
                        }
                    } else {
                        $mensaje = "No se ha podido realizar la creación de la clase";
                    }
                } else {
                    $mensaje = "No se ha podido realizar la creación de la clase. ";
                    $mensaje = $mensaje."El aula tiene una clase que comienza o finaliza en el horario indicado";
                }
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            } else {
                $mensaje = "No se ha podido realizar la creación de la clase";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            }
        } else {
            $mensaje = "No se pudo obtener la información de la clase seleccionada para crear";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
        $_SESSION['resultado'] = $resultado;
        break;
    case "modificarclase":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if(isset($resultado) && isset($resultado['datos'])) {
           
            $dia = $_POST['radDias'];
            $idclase = $_POST['idclase'.$dia];
            $horainicio = $_POST['selectHoraInicio'.$dia];
            $horafin = $_POST['selectHoraFin'.$dia];
            $sector = $_POST['txtSector'.$dia];
            $nombreaula = $_POST['txtAula'.$dia];
            
            $cursada = $resultado['datos'];
            $clases = $cursada->getClases();
            $clase = $clases[$dia];
            $aula = $clase->getAula();
            
            $modificaaula = true;
            if (($aula->getSector() != $sector) || ($aula->getNombre() != $nombreaula)) {
                $idaula = $aula->getIdaula();
                $sector = strtoupper($sector);
                $nombreaula = Utilidades::convertirCamelCase($nombreaula);
                $aula->modificar($idaula, $nombreaula, $sector);
                if (!$aula->getIdaula()) {
                    $modificaaula = false;
                }
            }
            $clase->modificar($idclase, $dia, $horainicio, $horafin, $aula);
            if ($modificaaula) {
                if ($clase->getIdclase()) {
                    $clases[$dia] = $clase;
                    $cursada->setClases($clases);
                    $mensaje = "Se ha realizado la modificación de la clase correctamente";
                    $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
                } else {
                    $mensaje = "No se ha podido realizar la modificación de la clase";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$cursada);
                }
            } else {
                $mensaje = "No se ha podido realizar la modificación del aula para la clase";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            }
        } else {
            $mensaje = "No se pudo obtener la información de la clase seleccionada para modificar";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
        }
        $_SESSION['resultado'] = $resultado;
        
        break;
    case "borrarclase":
        $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if(isset($resultado) && isset($resultado['datos'])) {
            $todas = $_POST['aplicarTodas'];
            $dia = $_POST['radDias'];
            $idclase = $_POST['idclase'.$dia];
            $cursada = $resultado['datos'];
            $clases = $cursada->getClases();
            $clase = $clases[$dia];
            $plan = $cursada->getPlan();
            $borrada = $cursada->quitarClase($plan, $clase, $todas);
            if ($borrada) {
                $clases[$dia] = null;
                $cursada->setClases($clases);
                $mensaje = "Se ha realizado la eliminación de la clase correctamente";
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            } else {
                $mensaje = "No se pudo realizar la eliminación de la clase";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            }
        } else {
            $mensaje = "No se pudo obtener la información de la clase seleccionada para borrar. Intente nuevamente";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
        }
        $_SESSION['resultado'] = $resultado;
        break;
}

header("Location: ".$redireccion);