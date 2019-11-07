<?php
require_once '../lib/conf/ObjetoDatos.php';
require_once '../modelos/carreras/Plan.php';
require_once '../modelos/mesas/Tribunal.php';
require_once '../modelos/mesas/Llamado.php';
require_once '../modelos/mesas/MesaExamen.php';
require_once '../modelos/mesas/Mesas.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');
$zonahoraria = date_default_timezone_get();

echo '<br>Zona horaria predeterminada: ' . $zonahoraria;
echo "<br>Hoy: ".date("d-m-Y");
echo "<br>".strftime("%A %d de %B de %Y");	

echo "<br> 22-Oct: ".date("N",strtotime("22/10/2018"))." -- ".date("N",strtotime("22-10-2018"));
echo "<br> 28-Oct: ".date("N",strtotime("28/10/2018"));
echo "<br> 29-Oct: ".date("N",strtotime("29-10-2018"));
echo "<br> 30-Oct: ".date("N",strtotime("30-10-2018"));
echo "<br> 31-Oct: ".date("N",strtotime("31-10-2018"));
echo "<br> 01-Nov: ".date("N",strtotime("01-11-2018"));
echo "<br> 02-Nov: ".date("N",strtotime("02-11-2018"));
echo "<br> 03-Nov: ".date("N",strtotime("03-11-2018"));
echo "<br> 04-Nov: ".date("N",strtotime("04-11-2018"));


$mesas = new Mesas();
$mesas->obtenerMesasDeHoy();

echo '<pre>'; print_r($mesas->getMesas()); echo '</pre>';
