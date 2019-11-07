<?php 
include_once '../../lib/conf/ControlAcceso.php'; 
include_once '../../lib/conf/PermisosSistema.php';
ControlAcceso::requierePermiso(PermisosSistema::CURSADAS);
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type="text/javascript" src="../../js/mesas/mesa_seleccionar.js"></script>
<section id="main-content">
<article>
<div id="content" class="content">
<h2>IMPORTAR MESAS DE EXAMEN</h2>
<form action="mesa_importar.php" enctype="multipart/form-data" id="formSeleccionarMesas" name="formSeleccionarMesas" method="post" >
	<fieldset>
		<legend>Selección de archivo</legend>
		<label for="fileMesas" class="centrado">Archivo:</label>
		<input type="file" id="fileMesas" name="fileMesas" accept=".csv" title="Seleccionar archivo csv">
	</fieldset>
	<input type="hidden" id="accion" name="accion" value="seleccionar">
	<input class="botonVerde" type="submit" id="btnImportarMesas" name="btnImportarMesas" value="Importar" title="Importar archivo seleccionado">
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>