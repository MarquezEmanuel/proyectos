<?php

   include_once '../../lib/conf/ControlAcceso.php'; 
   
?>

<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>IMPORTAR MESAS DE EXAMEN</h2>
            	<form>
                	<fieldset>
                		<legend>Resultado</legend>
                		<?php 
                		
                    		$resultado = $_SESSION['resultado'];
                    		session_unset($_SESSION['resultado']);
                		    
                    		if ($resultado['resultado']) {
                    		    
                    		    echo "<h6 class='letraVerde letraCentrada'>{$resultado['mensaje']}</h6>";
                    		    
                    		    if ($resultado['datos']) {
                    		        
                    		        echo "<h6 class='letraRoja letraCentrada'>Las siguientes mesas de examen no se han podido crear</h6>";
                    		        $datos = $resultado['datos'];
                    		        
                    		        if(count($datos[0]) == 10) {
                    		        ?>
                                        <table id="tablaMesasNoCargadas" class="display">
                                        	<thead>
                                        		<tr>
                                                    <th>Código</th>
                                                    <th>Carrera</th>
                                                    <th>Asignatura</th>
                                                    <th>Presidente</th>
                                                    <th>Vocal 1</th>
                                                    <th>Vocal 2</th>
                                                    <th>Suplente</th>
                                                    <th>Llamado 1</th>
                                                    <th>Llamado 2</th>
                                                    <th>Hora</th>
                                              </tr>
                                        	</thead>
                                        	<tbody>
                                        	<?php
                                            	foreach ($datos as $mesa) {
                                            	    echo "<tr>";
                                            	    echo "<td>{$mesa[0]}</td>";
                                            	    echo "<td>{$mesa[1]}</td>";
                                            	    echo "<td>{$mesa[2]}</td>";
                                            	    echo "<td>{$mesa[3]}</td>";
                                            	    echo "<td>{$mesa[4]}</td>";
                                            	    echo "<td>{$mesa[5]}</td>";
                                            	    echo "<td>{$mesa[6]}</td>";
                                            	    echo "<td>{$mesa[7]}</td>";
                                            	    echo "<td>{$mesa[8]}</td>";
                                            	    echo "<td>{$mesa[9]}</td>";
                                            	    echo "</tr>";
                                            	}
                                        	?>
                                        	</tbody>
                                        </table>
                                        <?php
                                        
                                    } else {
                                        ?>
                                        <table id="tablaMesasNoCargadas" class="display">
                                        	<thead>
                                        		<tr>
                                                    <th>Código</th>
                                                    <th>Carrera</th>
                                                    <th>Asignatura</th>
                                                    <th>Presidente</th>
                                                    <th>Vocal 1</th>
                                                    <th>Vocal 2</th>
                                                    <th>Suplente</th>
                                                    <th>Llamado 1</th>
                                                    <th>Hora</th>
                                              </tr>
                                        	</thead>
                                        	<tbody>
                                        	<?php
                                            	foreach ($datos as $mesa) {
                                            	    echo "<tr>";
                                            	    echo "<td>{$mesa[0]}</td>";
                                            	    echo "<td>{$mesa[1]}</td>";
                                            	    echo "<td>{$mesa[2]}</td>";
                                            	    echo "<td>{$mesa[3]}</td>";
                                            	    echo "<td>{$mesa[4]}</td>";
                                            	    echo "<td>{$mesa[5]}</td>";
                                            	    echo "<td>{$mesa[6]}</td>";
                                            	    echo "<td>{$mesa[7]}</td>";
                                            	    echo "<td>{$mesa[8]}</td>";
                                            	    echo "</tr>";
                                            	}
                                            ?>
                                        	</tbody>
                                        </table>
                                        <?php
                                    }
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