<?php

header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
require_once '../../modelos/carreras/Plan.php';
require_once '../../modelos/mesas/Tribunal.php';
require_once '../../modelos/mesas/Llamado.php';
require_once '../../modelos/mesas/MesaExamen.php';
require_once '../../modelos/mesas/Mesas.php';
$mesas = new Mesas();
$mesas->obtenerMesasDeHoy();

?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/mesas/mesa_asignar.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>ASIGNAR AULAS</h2>
<?php
if(isset($_SESSION['mesaAsignarResultado'])) {
    // resultado [true/false, mensaje]
    $mesaAsignarResultado = $_SESSION['mesaAsignarResultado'];
    $resultado = $mesaAsignarResultado['resultado'];
    $mensaje = $mesaAsignarResultado['mensaje'];
    $class = " class='letraVerde letraCentrada' ";
    if(!$resultado) {
        $class = " class='letraRoja letraCentrada' ";
    }
    echo "<h6 {$class}>{$mensaje}</h6>";
    $_SESSION['mesaAsignarResultado'] = null;
}
?>
<form action='mesa_asignar_aula.php' id='formMesaAsignar' name='formMesaAsignar' method='post'>
	<fieldset>
    <?php
    if($mesas) {
        $cantidad = count($mesas->getMesas());
        
        if($cantidad > 0) {
            $arreglo = $mesas->getMesas();
            echo "<legend>Listado de mesas de examen sin asignar aula</legend>
	        <table id='tablaAsignarAulas' style='width:100%'>
	        <thead>
            <tr> <th></th> <th>Carrera</th> <th>Asignatura</th> <th>Asignar</th> </tr>
            </thead>
            </tbody>";
            for ($i=0; $i<$cantidad; $i++) {
                $mesa = $arreglo[$i];
                echo "<tr>
                <td><input type='radio' id='radMesa' name='radMesa' value='{$i}'></td>
                <td>{$mesa->getPlan()->getCarrera()->getNombre()}</td>
                <td>{$mesa->getPlan()->getAsignatura()->getNombre()}</td>
                <td><input type='image' src='../../img/abm_editar.png' id='imgAsignar{$i}' name='imgAsignar{$i}' title='Asignar aula a mesa de examen' style='display:none;'/></td>
                </tr>";
            }
            echo "</tbody>
            </table>";
            $_SESSION['mesasSinAsignar'] = $arreglo;
        } else {
            echo "<legend>Resultado</legend>";
            echo "<h6 class='letraCentrada'>No hay mesas de examen para asignar aulas</h6>";
        }
    } else {
        
    }
    ?>
	</fieldset>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>