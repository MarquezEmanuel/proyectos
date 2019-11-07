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
include_once '../../modelos/aulas/Aulas.php';
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../lib/conf/Utilidades.php';
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/mesas/mesa_asignar_aula.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>ASIGNAR AULA</h2>
<form action='../../controladores/ManejadorMesa.php' id='formAsignarAula' name='formAsignarAula' method='post'>
    <?php 
    $mesas =  $_SESSION['mesasSinAsignar'];
    $indice = $_POST['radMesa'];
    $aulas = new Aulas();
    
    if(isset($mesas)) {
        $fecha_actual = strtotime(date("d-m-Y",time()));
        $mesa = $mesas[$indice];
        $carrera = $mesa->getPlan()->getCarrera()->getNombre();
        $asignatura = $mesa->getPlan()->getAsignatura()->getNombre();
        $idllamado; 
        $dia = $llamado = $fecha = $hora = "";
        $numdia = 0;
        if($mesa->getPrimero()) {
            $fechaprimero = $mesa->getPrimero()->getFecha();
            $fechaprimero = str_replace("/", "-", $fechaprimero);
            $fechaprimero =  strtotime($fechaprimero);
            if($fechaprimero = $fecha_actual) {
                $idllamado = $mesa->getPrimero()->getIdllamado();
                $llamado = "Primer llamado: ";
                $numdia = date("N", $fechaprimero);
                $dia = Utilidades::nombreDeDia($numdia)." ";
                $fecha = $mesa->getPrimero()->getFecha()." ";
                $hora = $mesa->getPrimero()->getHora();
            }
        } else {
            $idllamado = $mesa->getSegundo()->getIdllamado();
            $fechasegundo = $mesa->getSegundo()->getFecha();
            $fechasegundo = str_replace("/", "-", $fechasegundo);
            $fechaprimero =  strtotime($fechasegundo);
            $llamado = "Segundo llamado: ";
            $numdia = date("N", $fechasegundo);
            $dia = Utilidades::nombreDeDia($numdia)." ";
            $fecha = $mesa->getSegundo()->getFecha()." ";
            $hora = $mesa->getSegundo()->getHora();
        }
        $ocupadas = $aulas->getAulas();
        $aulas->obtenerAulasDisponiblesClases($numdia, $hora);
        $disponibles = $aulas->getAulas();
        $hora = $hora." hs";
        echo "<fieldset>
        <legend>{$carrera} - {$asignatura}</legend>
        <input type='hidden' id='idllamado' name='idllamado' value='{$idllamado}'>
        <label>{$llamado}</label>
        <label>{$dia} {$fecha} {$hora}</label><br>
        <fieldset title='Esta opción permite seleccionar un aula disponible en una franja horaria de 3 hs a partir de la hora de inicio'>
        <legend><input type='radio' id='radTipoAsignacion' name='radTipoAsignacion' value='0' checked> Seleccionar aula libre </legend>
        <div id='divDisponible'>";
        if($disponibles) {
            echo "<label>Aula:</label>";
            echo "<select id='selectAulaDisp' name='selectAulaDisp'>";
            foreach ($disponibles as $aula) {
                echo "<option value='{$aula->getIdaula()}'>{$aula->getSector()} - {$aula->getNombre()}</option>";
            }
            echo "</select>";
            echo "<input type='image' src='../../img/abm_confirmar.png' title='Asignar aula a mesa de examen'/>";
        } else {
            echo "<h6 class='letraNaranja letraCentrada'>No se obtuvieron aulas para mostrar</h6>";
        }
        echo "</div>
        </fieldset>
        <fieldset title='Esta opción permite seleccionar un aula aunque este ocupada por una clase'>
        <legend><input type='radio' id='radTipoAsignacion' name='radTipoAsignacion' value='1'> Seleccionar aula ocupada </legend>
        <div id='divOcupada' style='display:none;'>";
        if($ocupadas) {
            echo "<label>Aula:</label>";
            echo "<select id='selectAulaOcup' name='selectAulaOcup'>";
            foreach ($ocupadas as $aula) {
                echo "<option value='{$aula->getIdaula()}'>{$aula->getSector()} - {$aula->getNombre()}</option>";
            }
            echo "</select>";
            echo "<input type='image' src='../../img/abm_confirmar.png' title='Asignar aula a mesa de examen'/>";
        } else {
            echo "<h6 class='letraNaranja letraCentrada'>No se obtuvieron aulas para mostrar</h6>";
        }
        echo "</div>
        </fieldset>
        </fieldset>
        <input type='hidden' id='accion' name='accion' value='asignarAula'>
        <input class='botonVerde' type='button' value='Regresar' onclick='history.back(-1)'>";
    } else {
        echo "<fieldset>
        <legend>Resultado</legend>
        <h6 class='letraNaranja letraCentrada'>No hay mesas de examen para asignar aulas</h6>
        </fieldset>";
    }
    ?>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
