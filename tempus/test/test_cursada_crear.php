<?php

require_once '../lib/conf/ObjetoDatos.php';
require_once '../lib/conf/Utilidades.php';
require_once '../modelos/cursadas/Cursada.php';
require_once '../modelos/cursadas/Clase.php';
require_once '../modelos/carreras/Carrera.php';
require_once '../modelos/carreras/Asignatura.php';
require_once '../modelos/carreras/Plan.php';
require_once '../modelos/aulas/Aula.php';


$codigocarrera = 16;
$nombrecarrera = "Analista De Sistemas";
$nombreasignatura = "Fundamentos De Ciencias De La Computacion";
$anio = 3;
$clases = array();
for ($i=1; $i<3; ++$i) {
    $aula = new Aula();
    $nombresector = "A";
    $nombreaula = "4";
    $aula->crear($nombreaula, $nombresector);
    if ($aula->getIdaula()) {
        $desde = "21:10";
        $hasta = "23:10";
        $clase = new Clase();
        $clase->cargar(null, $i, $desde, $hasta, $aula, null);
        $clases [] = $clase;
    }
}

$cursada = new Cursada();
$cursada->crearCursada($codigocarrera, $nombrecarrera, $nombreasignatura, $anio, $clases);
if($cursada->getPlan() && $cursada->getClases()) {
    echo "Se ha realizado la creación de la cursada correctamente";
} else {
    if ($cursada->getPlan() && !$cursada->getClases()) {
        echo "No se ha realizado la creación de la cursada dado que ya existe";
    } else {
        echo "No se pudo realizar la creación de la cursada. Intente nuevamente";
    }
}