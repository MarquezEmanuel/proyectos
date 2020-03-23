<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */


$monto = $_POST['monto'];
$fecha = date("d/m/Y", strtotime($_POST['fecha']));
$fechaAnterior = $_POST['fechaAnterior'];


/* empieza la transaccion*/

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* PREPARA LOS UPDATE PARA EJECUTAR */

$sql = "UPDATE [SMVM] SET [saldo] = ".$monto." , [fechaActualizacion] = '".$fecha."' WHERE fechaActualizacion = '".$fechaAnterior."'";
$elimina = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
        

$html = '';
if ($elimina) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <h1><u>Cuenta modificada con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3> ';
    return $html;
	}
} else {
    $log = new Log();
    $log->writeLine("[Error al modificar Empleado en la BD][INFO: $elimina]");
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Modificar una Cuenta</h2></div>
						<h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>';
    return $html;
	}
}
?>

    <body>
        <div class="container">
		<div id="contenido">
            <div class="card-header">
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-12 text-center">
                        <?php echo $output = mensaje(); ?>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="smvm.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Actualizar SMVM</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formBuscarRTE.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Control Consumos</button></a>
                </div>
            </div>
            <br>
            <div class="form-row align-items-center mx-auto">
                <div class="col-lg-2 text-center">
                </div>
                <div class="col-lg-8 text-center">
                    <a href="formReporteMovDepRTE.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Control Anticipos</button></a>
                </div>
            </div>
                <br>
        </div>
    </body>
</html>






