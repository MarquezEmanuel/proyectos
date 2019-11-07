<?php
require_once '../modelos/carreras/Carrera.php';

    echo "TEST_CARRERA<br>";
    
    
    $carrera = new Carrera();
    
    
    $carrera->crear(16, "Analista de Sistemas");
    echo "<br> <br>crear 16, Analista de Sistemas";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre();
    
    $carrera->buscar(null,"analista de sistemas");
    echo "<br> <br>buscar analista de sistemas";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre();
    
    /*
    $carrera->borrar(16);
    echo "<br> <br>borrar 16";
    echo "<br> carrera = ".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre(); 
    */
    
    $carrera->buscar(16,"analista de sistemas");
    echo "<br> <br>buscar analista de sistemas";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre(); 
    
    $carrera->buscar(72,null);
    echo "<br> <br>buscar 72, null";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre();
    
    $carrera->buscar(null,"Licenciatura en sistemas");
    echo "<br> <br>buscar null, Licenciatura en sistemas";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre();
    
    $carrera->buscar(72,"Licenciatura en sistemas");
    echo "<br> <br>buscar 72, Licenciatura en sistemas";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre();