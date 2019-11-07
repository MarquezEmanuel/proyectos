<?php

require_once '../lib/conf/ObjetoDatos.php';
require_once '../lib/conf/Utilidades.php';
require_once '../modelos/carreras/Plan.php';
require_once '../modelos/cursadas/Clase.php';
require_once '../modelos/cursadas/Cursada.php';
require_once '../modelos/cursadas/Cursadas.php';
require_once '../modelos/aulas/Aula.php';

$cursadas = new Cursadas();



$cursadas->informe("todas", "todos", "todas", "todas");
echo "<br><br><br>*************Resultado: ".count($cursadas->getCursadas())." cursadas<br>";
foreach ($cursadas->getCursadas() as $cursada) {
    $plan = $cursada->getPlan();
    echo "<br><br>".$plan->getCarrera()->getNombre().": ".$plan->getAsignatura()->getNombre();
    $clases = $cursada->getClases();
    
    for ($i=1; $i<7; $i++) {
        if (isset($clases[$i])) {
            $aula = $clases[$i]->getAula();
            $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
            echo "<br>|   _ {$i}: ".$dia;
        }
    }
}


$cursadas->informe(16, "todos", "todas", "todas");
echo "<br><br><br>*************Resultado: ".count($cursadas->getCursadas())." cursadas<br>";
foreach ($cursadas->getCursadas() as $cursada) {
    $plan = $cursada->getPlan();
    echo "<br><br><br>".$plan->getCarrera()->getNombre().": ".$plan->getAsignatura()->getNombre();
    $clases = $cursada->getClases();
    
    for ($i=1; $i<7; $i++) {
        if (isset($clases[$i])) {
            $aula = $clases[$i]->getAula();
            $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
            echo "<br>|** {$i}: ".$dia;
        }
    }
}

$cursadas->informe(16, 1, "todas", "todas");
echo "<br><br><br>*************Resultado: ".count($cursadas->getCursadas())." cursadas<br>";
foreach ($cursadas->getCursadas() as $cursada) {
    $plan = $cursada->getPlan();
    echo "<br><br><br>".$plan->getCarrera()->getNombre().": ".$plan->getAsignatura()->getNombre();
    $clases = $cursada->getClases();
    for ($i=1; $i<7; $i++) {
        if (isset($clases[$i])) {
            $aula = $clases[$i]->getAula();
            $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
            echo "<br>|** {$i}: ".$dia;
        }
    }
}

$cursadas->informe(16, 1, "18:00", "todas");
echo "<br><br><br>*************Resultado: ".count($cursadas->getCursadas())." cursadas<br>";
foreach ($cursadas->getCursadas() as $cursada) {
    $plan = $cursada->getPlan();
    echo "<br><br><br>".$plan->getCarrera()->getNombre().": ".$plan->getAsignatura()->getNombre();
    $clases = $cursada->getClases();
    for ($i=1; $i<7; $i++) {
        if (isset($clases[$i])) {
            $aula = $clases[$i]->getAula();
            $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
            echo "<br>|** {$i}: ".$dia;
        }
    }
}

$cursadas->informe(16, 1, "18:00", "21:00");
echo "<br><br><br>*************Resultado: ".count($cursadas->getCursadas())." cursadas<br>";
foreach ($cursadas->getCursadas() as $cursada) {
    $plan = $cursada->getPlan();
    echo "<br><br><br>".$plan->getCarrera()->getNombre().": ".$plan->getAsignatura()->getNombre();
    $clases = $cursada->getClases();
    for ($i=1; $i<7; $i++) {
        if (isset($clases[$i])) {
            $aula = $clases[$i]->getAula();
            $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
            echo "<br>|** {$i}: ".$dia;
        }
    }
}