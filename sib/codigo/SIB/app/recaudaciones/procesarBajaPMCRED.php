<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */

$id = $_POST['seleccionado'];


/* empieza la transaccion*/

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* PREPARA LOS UPDATE PARA EJECUTAR */

if ($id) {
    $sql = "DELETE [10pmcred] WHERE id =" . $id;
    $elimina = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
        
} else {
    echo $mensaje = "No se obutvieron los datos del usuario";
}

$html = '';
if ($elimina) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <h1><u>Operacion eliminada con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3> ';
    return $html;
	}
} else {
    $log = new Log();
    $log->writeLine("[Error al borrar Empleado en la BD][INFO: $elimina]");
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Eliminar la operacion</h2></div>
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
                        <a href="cuentasASJ.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Alta/Baja de Cuentas ASJ</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="saldosASJ.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Consulta de Saldos Cuentas ASJ</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="inicio2.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Clientes Fallecidos con Cuenta ANSES</button></a>
                    </div>
                </div>
				<br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="creacion.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Gestionar PMCRED o PMDEB</button></a>
                    </div>
                </div>
				<br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="generacion.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Generacion archivos PMCRED o PMDEB</button></a>
                    </div>
                </div>
                <br>
        </div>
    </body>
</html>






