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
            	<h2>CREAR MESA DE EXAMEN</h2>
            	<form>
            		<fieldset>
            			<legend>Resultado de la operación</legend>
           				<?php

               				$resultado = $_SESSION['resultado'];
               				if ($resultado['resultado']) {
               				    echo "<h6 class='letraVerde letraCentrada'>{$resultado['mensaje']}</h6>";
               				    
               				} else {
               				    echo "<h6 class='letraRoja letraCentrada'>{$resultado['mensaje']}</h6>";
               				}
  
                        ?>
            		</fieldset>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>