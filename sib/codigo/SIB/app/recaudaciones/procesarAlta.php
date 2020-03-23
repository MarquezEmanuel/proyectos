<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */

$sucursal = $_POST['sucursal'];
$cuenta = $_POST['cuenta'];
$digito = $_POST['digito'];


/* empieza la transaccion*/

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* PREPARA LOS UPDATE PARA EJECUTAR */

if ($sucursal && $cuenta && $digito) {
    $sql = "INSERT INTO [10cuentasASJ] ([sucursal],[cuenta],[digito]) VALUES ('".$sucursal."','".$cuenta."','".$digito."')";
    $elimina = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
} else {
    echo $mensaje = "No se obutvieron los datos de la cuenta";
}

$html = '';
if ($elimina) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <h1><u>Cuenta cargada con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3> ';
    return $html;
	}
} else {
    $log = new Log();
    $log->writeLine("[Error al cargar Empleado en la BD][INFO: $elimina]");
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Guardar la Cuenta</h2></div>
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
        </div>
    </body>
</html>






