<?php
require_once '../modelos/mesas/MesaExamen.php';
require_once '../modelos/mesas/Tribunal.php';
require_once '../modelos/carreras/Plan.php';

    echo "<H1>TEST_MESAS</H1>";
    
    $plan = new Plan(1,16);
    
    $mesa = new MesaExamen();
    
    $mesa->buscar($plan);
    echo "<br><br> buscar 1, 16";
    echo "<br> id = ".$mesa->getIdmesa();
    echo "<br> asignatura = ".$plan->getAsignatura()->getNombre();
    echo "<br> carrera = ".$plan->getCarrera()->getNombre();
    echo "<br> presidente = ".$mesa->getTribunal()->getPresidente()->getNombre();
    echo "<br> vocal1 = ".$mesa->getTribunal()->getVocal1()->getNombre();
    echo "<br> vocal2 = ".$mesa->getTribunal()->getVocal2()->getNombre();
    echo "<br> suplente = ".$mesa->getTribunal()->getSuplente()->getNombre();
    
    echo "<br> fecha = ".$mesa->getPrimero()->getFecha();
    echo "<br> hora = ".$mesa->getPrimero()->getHora();
    echo "<br> llamado = ".$mesa->getPrimero();
    
    if ($mesa->getAula()) {
        echo "<br> nombre = ".$mesa->getAula()->getNombre();
        echo "<br> sector = ".$mesa->getAula()->getNombre();
    }
    echo "<br> fecha = ".$mesa->getFecha();
    echo "<br> hora = ".$mesa->getHora();
    echo "<br> llamado = ".$mesa->getLlamado();
    
    
    $mesa->buscar($plan, 2);
    echo "<br><br> buscar 1, 16, 1";
    if ($mesa->getIdmesa()) {
        
        echo "<br> id = ".$mesa->getIdmesa();
        echo "<br> asignatura = ".$plan->getAsignatura()->getNombre();
        echo "<br> carrera = ".$plan->getCarrera()->getNombre();
        echo "<br> presidente = ".$mesa->getTribunal()->getPresidente()->getNombre();
        echo "<br> vocal1 = ".$mesa->getTribunal()->getVocal1()->getNombre();
        echo "<br> vocal2 = ".$mesa->getTribunal()->getVocal2()->getNombre();
        echo "<br> suplente = ".$mesa->getTribunal()->getSuplente()->getNombre();
        if ($mesa->getAula()) {
            echo "<br> nombre = ".$mesa->getAula()->getNombre();
            echo "<br> sector = ".$mesa->getAula()->getNombre();
        }
        echo "<br> fecha = ".$mesa->getFecha();
        echo "<br> hora = ".$mesa->getHora();
        echo "<br> llamado = ".$mesa->getLlamado();
    } else {
        echo "<br> No se ha encontrado mesa de examen para:";
        echo "<br> Asignatura: ".$plan->getAsignatura()->getNombre();
        echo "<br> Carrera: ".$plan->getCarrera()->getNombre();
        echo "<br> llamado = 2";
    }   
    
    $tribunal = new Tribunal(2);
    $mesa->crear($plan,$tribunal,null,"2017-11-05","16:00",2);
    echo "<br><br> crear 1, 16, 2";
    if ($mesa->getIdmesa()) {
        
        echo "<br> id = ".$mesa->getIdmesa();
        echo "<br> asignatura = ".$plan->getAsignatura()->getNombre();
        echo "<br> carrera = ".$plan->getCarrera()->getNombre();
        echo "<br> presidente = ".$mesa->getTribunal()->getPresidente()->getNombre();
        echo "<br> vocal1 = ".$mesa->getTribunal()->getVocal1()->getNombre();
        echo "<br> vocal2 = ".$mesa->getTribunal()->getVocal2()->getNombre();
        echo "<br> suplente = ".$mesa->getTribunal()->getSuplente()->getNombre();
        if ($mesa->getAula()) {
            echo "<br> nombre = ".$mesa->getAula()->getNombre();
            echo "<br> sector = ".$mesa->getAula()->getNombre();
        }
        echo "<br> fecha = ".$mesa->getFecha();
        echo "<br> hora = ".$mesa->getHora();
        echo "<br> llamado = ".$mesa->getLlamado();
    } else {
        echo "<br> No se ha creado mesa de examen para:";
        echo "<br> Asignatura: ".$plan->getAsignatura()->getNombre();
        echo "<br> Carrera: ".$plan->getCarrera()->getNombre();
        echo "<br> llamado = 2";
    }