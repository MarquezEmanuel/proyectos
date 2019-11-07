<?php
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../modelos/carreras/Plan.php';
include_once '../../modelos/cursadas/Cursada.php';
include_once '../../modelos/cursadas/Clase.php';
include_once '../../modelos/aulas/Aula.php';
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<section id="main-content">
<article>
<div class="content">
<h2>IMPORTAR HORARIOS DE CURSADA</h2>
<form>
	<fieldset>
		<legend>Resultado</legend>
		<?php 
    		$resultado = $_SESSION['resultado'];
    		session_unset($_SESSION['resultado']);
    		if ($resultado['resultado']) {    
    		    echo "<h3 class='letraVerde letraCentrada'>{$resultado['mensaje']}</h3>";  		    
    		} else {
    		    /* No se ha realizado la operación */
    		    echo "<h3 class='letraRoja letraCentrada'>{$resultado['mensaje']}</h3>";
    		}		
		?>
	</fieldset>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>