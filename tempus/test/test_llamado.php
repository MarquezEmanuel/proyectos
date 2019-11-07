<?php
require_once '../lib/conf/ObjetoDatos.php';
require_once '../modelos/mesas/Llamado.php';
    echo "<H1>TEST_LLAMADO</H1>";
    
    
    $llamado = new Llamado();
    
    
    $llamado->crear("2017-10-10","16:00",NULL);
    
    echo "<br><br> crear 10-10, 16:00";
    echo "<br> id = ".$llamado->getIdllamado();
    echo "<br> fecha = ".$llamado->getFecha();
    echo "<br> hora = ".$llamado->getHora();