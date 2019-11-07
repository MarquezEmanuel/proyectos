<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../modelos/carreras/Plan.php';
include_once '../../modelos/aulas/Aula.php';
include_once '../../modelos/cursadas/Clase.php';
include_once '../../modelos/cursadas/Cursada.php';
include_once '../../modelos/cursadas/Cursadas.php';
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/Utilidades.php';
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type="text/javascript" src="../../js/cursadas/cursada_resultado_informe.js"></script>
<section id="main-content">
<article>
<div id="content" class="content">
<h2>INFORME HORARIO DE CURSADA</h2>
<form action="cursada_informe.php">
	<fieldset>
	<legend>Resultado</legend>
	<?php
	$resultado = $_SESSION['cursadaInformeResultado'];
	$filtro = $resultado['filtro'];
	$cursadas = $resultado['datos'];
	$leyenda = "";
	if($filtro['dia'] != 'todos') {
	    $leyenda = "Carrera: {$filtro['carrera']}, Día: ".Utilidades::nombreDeDia($filtro['dia']).", ";
	} else {
	    $leyenda = "Carrera: {$filtro['carrera']}, Día: todos, ";
	}
	$leyenda = $leyenda."Hora de inicio: {$filtro['inicio']}, Hora de fin: {$filtro['fin']}";
	echo "<label>Filtro aplicado: </label><label>{$leyenda}</label><br>";
	$cantidad = count($cursadas);
	
	if($cantidad > 0) {
	    echo "<div class='content-columnas'>
        <a class='columnas letraVerde' data-column='2'>LUNES</a>
	    <a class='columnas letraVerde' data-column='3'>MARTES</a>
	    <a class='columnas letraVerde' data-column='4'>MIERCOLES</a>
	    <a class='columnas letraVerde' data-column='5'>JUEVES</a>
        <a class='columnas letraVerde' data-column='6'>VIERNES</a>
        <a class='columnas letraVerde' data-column='7'>SÁBADO</a>
	    </div>";
	    echo "<br><table id='tablaInformeCursadas' class='display'>
		<thead>
		  <tr> <th>Carrera</th> <th>Asignatura</th> <th>Lunes</th> <th>Martes</th> <th>Miercoles</th>
          <th>Jueves</th> <th>Viernes</th> <th>Sabado</th> </tr>
		</thead>
		<tbody>";
	    foreach ($cursadas as $cursada) {
	       $plan = $cursada->getPlan();
	       $carrera = $plan->getCarrera()->getNombre();
	       $asignatura = $plan->getAsignatura()->getNombre();
	       $clases = $cursada->getClases();
	       echo "<tr> <td>{$carrera}</td> <td>{$asignatura}</td>";
	       for ($i=1; $i<7; $i++) {
	           $dia = "";
	           if (isset($clases[$i])) {
	               $aula = $clases[$i]->getAula();
	               $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
	           }
	           echo "<td>{$dia}</td>";
	       }
	       echo "</tr>";
	    }
	    echo "</tbody>
        </table>";
	} else {
	    $mensaje = "No se obtuvieron resultados para el filtro que se ha indicado";
	    echo "<h3 class='letraNaranja letraCentrada'>{$mensaje}</h3>";
	}
    ?>
	</fieldset>
	<input class='botonVerde' type='submit' value='Regresar'>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
