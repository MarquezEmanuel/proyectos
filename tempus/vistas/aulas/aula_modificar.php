<?php
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/ObjetoDatos.php';
include_once '../../modelos/aulas/Aula.php';
include_once '../../modelos/aulas/Aulas.php';

$idaula = $_POST['radioAulas'];
$aula = new Aula($idaula);

$aulas = new Aulas();

?>
<html>
<?php include_once '../estructura/encabezado.php';?>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>MODIFICAR AULA</h2>
<form action='../../Controladores/ManejadorAula.php' id='formModificarAula' name='formModificarAula' method='post'>
	<?php 
	if($aula->getIdaula()) {
	    echo "<fieldset>";
	    echo "<legend>Información básica</legend>";
        echo "<label for=''>Sector:</label>";
        if($aulas->getAulas()) {
            echo "<input type='text' id='txtSector' name='txtSector' value='{$aula->getSector()}' list='sectores' pattern='[A-Z]{1}' required>";
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
        } else {
            echo "<input id='' name='' type='text' value='{$aula->getSector()}' pattern='[A-Z]{1}' required>";
        }
        echo "<label for=''>Nombre:</label>";
        echo "<input id='' name='' type='text' value='{$aula->getNombre()}' pattern='' required>";
        echo "</fieldset>";
        echo "<input class='botonVerde' type='button' value='Regresar' onclick='history.back(-1)'>";
        echo "<input class='botonVerde' type='submit' id='btnModificarAula' name='btnModificarAula' value='Modificar'>";
    } else {
        echo "<fieldset>";
        echo "<legend>Resultado</legend>";
        echo "<h6 class='letraRoja letraCentrada'>No se ha obtenido la información de la mesa de examen a modificar</h6>";
        echo "</fieldset>";
    } 
    ?>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>