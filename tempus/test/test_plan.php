<?php
require_once '../modelos/carreras/Plan.php';

    echo "<H1>TEST_PLAN</H1>";
    
    $plan = new Plan();
   
    
    $plan->crear(1, 16, 3);
    echo "<br><br> crear 1, 16, 3";
    echo "<br> año = ".$plan->getAnio();
    
    $plan->buscar(1, 72);
    echo "<br><br> buscar 1, 72";
    if($plan->getAsignatura()) {
        echo "<br> asignatura = ".$plan->getAsignatura()->getNombre();
        echo "<br> carrera = ".$plan->getCarrera()->getNombre();
        echo "<br> año = ".$plan->getAnio();
    }
    
    $plan->buscar(1, 16);
    echo "<br><br> buscar 1, 16";
    if($plan->getAsignatura()) {
        echo "<br> asignatura = ".$plan->getAsignatura()->getNombre();
        echo "<br> carrera = ".$plan->getCarrera()->getNombre();
        echo "<br> año = ".$plan->getAnio();
    }