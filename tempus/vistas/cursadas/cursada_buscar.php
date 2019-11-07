<?php 
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../lib/conf/ControlAcceso.php'; 
ControlAcceso::requierePermiso(PermisosSistema::CURSADAS);
$campo = "txtAsignatura";
$pattern = "[A-Za-záéíóúÁÉÍÓÚñÑ0123456789,. ]{0,255}";
$title = "Búsqueda por campo vacio o nombre de la asignatura (Se aceptan letras, números, puntos y/o comas)";
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<section id="main-content">
<article>
<div class="content">			
<h2>BUSCAR HORARIO DE CURSADA</h2>
<form action="../../controladores/ManejadorCursada.php" id="formBuscarCursada" name="formBuscarCursada" method="post" >
	<fieldset>
		<legend>Información básica</legend>
		<label for='<?=$campo;?>' class='centrado'>Nombre de asignatura:</label>
		<input type='text' id='<?=$campo;?>' name='<?=$campo;?>' pattern='<?=$pattern;?>' title='<?=$title;?>'>
	</fieldset>
	<input type="hidden" id="accion" name="accion" value="buscar">
	<input class="botonVerde" type="submit" id="btnBuscarCursada" name="btnBuscarCursada" value="Buscar">
</form>            	
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>