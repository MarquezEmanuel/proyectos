<?php

require_once '../conf/Constants.php';
require_once '../conf/Log.php';

/* ESTABLECE EL DIA Y LA HORA PARA ADJUNTAR AL NOMBRE DEL ZIP */
date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y_m_d-His");

if (isset($_POST['cbCorreos'])) {
	$contador = 0;
    $correos = $_POST['cbCorreos'];
    foreach ($correos as $correo) {
		$nombre = "{$correo}";
		$url = URL_ConstanciaSaldo . "\\" . $nombre;
		unlink($url);
		$contador++;
	}
}

require_once "./header.php";
?>

<div class="card-header">
	<div id="contenido">
        <div class="center">
            <h3 class="text-center"><u>Constancia de saldos</u></h3>
        </div>
		<br>
            <div class='alert alert-success text-center' role='alert'> Se eliminaron <?= $contador ?> con exito </div>
		<br>
	</div>
		<div class="text-center">
        <a href="eliminarSaldos.php"><input type="button" class="btn btn-dark text-center" value="Volver"></a>
		</div>
	</div>
</body>
</html>
