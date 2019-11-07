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
                    		    
                    		    echo "<h6 class='letraVerde letraCentrada'>{$resultado['mensaje']}</h6>";
                    		    
                    		    if ($resultado['datos']) {
                    		    ?>
                    		    	<table id="tablaCursadasNoCargadas" class="display">
                    		    		<thead>
                    		    			<tr>
                                				<th>Código</th>
                                				<th>Carrera</th>
                                				<th>Asignatura</th>
                                				<th>Año</th>
                                				<th>Lunes</th>
                                				<th>Martes</th>
                                				<th>Miercoles</th>
                                				<th>Jueves</th>
                                				<th>Viernes</th>
                                				<th>Sábado</th>
                                			</tr>
                    		    		</thead>
                    		    		<tbody>
                    		    		<?php
                    		    		    $cursadas = $resultado['datos'];
                    		    		    foreach ($cursadas as $cursada) {
                    		    		        $plan = $cursada->getPlan();
                    		    		        $asignatura = $plan->getAsignatura();
                    		    		        $carrera = $plan->getCarrera();
                    		    		        $clases = $cursada->getClases();
                    		    		        echo "<tr>";
                    		    		        echo "<td>{$carrera->getNombre()}</td>";
                    		    		        echo "<td>{$asignatura->getNombre()}</td>";
                    		    		        $cantidad = count($clases);
                    		    		        
                    		    		        for ($i=1; $i<7; $i++) {
                    		    		            if (isset($clases[$i])) {
                    		    		                
                    		    		                $aula = $clases[$i]->getAula();
                    		    		                $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
                    		    		                
                    		    		                echo "<td>{$dia}</td>";
                    		    		            } else {
                    		    		                echo "<td></td>";
                    		    		            }
                    		    		        }
                    		    		        echo "</tr>";
                    		    		    }
                                            ?>
                    		    		</tbody>
                    		    	</table>
                    		    <?php 
                    		    }
                    		} else {
                    		    /* No se ha realizado la operación */
                    		    echo "<h6 class='letraRoja letraCentrada'>{$resultado['mensaje']}</h6>";
                    		    
                    		    if ($resultado['datos']) {
                    		        
                    		        ?>
                    		    	<table id="tablaCursadasNoCargadas" class="display">
                    		    		<thead>
                    		    			<tr>
                                				<th>Código</th>
                                				<th>Carrera</th>
                                				<th>Asignatura</th>
                                				<th>Año</th>
                                				<th>Lunes</th>
                                				<th>Martes</th>
                                				<th>Miercoles</th>
                                				<th>Jueves</th>
                                				<th>Viernes</th>
                                				<th>Sábado</th>
                                			</tr>
                    		    		</thead>
                    		    		<tbody>
                    		    		<?php
                    		    		    $cursadas = $resultado['datos'];
                    		    		    foreach ($cursadas as $cursada) {
                    		    		        $plan = $cursada->getPlan();
                    		    		        $asignatura = $plan->getAsignatura();
                    		    		        $carrera = $plan->getCarrera();
                    		    		        $clases = $cursada->getClases();
                    		    		        echo "<tr>";
                    		    		        echo "<td>{$carrera->getNombre()}</td>";
                    		    		        echo "<td>{$asignatura->getNombre()}</td>";
                    		    		        $cantidad = count($clases);
                    		    		        
                    		    		        for ($i=1; $i<7; $i++) {
                    		    		            if (isset($clases[$i])) {
                    		    		                
                    		    		                $aula = $clases[$i]->getAula();
                    		    		                $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
                    		    		                
                    		    		                echo "<td>{$dia}</td>";
                    		    		            } else {
                    		    		                echo "<td></td>";
                    		    		            }
                    		    		        }
                    		    		        echo "</tr>";
                    		    		    }
                                            ?>
                    		    		</tbody>
                    		    	</table>
                    		    <?php 
                    		    }
                    		}
                    		
                		?>
                	</fieldset>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>