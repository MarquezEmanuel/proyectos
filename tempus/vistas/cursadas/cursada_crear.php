<?php 
    
include_once '../../lib/conf/ControlAcceso.php'; 
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../lib/conf/Utilidades.php';
include_once '../../modelos/carreras/Asignatura.php';
include_once '../../modelos/carreras/Carrera.php';
include_once '../../modelos/carreras/Asignaturas.php';
include_once '../../modelos/carreras/Carreras.php';
include_once '../../modelos/aulas/Aulas.php';
include_once '../../modelos/aulas/Aula.php';

/* Recupera todas las asignaturas, carreras y aulas cargadas en la BD */
$asignaturas = new Asignaturas();
$carreras = new Carreras();
$aulas = new Aulas();

/* Establece los datos para los campos del formulario */
$nam_codigo = " name='codigoCarrera' id='codigoCarrera' ";
$nam_carrera = " name='txtCarrera' id='txtCarrera' ";
$nam_asignatura = " name='txtAsignatura' id='txtAsignatura' ";
$nam_anio = " name='selectAnio' id='selectAnio' ";
$pat_carrera = " pattern='[A-Za-záéíóúÁÉÍÓÚñÑ. ]{10,255}' ";
$pat_asignatura = " pattern='[A-Za-záéíóúÁÉÍÓÚñÑ0123456789,. ]{5,255}' ";
$pat_sector = " pattern='[A-Z]{1}' ";
$pat_aula = " pattern='[A-Za-záéíóúÁÉÍÓÚñÑ0123456789 ]{1,255}' ";
?>
<html>
<?php include_once '../estructura/encabezado.php';?>
<script type='text/javascript' src='../../js/cursadas/cursada_crear.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>CREAR HORARIO DE CURSADA</h2>
<form action='../../controladores/ManejadorCursada.php' id='formCrearCursada' name='formCrearCursada' method='post'>
   
	<fieldset>
	<legend>Horario</legend>      			
	<fieldset>
	<legend>Información básica</legend>
	<?php 
    if ($carreras->getCarreras()) {
        echo "<label for='codigoCarrera'>* Código de carrera:</label>";
        echo "<input type='number' {$nam_codigo} list='codigos' required>";
        echo "<datalist id='codigos' name='codigos'>";
        foreach ($carreras->getCarreras() as $carrera) {
            echo "<option value='{$carrera->getCodigo()}'>{$carrera->getNombre()}</option>";
        }
        echo "</datalist>";
        echo "<label for='txtCarrera'>* Nombre de Carrera:</label>";
        echo "<input type='text' {$nam_carrera} list='carreras' required>";
        echo "<datalist id='carreras' name='carreras'>";
        foreach ($carreras->getCarreras() as $carrera) {
            echo "<option value='{$carrera->getNombre()}'>{$carrera->getCodigo()}</option>";
        }
        echo "</datalist>";
    } else {
        echo "<label for='codigoCarrera'>* Código de carrera:</label>";
        echo "<input type='number' {$nam_codigo} required>";
        echo "<label for='txtCarrera'>* Nombre de Carrera:</label>";
        echo "<input type='text' {$nam_carrera} required>";
    }
    echo "<br>";
    echo "<label for='txtAsignatura'>* Nombre de Asignatura:</label>";
    echo "<input type='text' {$nam_asignatura} required>";
    echo "<label for='selectAnio'>* Año:</label>";
    echo "<select {$nam_anio} required>";
        echo "<option value='1'>1ro</option>";
    	echo "<option value='2'>2do</option>";
    	echo "<option value='3'>3ro</option>";
    	echo "<option value='4'>4to</option>";
    	echo "<option value='5'>5to</option>";
    echo "</select>";
    echo "</fieldset>";
	echo "<fieldset>";
	echo "<legend>Horarios de clases</legend>";
	echo "<table id='tablaCrearCursada' class='tablaCrearCursada'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th></th>";
	echo "<th>Día</th>";
	echo "<th>Hora de inicio</th>";
	echo "<th>Hora de fin</th>";
	echo "<th>Nombre de sector</th>";
	echo "<th>Nombre de aula</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	for ($i = 1; $i < 7; ++$i) {
	    echo "<tr>";
	    echo "<td><input type='checkbox' value='{$i}' name='cbDiasClase{$i}' id='cbDiasClase{$i}'></td>";
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
	    echo "<td><select name='selectHoraInicio{$i}' id='selectHoraInicio{$i}' disabled='disabled'>";
	    for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
	        echo "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>";
	        echo "<option value='{$horainicio}:30'>{$horainicio}:30 hs</option>";
	    }
	    echo "</select></td>";
	    echo "<td><select name='selectHoraFin{$i}' id='selectHoraFin{$i}' disabled='disabled'>";
	    for ($horafin = 11; $horafin < 24; ++$horafin) {
	        echo "<option value='{$horafin}:00'>{$horafin}:00 hs</option>";
	        echo "<option value='{$horafin}:30'>{$horafin}:30 hs</option>";
	    }
	    echo "</select></td>";
	    if($aulas->getAulas()) {
	        echo "<td>";
	        echo "<input type='text' id='txtSector{$i}' name='txtSector{$i}' {$pat_sector} list='sectores' disabled required>";
	        echo "<datalist id='sectores' name='sectores'>";
	        $previo = "";
	        foreach ($aulas->getAulas() as $aula) {
	            $actual = $aula->getSector();
	            if($actual != $previo) {
	                echo "<option value='{$aula->getSector()}'></option>";
	            }
	            $previo = $actual;
	        }
	        echo "</datalist>";
	        echo "</td>";
	        echo "<td>";
	        echo "<input type='text' id='txtAula{$i}' name='txtAula{$i}' {$pat_aula} list='aulas' disabled required>";
	        echo "<datalist id='aulas' name='aulas'>";
	        foreach ($aulas->getAulas() as $aula) {
	            echo "<option value='{$aula->getNombre()}'>{$aula->getSector()}</option>";
	        }
	        echo "</datalist>";
	        echo "</td>";
	    } else {
	        echo "<td><input type='text' id='txtSector{$i}' name='txtSector{$i}' {$pat_sector} disabled required></td>";
	        echo "<td><input type='text' id='txtAula{$i}' name='txtAula{$i}' {$pat_aula} disabled required></td>";
	    }
	    echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";	
    ?>
	</fieldset>
    </fieldset>
    <input type='hidden' id='accion' name='accion' value='crear'>
    <input class='botonVerde' type='submit' id='btnCrearCursada' name='btnCrearCursada' value='Crear'>
</form>      	
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
