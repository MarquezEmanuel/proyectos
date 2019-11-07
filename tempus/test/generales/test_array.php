<?php

session_start();

$datos = array();
$datos[] = "uno";
$datos[] = "dos";
$datos[] = "tres";
$resultado = array('resultado'=>TRUE, 'mensaje'=> "HOLA",'datos'=>$datos);
$_SESSION['res'] = $resultado;


if($_SESSION['res']) {
    echo "<br>HAY RESULTADO SESSION['res']";
}

print_r($_SESSION);

if($_SESSION['res'] && $_SESSION['res']['datos']) {
    print_r($_SESSION['res']['datos']);
    echo "<br> HAY RESULTADO SESSION['res'] y datos";
}


if(isset($_SESSION['res2']) && $_SESSION['res2']['datos']){
    echo "<br> resultado dos ";
}

$_SESSION['res2'] = $resultado;

if(isset($_SESSION['res2']) && $_SESSION['res2']['datos']){
    echo "<br> hay resultado dos y datos";
}