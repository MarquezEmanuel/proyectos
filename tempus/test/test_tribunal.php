<?php
require_once '../modelos/mesas/Tribunal.php';

echo "<H1>TEST_TRIBUNAL</H1>";


    $tribunal = new Tribunal();
    
    $tribunal->buscar(8,4,5,2);
    echo "<H2>Busqueda</H2>";
    echo "buscar 8, 4, 5, 2";
    echo "<br> id = ".$tribunal->getIdtribunal();
    echo "<br> presidente = ".$tribunal->getPresidente()->getNombre();
    echo "<br> vocal1 = ".$tribunal->getVocal1()->getNombre();
    echo "<br> vocal2 = ".$tribunal->getVocal2()->getNombre();
    echo "<br> suplente = ".$tribunal->getSuplente()->getNombre();
    
    $tribunal->buscar(8,4,5);
    echo "<H2>Busqueda</H2>";
    echo "buscar 8, 4, 5";
    echo "<br> id = ".$tribunal->getIdtribunal();
    echo "<br> presidente = ".$tribunal->getPresidente()->getNombre();
    echo "<br> vocal1 = ".$tribunal->getVocal1()->getNombre();
    echo "<br> vocal2 = ".$tribunal->getVocal2()->getNombre();
    if($tribunal->getSuplente()) {
        echo "<br> suplente = ".$tribunal->getSuplente()->getNombre();
    }
    
    $tribunal->buscar(8,4);
    echo "<H2>Busqueda</H2>";
    echo "buscar 8, 4";
    echo "<br> id = ".$tribunal->getIdtribunal();
    echo "<br> presidente = ".$tribunal->getPresidente()->getNombre();
    echo "<br> vocal1 = ".$tribunal->getVocal1()->getNombre();
    if($tribunal->getVocal2()) {
        echo "<br> vocal2 = ".$tribunal->getVocal2()->getNombre();
    }
    if($tribunal->getSuplente()) {
        echo "<br> suplente = ".$tribunal->getSuplente()->getNombre();
    }
    
    
    $tribunal->crear(2, 8);
    echo "<H2>Crear</H2>";
    echo "crear 2, 8";
    echo "<br> id = ".$tribunal->getIdtribunal();
    
