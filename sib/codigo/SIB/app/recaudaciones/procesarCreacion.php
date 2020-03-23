<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$legajo = $_SESSION['legajo'];
$usuario = $_SESSION['user'];

/* Obtiene los datos del formulario de creacion */

$fecha = $_POST['fecha'];
$moneda = $_POST['moneda'];
$operacion = $_POST['operacion'];
$causal = $_POST['causal'];
$tipoCuenta = $_POST['tipoCuenta'];
$cuenta = $_POST['cuenta'];
$sucursal = $_POST['sucursal'];
$digito = $_POST['digito'];
$importe = $_POST['importe'];
$documento = $_POST['documento'];
$razon = $_POST['razon'];
$oficina = $_POST['oficina'];

$fecha = date("d-m-Y", strtotime($fecha));
/* empieza la transaccion*/

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* PREPARA LOS UPDATE PARA EJECUTAR */

if ($fecha && $moneda && $operacion && $causal && $tipoCuenta && $cuenta && $sucursal && $digito && $importe && $razon && $oficina) {
    $sql = "
	INSERT INTO [bd_sib].[dbo].[10pmcred]
           ([fecha]
           ,[moneda]
           ,[tipo]
           ,[causal]
           ,[tipoCuenta]
           ,[numeroCuenta]
           ,[sucursal]
           ,[digito]
           ,[importe]
           ,[documento]
           ,[razon]
           ,[usuario]
           ,[legajo]
		   ,[oficina])
     VALUES
           ('".$fecha."'
           ,".$moneda."
           ,'".$operacion."'
           ,".$causal."
           ,'".$tipoCuenta."'
           ,".$cuenta."
           ,".$sucursal."
           ,".$digito."
           ,".$importe."
           ,".$documento."
           ,'".$razon."'
           ,'".$usuario."'
           ,'".$legajo."'
		   ,".$oficina.")
	";
    $crea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
} else {
    echo $mensaje = "<div class=alert-danger><h2 class=text-center>No se obtuvieron los datos necesarios para la creacion de PMCRED - PMDEB</h2></div>";
}

$html = '';
if ($crea) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <h1><u>Operacion cargada con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3> ';
    return $html;
	}
} else {
    $log = new Log();
    $log->writeLine("[Error al cargar PMDEB - PMCRED en la BD][INFO: $crea]");
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
	echo $sql;
    function mensaje(){
    $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Crear la operacion</h2></div>
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
                        <a href="creacion.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Creacion PMCRED o PMDEB</button></a>
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
        </div>
    </body>
</html>






