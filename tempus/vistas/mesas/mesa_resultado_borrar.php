<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../modelos/mesas/Mesas.php';
include_once '../../modelos/carreras/Carrera.php';
include_once '../../modelos/carreras/Asignatura.php';
include_once '../../modelos/carreras/Plan.php';
include_once '../../modelos/mesas/Tribunal.php';
include_once '../../modelos/mesas/MesaExamen.php';
include_once '../../modelos/mesas/Llamado.php';
include_once '../../modelos/aulas/Aula.php';
include_once '../../lib/conf/ControlAcceso.php';

?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<section id="main-content">
<article>
<div class="content">
<h2>BORRAR MESA DE EXAMEN</h2>
<form action="mesa_buscar.php">
	<fieldset>
		<legend>Resultado de la operación</legend>
		<?php
		if(isset($_SESSION['mesaBorrarResultado'])) {
		    $resultado = $_SESSION['mesaBorrarResultado'];
		    $mensaje = $resultado['mensaje'];
		    $class = " class='letraVerde letraCentrada' ";
		    if (!$resultado['resultado']) {
		        $class = " class='letraRoja letraCentrada' ";
		    }
		    if($resultado['datos']) {
		        $mesa = $resultado['datos'];
		        echo "<h3 class='letraVerde letraCentrada'>{$mensaje}</h3>
                <fieldset>
                <legend>Información básica</legend>
                <label>Carrera:</label>
            	<input type='text' value='{$mesa->getPlan()->getCarrera()->getNombre()}' readonly>
            	<label>Asignatura:</label>
            	<input type='text' value='{$mesa->getPlan()->getAsignatura()->getNombre()}' readonly>
                </fieldset>";
		    }
		} else {
		    echo "<h3 class='letraRoja letraCentrada'>No se obtuvo un resultado para la operación</h3>";
		}
        ?>
	</fieldset>
	<input class="botonVerde" type="submit" value='Regresar'>
</form>
</div>	
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>