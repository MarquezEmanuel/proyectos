<?php 
include_once '../../lib/conf/ControlAcceso.php'; 
include_once '../../lib/conf/PermisosSistema.php';
ControlAcceso::requierePermiso(PermisosSistema::CURSADAS);
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type="text/javascript" src="../../js/cursadas/cursada_seleccionar.js"></script>
<section id="main-content">
<article>
<div id="content" class="content">
<h2>IMPORTAR HORARIOS DE CURSADA</h2>
<form action="cursada_importar.php" enctype="multipart/form-data" id="formSeleccionarCursadas" name="formSeleccionarCursadas" method="post" >
	<fieldset>
		<legend>Selección de archivo</legend>
		<label for="fileCursadas" class="centrado">Archivo:</label>
		<input type="file" id="fileCursadas" name="fileCursadas" accept=".csv">	
	</fieldset>
	<input class="botonVerde" type="submit" id="btnImportarCursadas" name="btnImportarCursadas" value="Importar" title="Importar archivo seleccionado">
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
