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
<script type="text/javascript" src="../../js/cursadas/cursada_resultado_buscar.js"></script>
<section id="main-content">
<article>
<div id="content" class="content">
<h2>BUSCAR HORARIO DE CURSADA</h2>
<form action="../../Controladores/ManejadorCursada.php" id="formBuscarCursadas" name="formBuscarCursadas" method="post">
	<fieldset>
		<legend>Resultado de la búsqueda</legend>
		<?php
	    /* Se obtiene el resultado y se elimina de la sesion. */
		$resultado = $_SESSION['resultado'];
		
		if ($resultado['resultado']) {
		    
		    $cursadas = $resultado['datos'];
		    
		    /* Se elimina la variable de sesion */
		    if ($cursadas) {
		      echo "<div class='content-columnas'>
              <a class='columnas letraVerde' data-column='3'>LUNES</a>
        	  <a class='columnas letraVerde' data-column='4'>MARTES</a>
        	  <a class='columnas letraVerde' data-column='5'>MIERCOLES</a>
        	  <a class='columnas letraVerde' data-column='6'>JUEVES</a>
              <a class='columnas letraVerde' data-column='7'>VIERNES</a>
              <a class='columnas letraVerde' data-column='8'>SÁBADO</a>
        	  </div>";
		    ?>
			<br>
			<table id="tablaBuscarCursadas" class="display">
				<thead>
					<tr>	
						<th></th>
						<th>Carrera</th>
						<th>Asignatura</th>
						<th>Lunes</th>
						<th>Martes</th>
						<th>Miercoles</th>
						<th>Jueves</th>
						<th>Viernes</th>
						<th>Sabado</th>
					</tr>
				</thead>
				<tbody>
				<?php
		        
				$tamanio = count($cursadas);
				for ($indice=0; $indice<$tamanio; ++$indice) {
				    $cursada = $cursadas [$indice];
				    $plan = $cursada->getPlan();
				    $asignatura = $plan->getAsignatura();
				    $carrera = $plan->getCarrera();
				    $clases = $cursada->getClases();
				    
				    echo "<tr>";
				    echo "<td><input type='radio' id='radioCursadas' name='radioCursadas' value='".$indice."'></td>";
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
    		} else {
    		    /* No se han encontrado resultados */
    		    $mensaje = $resultado['mensaje'];
    		    echo "<h3 class='letraVerde letraCentrada'>No se han encontrado resultados</h3>";
    		}
		    
		} else {
		    /* El resultado es falso */
		    echo "<h3 class='letraRoja letraCentrada'>No se ha obtenido la información sobre cursadas para la búsqueda ingresada</h3>";
		}
        ?>
	</fieldset>
	<?php
    	if($cursadas) {
    ?>
       		<input class="botonRojo" type="submit" id="btnBorrarCursada" name="btnBorrarCursada" value="Borrar">
        	<input class="botonVerde" type="submit" id="btnModificarCursada" name="btnModificarCursada" value="Modificar">
        	<input type="hidden" id="accion" name="accion" value="">
    <?php
    	}
    ?>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
