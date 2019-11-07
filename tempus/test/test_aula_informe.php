<?php
require_once '../lib/conf/ObjetoDatos.php';
require_once '../modelos/aulas/Aula.php';

echo "<H1>TEST_AULA</H1>";

$aula = new Aula();

$horarios = $aula->obtenerHorarios(7);

echo "<br>count horarios lunes: ".count($horarios[0]);
echo "<br>count horarios martes: ".count($horarios[1]);
echo "<br>count horarios miercoles: ".count($horarios[2]);
echo "<br>count horarios jueves: ".count($horarios[3]);
echo "<br>count horarios viernes: ".count($horarios[4]);

$mayor = 0;
for($i=1 ; $i<6; $i++) {
    if($horarios[$i])
        echo"<br> sii ".$i;
    $actual = count($horarios[$i]);
    if($actual > $mayor) {
        $mayor = $actual;
    }
}

echo "<br>Mayor: ".$mayor;


echo "<table border=1 >";
echo "<thead>";
    echo "<tr>";
    echo "<th>Lunes</th>";
    echo "<th>Martes</th>";
    echo "<th>Miercoles</th>";
    echo "<th>Jueves</th>";
    echo "<th>Viernes</th>";
    echo "</tr>";
echo "</thead>";
echo "<tbody>";
for($fila=0 ; $fila<$mayor; $fila++) {
    echo "<tr>";
    for($dia=1 ; $dia<6; $dia++) {
        
        if($horarios[$dia] && isset($horarios[$dia][$fila])) {
            echo "<td> {$horarios[$dia][$fila]['nombre']}  {$horarios[$dia][$fila]['inicio']} {$horarios[$dia][$fila]['fin']}</td>";
            
        } else {
            echo "<td> no </td>";
        }
        
    }
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

$aula2 = $horarios[0];
echo "<br>Aula:".$aula2->getIdAula()." ".$aula2->getNombre();

echo '<pre>'; print_r($horarios); echo '</pre>';