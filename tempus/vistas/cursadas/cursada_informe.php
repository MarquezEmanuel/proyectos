<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../lib/conf/Utilidades.php';
include_once '../../modelos/carreras/Carrera.php';
include_once '../../modelos/carreras/Carreras.php';

$carreras = new Carreras();
?>
<html>
<?php include_once '../estructura/encabezado.php';?>
<script type='text/javascript' src='../../js/mesa_modificar.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>INFORME HORARIOS DE CURSADA</h2>
<form action='../../Controladores/ManejadorCursada.php' id='formInformeCursada' name='formInformeCursada' method='post'>
    <fieldset>
    <legend>Información básica</legend>
    <?php
    echo "<label>Carrera:</label>
    <select id='selectCarrera' name='selectCarrera'>
    <option value='todas'>Todos las carreras</option>";
    foreach ($carreras->getCarreras() as $carrera) {
        echo "<option value='{$carrera->getCodigo()}'>{$carrera->getNombre()}</option>";
    }
    echo "</select>
    <label>Día:</label>
    <select id='selectDia' name='selectDia'>
    	<option value='todos'>Todos los días</option>
        <option value='1'>Lunes</option>
        <option value='2'>Martes</option>
        <option value='3'>Miercoles</option>
        <option value='4'>Jueves</option>
        <option value='5'>Viernes</option>
        <option value='6'>Sabado</option>
    </select>
    <br><label>Hora de inicio:</label>
    <select id='selectHoraInicio' name='selectHoraInicio'>
    <option value='todas'>Todas las horas</option>";
    for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
        echo "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>
        <option value='{$horainicio}:30'>{$horainicio}:30 hs</option>";
    }
    echo "</select>
    <label>Hora de fin:</label>
    <select id='selectHoraFin' name='selectHoraFin'>
    <option value='todas'>Todas las horas</option>";
    for ($horafin = 10; $horafin < 24; ++$horafin) {
        echo "<option value='{$horafin}:00'>{$horafin}:00 hs</option>
        <option value='{$horafin}:30'>{$horafin}:30 hs</option>";
    }
    echo "</select>";
    ?>  
    </fieldset>
    <input type='hidden' id='accion' name='accion' value='informe'>
    <input class='botonVerde' type='submit' id='btnInformeCursada' name='btnInformeCursada' value='Informe'>
    </form>
</div>
</article>
</section> 
<?php include_once '../estructura/pie.php'; ?>
</html>

