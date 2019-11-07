<?php
    header('Content-Type: text/html; charset=ISO-8859-1'); 
    require_once '../modelos/mesas/Mesas.php';
    
    echo "<H1>TEST BUSQUEDA DE MESAS DE EXAMEN</H1>";
    
    $mesas = new Mesas();
    
    echo "<H2> Buscar sin asignatura </H2>";
    $resultado = $mesas->buscar();
    echo "<br>". $resultado['resultado'];
    echo "<br>". $resultado['mensaje'];
    echo "<h3>Resultados:</h3>";
    foreach ($resultado['datos'] as $mesa) {
        echo "<br> Codigo: ". $mesa->getIdmesa();
        echo "<br> Asignatura: ". $mesa->getPlan()->getAsignatura()->getNombre();
        echo "<br> Carrera: ". $mesa->getPlan()->getCarrera()->getNombre();
        echo "<br> Presidente: ". $mesa->getTribunal()->getPresidente()->getNombre();
        echo "<br> Vocal1: ". $mesa->getTribunal()->getVocal1()->getNombre();
        if ($mesa->getTribunal()->getVocal2()) {
            echo "<br> Vocal2: ". $mesa->getTribunal()->getVocal2()->getNombre();
            if ($mesa->getTribunal()->getSuplente()) {
                echo "<br> Suplente: ". $mesa->getTribunal()->getSuplente()->getNombre();
            }
        }
        echo "<br> PRIMER LLAMADO:";
        echo "<br> Fecha: ". $mesa->getPrimero()->getFecha();
        echo "<br> Hora: ". $mesa->getPrimero()->getHora();
        if ($mesa->getSegundo()) {
            echo "<br> SEGUNDO LLAMADO:";
            echo "<br> Fecha: ". $mesa->getSegundo()->getFecha();
            echo "<br> Hora: ". $mesa->getSegundo()->getHora();
        }
        echo "<br>";
    }
    
    echo "<H2> Buscar 'Análisis' </H2>";
    $resultado = $mesas->buscar("Análisis");
    
    echo "<br>". $resultado['resultado'];
    echo "<br>". $resultado['mensaje'];
    echo "<h3>Resultados:</h3>";
    foreach ($resultado['datos'] as $mesa) {
        echo "<br> Codigo: ". $mesa->getIdmesa();
        echo "<br> Asignatura: ". $mesa->getPlan()->getAsignatura()->getNombre();
        echo "<br> Carrera: ". $mesa->getPlan()->getCarrera()->getNombre();
        echo "<br> Presidente: ". $mesa->getTribunal()->getPresidente()->getNombre();
        echo "<br> Vocal1: ". $mesa->getTribunal()->getVocal1()->getNombre();
        if ($mesa->getTribunal()->getVocal2()) {
            echo "<br> Vocal2: ". $mesa->getTribunal()->getVocal2()->getNombre();
            if ($mesa->getTribunal()->getSuplente()) {
                echo "<br> Suplente: ". $mesa->getTribunal()->getSuplente()->getNombre();
            }
        }
        echo "<br> PRIMER LLAMADO:";
        echo "<br> Fecha: ". $mesa->getPrimero()->getFecha();
        echo "<br> Hora: ". $mesa->getPrimero()->getHora();
        if ($mesa->getSegundo()) {
            echo "<br> SEGUNDO LLAMADO:";
            echo "<br> Fecha: ". $mesa->getSegundo()->getFecha();
            echo "<br> Hora: ". $mesa->getSegundo()->getHora();
        }
        echo "<br>";
    }
    
    
    echo "<H2> Buscar 'ges' </H2>";
    $resultado = $mesas->buscar("ges");
    echo "<br>". $resultado['resultado'];
    echo "<br>". $resultado['mensaje'];
    echo "<h3>Resultados:</h3>";
    foreach ($resultado['datos'] as $mesa) {
        echo "<br> Codigo: ". $mesa->getIdmesa();
        echo "<br> Asignatura: ". $mesa->getPlan()->getAsignatura()->getNombre();
        echo "<br> Carrera: ". $mesa->getPlan()->getCarrera()->getNombre();
        echo "<br> Presidente: ". $mesa->getTribunal()->getPresidente()->getNombre();
        echo "<br> Vocal1: ". $mesa->getTribunal()->getVocal1()->getNombre();
        if ($mesa->getTribunal()->getVocal2()) {
            echo "<br> Vocal2: ". $mesa->getTribunal()->getVocal2()->getNombre();
            if ($mesa->getTribunal()->getSuplente()) {
                echo "<br> Suplente: ". $mesa->getTribunal()->getSuplente()->getNombre();
            }
        }
        echo "<br> PRIMER LLAMADO:";
        echo "<br> Fecha: ". $mesa->getPrimero()->getFecha();
        echo "<br> Hora: ". $mesa->getPrimero()->getHora();
        
        if ($mesa->getSegundo()) {
            echo "<br> SEGUNDO LLAMADO:";
            echo "<br> Fecha: ". $mesa->getSegundo()->getFecha();
            echo "<br> Hora: ". $mesa->getSegundo()->getHora();
        }
        echo "<br>";
    }