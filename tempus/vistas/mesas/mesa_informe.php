<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../modelos/mesas/Llamados.php';
include_once '../../modelos/aulas/Aula.php';
include_once '../../modelos/aulas/Aulas.php';

$llamados = new Llamados();
$aulas = new Aulas();
$llamados->fechasPrimerLlamado();
$llamados->fechasSegundoLlamado();
$primero = $llamados->getPrimero();
$segundo = $llamados->getSegundo();
$horarios = $llamados->obtenerHorarios();

?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/mesa_modificar.js'></script>
<script type='text/javascript' src='../../js/jquery-confirm-master/js/jquery-confirm.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>INFORME MESA DE EXAMEN</h2>
<form action='../../Controladores/ManejadorMesa.php' id='formInformeMesa' name='formInformeMesa' method='post'>
	<fieldset>
	<legend>Información básica</legend>
	<?php
	echo "<label>Fecha:</label>
	<select id='selectFecha' name='selectFecha'>
	<option value='todas'>Todas las fechas</option>";
	if($primero) {
	    foreach ($primero as $fecha) {
	        $formato = str_replace("/", "-", $fecha);
	        $formato = date('Y-m-d', strtotime($formato));
	        echo "<option value='{$formato}'>{$fecha}</option>";
	    }
	}
	if ($segundo) {
	    foreach ($segundo as $fecha) {
	        $formato = str_replace("/", "-", $fecha);
	        $formato = date('Y-m-d', strtotime($formato));
	        echo "<option value='{$formato}'>{$fecha}</option>";
	    }
	}
	echo "</select>
    <label>Hora:</label>
    <select id='selectHora' name='selectHora'>
    <option value='todas'>Todas las horas</option>";
    if($horarios) {
        foreach ($horarios as $hora) {
            echo "<option>{$hora}</option>";
        }
    }
    echo "</select>
    <label>Sector:</label>
    <select id='selectSector' name='selectSector'>
    <option value='todos'>Todos los sectores</option>";
    if($aulas->getAulas()) {
        foreach ($aulas->getAulas() as $aula) {
            $actual = $aula->getSector();
            if($actual != $previo) {
                echo "<option value='{$aula->getSector()}'>{$aula->getSector()}</option>";
            }
            $previo = $actual;
        }
    }
    echo "</select>
    <label>Modificada:</label>
    <select id='selectModificada' name='selectModificada'>
    <option value='true'>Si</option>
    <option value='false'>No</option>
    </select>";
    ?>
	</fieldset>
	<input type='hidden' id='accion' name='accion' value='informe'>
	<input class='botonVerde' type='submit' id='btnInformeMesa' name='btnInformeMesa' value='Informe'>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
