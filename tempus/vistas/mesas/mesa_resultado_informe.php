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
<script type="text/javascript" src="../../js/mesas/mesa_resultado_informe.js"></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>INFORME MESA DE EXAMEN</h2>
<form>
	<fieldset>
	<legend>Resultado</legend>
	<?php
	$resultado = $_SESSION['mesaInformeResultado'];
	$mensaje = $resultado['mensaje'];
	$mesas = $resultado['datos'];
	echo "<label>Filtro aplicado:</label>";
	echo "<label>{$mensaje}</label><br>";
	$cantidad = count($mesas);
	if($cantidad > 0) {
	    echo "<div class='content-columnas'>
        <a class='columnas letraVerde' data-column='2'>PRESIDENTE</a>
	    <a class='columnas letraVerde' data-column='3'>VOCAL 1</a>
	    <a class='columnas letraVerde' data-column='4'>VOCAL 2</a>
	    <a class='columnas letraVerde' data-column='5'>SUPLENTE</a>
	    </div>";
        echo "<table id='tablaInformeMesas' class='display' style='width:100%'>
        <thead> <tr> 
        <th>Carrera</th> <th>Asignatura</th> <th>Presidente</th> <th>Vocal1</th> <th>Vocal2</th> <th>Suplente</th> 
        </tr> </thead>
        <tbody>";
	    for ($indice=0; $indice<$cantidad; ++$indice) {
	        $mesa = $mesas [$indice];
	        echo "<tr>";
	        echo "<td>{$mesa->getPlan()->getCarrera()->getNombre()}</td>";
	        echo "<td>{$mesa->getPlan()->getAsignatura()->getNombre()}</td>";
	        echo "<td>{$mesa->getTribunal()->getPresidente()->getNombre()}</td>";
	        echo "<td>{$mesa->getTribunal()->getVocal1()->getNombre()}</td>";
	        $vocal2 = $suplente = "";
	        if ($mesa->getTribunal()->getVocal2()) {
	            $vocal2 = $mesa->getTribunal()->getVocal2()->getNombre();
	            if ($mesa->getTribunal()->getSuplente()) {
	                $suplente = $mesa->getTribunal()->getSuplente()->getNombre();
	            }
	        }
	        echo "<td>{$vocal2}</td>";
	        echo "<td>{$suplente}</td>";
	    }
	    echo "</tbody>
        </table>";
	} else {
	    $mensaje = "No se obtuvieron resultados para el filtro que se ha indicado";
	    echo "<h3 class='letraNaranja letraCentrada'>{$mensaje}</h3>";
	}
	?>
	</fieldset>
	<input class='botonVerde' type='button' value='Regresar' onclick='history.back(-1)'>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>