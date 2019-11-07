<?php
require_once '../lib/conf/ObjetoDatos.php';
require_once '../lib/conf/Utilidades.php';
require_once '../modelos/carreras/Plan.php';
require_once '../modelos/aulas/Aula.php';
require_once '../modelos/mesas/Llamado.php';
require_once '../modelos/mesas/Tribunal.php';
require_once '../modelos/mesas/MesaExamen.php';
require_once '../modelos/mesas/Mesas.php';


$fecha = $_POST['selectFecha'];
$hora = $_POST['selectHora'];
$sector = $_POST['selectSector'];
$modificada = $_POST['selectModificada'];
$mesas = new Mesas();
$mesas->informe($fecha, $hora, $sector, $modificada);
$mensaje = "Fecha: {$fecha}, Hora: {$hora}, Sector: {$sector}, Modificada: si";
if(!$modificada) {
    $mensaje = "Fecha: {$fecha}, Hora: {$hora}, Sector: {$sector}, Modificada: no";
}

$mesas = new Mesas();