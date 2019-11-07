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
            	<h2>MODIFICAR MESA DE EXAMEN</h2>
            	<form>
            		<fieldset>
            			<legend>Resultado de la operación</legend>
           				<?php

               				$resultado = $_SESSION['resultado'];
               				if ($resultado['resultado']) {
               				    echo "<h6 class='letraVerde letraCentrada'>{$resultado['mensaje']}</h6>";
               				    
               				    if ($resultado['datos']) {
               				        
               				        $mesa = $resultado['datos'];
               				        $plan = $mesa->getPlan();
               				        $tribunal = $mesa->getTribunal();
               				        
               				        echo "<label>Código de carrera:</label>";
               				        echo "<input type='text' value='{$plan->getCarrera()->getCodigo()}' readonly>";
               				        echo "<label>Nombre de Carrera:</label>";
               				        echo "<input type='text' value='{$plan->getCarrera()->getNombre()}' readonly>";
               				        echo "<br>";
               				        echo "<label>Nombre de Asignatura:</label>";
               				        echo "<input type='text' value='{$plan->getAsignatura()->getNombre()}' readonly>";
               				        echo "<br>";
               				        echo "<label>Nombre de Presidente:</label>";
               				        echo "<input type='text' value='{$tribunal->getPresidente()->getNombre()}' readonly>";
               				        echo "<label>Nombre de Vocal 1:</label>";
               				        echo "<input type='text' value='{$tribunal->getVocal1()->getNombre()}' readonly>";
               				        echo "<br>";
               				        if ($tribunal->getVocal2()) {
               				            echo "<label>Nombre de Vocal 2:</label>";
               				            echo "<input type='text' value='{$tribunal->getVocal2()->getNombre()}' readonly>";
               				            if ($tribunal->getSuplente()) {
               				                echo "<label>Nombre de Suplente:</label>";
               				                echo "<input type='text' value='{$tribunal->getSuplente()->getNombre()}' readonly>";
               				            } else {
               				                echo "<label>Nombre de Suplente:</label>";
               				                echo "<input type='text' value='No se ha designado' readonly>";
               				            }
               				        } else {
               				            echo "<label>Nombre de Vocal 1:</label>";
               				            echo "<input type='text' value='No se ha designado' readonly>";
               				            echo "<label>Nombre de Suplente:</label>";
               				            echo "<input type='text' value='No se ha designado' readonly>";
               				        }
               				        
               				        echo "<br>";
               				        if ($mesa->getPrimero()) {
               				            echo "<label>Primer llamado:</label>";
               				            echo "<input type='text' value='{$mesa->getPrimero()->getFecha()}' readonly>";
               				            
               				            if (!$mesa->getSegundo()) {
               				                echo "<br>";
               				                if ($mesa->getPrimero()->getAula()) {
               				                    echo "<label>Sector:</label>";
               				                    echo "<input type='text' value='{$mesa->getPrimero()->getAula()->getSector()}' readonly>";
               				                    echo "<label>Nombre:</label>";
               				                    echo "<input type='text' value='{$mesa->getPrimero()->getAula()->getNombre()}' readonly>";
               				                    echo "<br>";
               				                    echo "<label>Hora:</label>";
               				                    echo "<input type='text' value='{$mesa->getPrimero()->getHora()}' readonly>";
               				                } else {
               				                    echo "<label>Lugar:</label>";
               				                    echo "<input type='text' value='Campus' readonly>";
               				                    echo "<label>Hora:</label>";
               				                    echo "<input type='text' value='{$mesa->getPrimero()->getHora()}' readonly>";
               				                }
               				               
               				            }
               				        }
               				        if ($mesa->getSegundo()) {
               				            echo "<label>Segundo llamado:</label>";
               				            echo "<input type='text' value='{$mesa->getSegundo()->getFecha()}' readonly>";
               				            echo "<br>";
               				            if($mesa->getSegundo()->getAula()) {
               				                echo "<label>Sector:</label>";
               				                echo "<input type='text' value='{$mesa->getSegundo()->getAula()->getSector()}' readonly>";
               				                echo "<label>Nombre:</label>";
               				                echo "<input type='text' value='{$mesa->getSegundo()->getAula()->getNombre()}' readonly>";
               				                echo "<br>";
               				                echo "<label>Hora:</label>";
               				                echo "<input type='text' value='{$mesa->getSegundo()->getHora()}' readonly>";
               				            }else {
               				                echo "<label>Lugar:</label>";
               				                echo "<input type='text' value='Campus' readonly>";
               				                echo "<label>Hora:</label>";
               				                echo "<input type='text' value='{$mesa->getSegundo()->getHora()}' readonly>";
               				            }
               				        }
               				       
               				    }
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
