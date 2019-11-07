<?php
require_once '../modelos/cursadas/Cursada.php';
require_once '../modelos/cursadas/Clase.php';
require_once '../modelos/carreras/Plan.php';

require_once '../modelos/aulas/Aula.php';

    echo "<H1>TEST_CURSADA</H1>";
    
    $plan = new Plan();
    $plan->buscar(56, 72);
    
    $aula1 = new Aula();
    $aula1->setIdaula(5);
    
    $aula2 = new Aula();
    $aula2->setIdaula(4);
    
    $clase1 = new Clase();
    $clase1->setDia(1);
    $clase1->setDesde("20:00");
    $clase1->setHasta("23:00");
    $clase1->setAula($aula1);
    
    $clase2 = new Clase();
    $clase2->setDia(2);
    $clase2->setDesde("16:00");
    $clase2->setHasta("18:00");
    $clase2->setAula($aula2);
    
    $clase3 = new Clase();
    $clase3->setDia(3);
    $clase3->setDesde("18:00");
    $clase3->setHasta("21:00");
    $clase3->setAula($aula1);
    
    
    $cursadas = array ($clase1, $clase2, $clase3);
    
    $cursada = new Cursada();
    
    $cursada->crear($plan, $cursadas);
    
    echo "<H2>CREAR CURSADA</H2>";
    
    $resultado = $cursada->getClases();
    
    foreach ($resultado as $valor) {
        echo "Valor:". $valor->getDia(). "<br />\n";
    }
    