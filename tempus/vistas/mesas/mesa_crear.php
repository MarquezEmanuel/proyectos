<?php

    header('Content-Type: text/html; charset=ISO-8859-1');
    include_once '../../lib/conf/ControlAcceso.php';
    include_once '../../lib/conf/PermisosSistema.php';
    include_once '../../modelos/mesas/Mesas.php';

    /*
     ControlAcceso::requierePermiso(PermisosSistema::MESAS);
     */
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $hoy = date("Y-m-d");
    
    /* Fecha minima del segundo llamado (fecha actual mas 7 dias) */
    $fechaminima = strtotime ('+7 days' , strtotime($hoy));
    $fechaminima = date("Y-m-d", $fechaminima);
    
    /* Fecha maxima del segundo llamado (fecha actual mas 1 anio) */
    $fechamaxima = strtotime ('+1 year' , strtotime($hoy));
    $fechamaxima = date("Y-m-d", $fechamaxima);
    
    $mesas = new Mesas();
    $llamados = $mesas->cantidadLlamados();
?>

<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/mesas/mesa_crear.js"></script>
	<section id="main-content">
		<article>
			<div id="content" class="content">
			
            	<h2>CREAR MESA DE EXAMEN</h2>
            	<form action="../../controladores/ManejadorMesa.php" id="formCrearMesa" name="formCrearMesa" method="post" >
            	
            		<fieldset>
            			<legend>Nueva mesa de examen</legend>
            			
            			<fieldset>
            				<legend>Información básica</legend>
            				<label for="txtCarrera">* Código:</label>
            				<input type="number" id="codigoCarrera" name="codigoCarrera" title="Ingrese el código de la carrera" min="1" max="999" required>
            			
                			<label for="txtCarrera">* Nombre carrera:</label>
                			<input type="text" id="txtCarrera" name="txtCarrera" title="Ingrese el nombre de la carrera" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ. ]{10,255}" required>
                			
                			<label for="txtAsignatura">* Nombre asignatura:</label>
                			<input type="text" id="txtAsignatura" name="txtAsignatura" title="Ingrese el nombre de la asignatura" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ0123456789,. ]{5,255}" required>
            			</fieldset>
            			
            			<fieldset>
            				<legend>Tribunal</legend>
            				<label for="txtNombrePresidente">* Presidente:</label>
            		        <input type="text" name="txtNombrePresidente" id="txtNombrePresidente" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ,. ]{4,255}">
            		          
            		        <label for="txtNombreVocal1">* Vocal 1:</label>
            		        <input type="text" name="txtNombreVocal1" id="txtNombreVocal1" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ,. ]{4,255}">
            		          
            		        <br>
            		          
            		        <label for="txtNombreVocal2">Vocal 2:</label>
            		        <input type="text" name="txtNombreVocal2" id="txtNombreVocal2" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ,. ]{4,255}">
            		          
            		        <label for="txtNombreSuplente">Suplente:</label>
            		        <input type="text" name="txtNombreSuplente" id="txtNombreSuplente" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ,. ]{4,255}">
            			</fieldset>
           				
           				<fieldset>
            		    	<legend>Llamados</legend>
            		         
            		        <label for="datePrimerLlamado">Primer Llamado:</label>
            		        <input type="date"  name="datePrimerLlamado" id="datePrimerLlamado" value="<?=$hoy;?>" min="<?=$hoy;?>" max="<?=$fechamaxima;?>">
            		        <?php
                		        if ($llamados && $llamados > 0) {
                		            echo "<label for='dateSegundoLlamado'>Segundo Llamado:</label>";
                		            echo "<input type='date' name='dateSegundoLlamado' id='dateSegundoLlamado' min='{$fechaminima}' max='{$fechamaxima}'>";
                		        }
            		        ?>
        		        </fieldset>
        		        
        		        <fieldset>
        		        	<legend>Lugar</legend>
        		        	
        		        	<label for="txtSector">* Sector</label>
        		        	<input type="text" name="txtSector" id="txtSector" pattern="[A-Z]" maxlength="1" required>
        		        	
        		        	<label for="txtNombreAula">* Nombre aula:</label>
        		        	<input type="text" name="txtNombreAula" id="txtNombreAula" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ0123456789 ]{1,255}" required>
        		        	
        		        	<label for="selectHora">* Hora:</label>
        		        	<select name="selectHora" id="selectHora">
        		        	<?php
        		                for ($hora = 10; $hora < 23; ++$hora) {
        		                    echo "<option value='{$hora}:00'>{$hora}:00 hs</option>";
            					}
            				?>
        		        	</select>
        		        	
        		        </fieldset>
           				
            		</fieldset>
            		<input type="hidden" id="accion" name="accion" value="crear">
            		<input class="botonVerde" type="submit" id="btnCrearMesa" name="btnCrearMesa" value="Crear">
            	</form>
            	
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
