<?php
require_once '../modelos/carreras/Asignatura.php';

    echo "<H1>TEST_ASIGNATURA</H1>";
    
    
    $asignatura = new Asignatura();
    
    $asignatura->crear("Gestión de Proyectos de Software");
    echo "<H2>Crear</H2>";
    echo "crear Gestión de Proyectos de Software";
    echo "<br> id = ".$asignatura->getIdasignatura();
    echo "<br> nombre = ".$asignatura->getNombre();
    
    $asignatura->crear("Laboratorio de Desarrollo de Software");
    echo "<br><br> crear Laboratorio de Desarrollo de Software";
    echo "<br> id = ".$asignatura->getIdasignatura();
    echo "<br> nombre = ".$asignatura->getNombre();
    
    
    $asignatura->buscar("gestion de proyectos de software");
    echo "<H2>Busqueda</H2>";
    echo "buscar gestion de proyectos de software";
    echo "<br> id = ".$asignatura->getIdasignatura();
    echo "<br> nombre = ".$asignatura->getNombre();
    
    