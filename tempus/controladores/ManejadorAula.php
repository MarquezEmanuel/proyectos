<?php

include_once '../lib/conf/Constantes.php';
include_once '../lib/conf/ObjetoDatos.php';
include_once '../modelos/aulas/Aula.php';
include_once '../modelos/aulas/Aulas.php';

session_start();

$url = Constantes::APPURL."/vistas/aulas/";
$redireccion = Constantes::HOMEURL;
$accion = $_POST['accion'];

switch ($accion) {
    case "borrar":
        
        break;
    case "informe":
        $redireccion = $url."aula_informe.php";
        $idaula = $_POST['radioAulas'];
        if($idaula) {
            $aula = new Aula();
            $horarios = $aula->obtenerHorarios($idaula);
            if($horarios) {
                $resultado = array('resultado'=>TRUE,'mensaje'=>NULL,'datos'=>$horarios);
            } else {
                $mensaje = "No se obtuvieron horarios para realizar el informe del aula";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje,'datos'=>NULL);
            }
        } else {
            $mensaje = "No se pudo obtener la información necesaria para realizar el informe del aula";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje,'datos'=>NULL);
        }
        $_SESSION['aulaInformeResultado'] = $resultado;
        break;
    case "modificar":
        break;
}

header("Location: ".$redireccion);