<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../modelos/aulas/Aula.php';
include_once '../../modelos/aulas/Aulas.php';

$aulas = new Aulas();

?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/aulas/aula_buscar.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>BUSCAR AULA</h2>
<form action='../../Controladores/ManejadorAula.php' id='formBuscarAula' name='formBuscarAula' method='post'>
    <fieldset>
    <legend>Información básica</legend>
    <?php 
    if ($aulas->getAulas()) {
        echo"<table id='tablaBuscarAulas' class='display' style='width: 80%;'>
        <thead> <tr>
        <th></th> <th>Sector</th> <th>Nombre</th>
        </tr> </thead>
        <tbody>";
        foreach ($aulas->getAulas() as $aula) {
            echo "<tr>
            <td><input type='radio' id='radioAulas' name='radioAulas' value='{$aula->getIdaula()}'></td>
            <td>{$aula->getSector()}</td>
            <td>{$aula->getNombre()}</td>
            </tr>";
        }
        echo "</tbody>
        </table>";
    } else {
        
    }
    ?>
    </fieldset>
    <input type='hidden' id='accion' name='accion' value='informe'>
    <input class='botonRojo' type='submit' id='' name='' value='Borrar'>
    <input class='botonVerde' type='submit' id='' name='' value='Informe'>
    <button class='botonVerde' type='submit' id='' name='' formaction='aula_modificar.php'> Modificar </button>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>