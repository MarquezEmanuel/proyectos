<?php
require_once '../modelos/aulas/Aula.php';

    echo "<H1>TEST_AULA</H1>";
    
    $aula = new Aula();
    
    $aula->crear("Laboratorio A4", "A");
    echo "<br><br> crear Laboratorio A4 - A";
    echo "<br> id = ".$aula->getIdaula();
    echo "<br> nombre = ".$aula->getNombre();
    echo "<br> sector = ".$aula->getSector();
    
    $aula->crear("Laboratorio A5", "A");
    echo "<br><br> crear Laboratorio A5 - A";
    echo "<br> id = ".$aula->getIdaula();
    echo "<br> nombre = ".$aula->getNombre();
    echo "<br> sector = ".$aula->getSector();
    
    $aula->buscar("Laboratorio A4", "A");
    echo "<br><br> buscar Laboratorio A4 - A";
    echo "<br> id = ".$aula->getIdaula();
    echo "<br> nombre = ".$aula->getNombre();
    echo "<br> sector = ".$aula->getSector();
    
    $aula->buscar("Laboratorio A5", "B");
    echo "<br><br> buscar Laboratorio A5 - B";
    echo "<br> id = ".$aula->getIdaula();
    echo "<br> nombre = ".$aula->getNombre();
    echo "<br> sector = ".$aula->getSector();
    
    