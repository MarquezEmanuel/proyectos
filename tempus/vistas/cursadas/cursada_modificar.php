<?php
    header('Content-Type: text/html; charset=ISO-8859-1');
    
    include_once '../../modelos/carreras/Plan.php';
    include_once '../../modelos/aulas/Aula.php';
    include_once '../../modelos/cursadas/Clase.php';
    include_once '../../modelos/cursadas/Cursada.php'; 
    include_once '../../lib/conf/ControlAcceso.php';
?>
<html>
	
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/cursadas/cursada_modificar.js'></script>
<script type='text/javascript' src='../../js/jquery-confirm-master/js/jquery-confirm.js'></script>

<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>MODIFICAR HORARIO DE CURSADA</h2>
<form action='../../controladores/ManejadorCursada.php' id='formModificarCursada' name='formModificarCursada' method='post'>

	<?php	
	$resultado = $_SESSION['resultado'];
	if (isset($resultado)) {
	    /* SE HA DEFINIDO RESULTADO */
	    if (isset($resultado['datos'])) {
	        /* RECUPERA LOS DATOS DEL HORARIO DE CURSADA SELECCIONADO */
	        
	        if($resultado['resultado']) {
	            $mensaje = $resultado['mensaje'];
	            echo "<h3 id='mensaje' class='letraVerde'>$mensaje</h3>";
	        } else {
	            $mensaje = $resultado['mensaje'];
	            echo "<h3 id='mensaje' class='letraRoja'>$mensaje</h3>";
	        }
	        $cursada = $resultado['datos'];
	        $plan = $cursada->getPlan();
	        $asignatura = $plan->getAsignatura();
	        $carrera = $plan->getCarrera();
	        $clases = $cursada->getClases();        
	?>
	        <fieldset>
    			<fieldset title='Los cambios en alguno de estos campos no genera una notificación en la aplicación movil del sistema'>
    				<legend>Información básica</legend>
    				<label for='numCarrera'>* Código de carrera:</label>
    				<input type='number' name='numCarrera' id='numCarrera' value='<?= $carrera->getCodigo(); ?>' required>
    				<label for='txtCarrera'>* Nombre de carrera:</label>
    				<input type='text' name='txtCarrera' id='txtCarrera' value='<?= $carrera->getNombre(); ?>' required>
    				<label for='txtAsignatura'>* Nombre de asignatura:</label>
    				<input type='text' name='txtAsignatura' id='txtAsignatura' value='<?= $asignatura->getNombre(); ?>' required>
    				<label for="selAnio">* Año:</label>
    				<select name="selAnio" id="selAnio" required>
    					<option value="1">1</option>
    					<option value="2">2</option>
    					<option value="3">3</option>
    					<option value="4">4</option>
    					<option value="5">5</option>
    				</select>
    				<br>
    				<p><input class="botonVerde" type="submit" id="btnModificarCursada" name="btnModificarCursada" value="Modificar"></p>
    				
    			</fieldset>
    			
    			<fieldset title="Los cambios en alguno de estos campos genera una notificación en la aplicación movil del sistema">
    				<legend>Horarios de clase</legend>
    				<table id="tablaCrearCursada" class="tablacursada">
    					<thead>
    						<tr>
    							<th></th>
    							<th>Día</th>
    							<th>Hora de inicio</th>
    							<th>Hora de fin</th>
    							<th>Nombre de sector</th>
    							<th>Nombre de aula</th>
    							<th>Modificación</th>
    							<th></th>
    							<th></th>
    						</tr>	
    					</thead>
    					<tbody>
    					<?php
    						for ($i = 1; $i < 7; ++$i) {
    						    echo "<tr>";
    						    echo "<td><input type='radio' value='{$i}' name='radDias' id='radDias'></td>";
    						    $dia = $i;
    						    switch ($i) {
    						        case 1:
    						            $dia = 'Lunes';
    						            break;
    						        case 2:
    						            $dia = 'Martes';
    						            break;
    						        case 3:
    						            $dia = 'Miercoles';
    						            break;
    						        case 4:
    						            $dia = 'Jueves';
    						            break;
    						        case 5:
    						            $dia = 'Viernes';
    						            break;
    						        case 6:
    						            $dia = 'Sábado';
    						            break;
    						    }
    						    
    						    echo "<td>{$dia}</td>";
    						    echo "<td><select name='selectHoraInicio{$i}' id='selectHoraInicio{$i}' disabled>";
    						    for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
    						        if($clases[$i]) {
    						            if($clases[$i]->getDesde() == $horainicio+":00"){
    						                echo "<option value='{$horainicio}:00' selected>{$horainicio}:00 hs</option>";
    						            } else {
    						                echo "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>";
    						            }
    						        } else{
    						            echo "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>";
    						        }
    						    }
    						    echo "</select></td>";
    						    echo "<td><select name='selectHoraFin{$i}' id='selectHoraFin{$i}' disabled>";
    						    for ($horafin = 11; $horafin < 24; ++$horafin) {
    						        if($clases[$i]) {
    						            
    						            if($clases[$i]->getHasta() == $horafin+":00"){
    						                echo "<option value='{$horafin}:00' selected>{$horafin}:00 hs</option>";
    						            } else {
    						                if($clases[$i]->getDesde().substr(0, 2) < $horafin) {
    						                    echo "<option value='{$horafin}:00'>{$horafin}:00 hs</option>";
    						                } else {
    						                    echo "<option value='{$horafin}:00' disabled >{$horafin}:00 hs</option>";
    						                }
    						            }
    						        } else{
    						            echo "<option value='{$horafin}:00'>{$horafin}:00 hs</option>";
    						        }
    						    }
    						    echo "</select></td>";
    						    if(isset($clases[$i])) {
    						        /** EXISTE UNA CLASE PARA EL DIA I (0 a 6) */
    						        $aula = $clases[$i]->getAula();
    						        $fechamod = "";
    						        if ($clases[$i]->getFechamod()) {
    						            $fechamod = $clases[$i]->getFechamod();
    						        } else {
    						            $fechamod = "No registra";
    						        }
    						        echo "<td><input type='text' id='txtSector{$i}' name='txtSector{$i}' value='{$aula->getSector()}' required title='Nombre del sector' maxlength='1' disabled></td>";
    						        echo "<td><input type='text' id='txtAula{$i}' name='txtAula{$i}' value='{$aula->getNombre()}' required disabled></td>";
    						        echo "<td>{$fechamod}</td>";
    						        echo "<td><img src='../../img/abm_editar.png' id='imgModificar{$i}' name='imgModificar{$i}' title='Modificar clase dia {$dia}' style='display:none;'/></td>";
    						        echo "<td><img src='../../img/abm_eliminar.png' id='imgBorrar{$i}' name='imgBorrar{$i}' title='Borrar clase dia {$dia}' style='display:none;'/></td>";
    						        echo "<input type='hidden' id='idclase{$i}' name='idclase{$i}' value='{$clases[$i]->getIdclase()}'>";
    						    } else {
    						        echo "<td><input type='text' id='txtSector{$i}' name='txtSector{$i}' title='Nombre del sector' maxlength='1' required disabled></td>";
    						        echo "<td><input type='text' id='txtAula{$i}' name='txtAula{$i}' required disabled></td>";
    						        echo "<td></td>";
    						        echo "<td><img src='../../img/abm_ver.png' id='imgCrear{$i}' name='imgCrear{$i}' title='Crear clase dia {$dia}' style='display:none;'/></td>";
    						        echo "<td></td>";
    						    }
    						    echo "</tr>";
    						}
    					?>
    					</tbody>
    				</table>
    			</fieldset>
    		</fieldset>
		        
	<?php
	    } else {
	        /*if (isset($resultado['datos'])) NO SE HAN OBTENIDO LOS DATOS */
	        
	        echo "<fieldset>";
	        echo "<legend>Resultado</legend>";
	        echo "<h3 class='letraRoja letraCentrada'>No se han obtenido los datos del horario de cursada modificado</h3>";
	        echo "</fieldset>";
	        
	    }
	} else {
	    /* if (isset($resultado)) NO SE HA DEFINIDO RESULTADO O ES NULO */
	    
	    echo "<fieldset>";
	    echo "<legend>Resultado</legend>";
	    echo "<h3 class='letraRoja letraCentrada'>No se ha obtenido el resultado de la operación</h3>";
	    echo "</fieldset>";
	  }
	?>
	<input type="hidden" id="accion" name="accion" value="">
	<input type="hidden" id="aplicarTodas" name="aplicarTodas" value="">
</form>
	
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
