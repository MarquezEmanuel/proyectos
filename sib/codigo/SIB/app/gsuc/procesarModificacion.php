<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */


$id = $_POST['id'];
$sucursal = $_POST['sucursal'];
$cuenta = $_POST['cuenta'];
$digito = $_POST['digito'];



/* PREPARA LOS UPDATE PARA EJECUTAR */


if ($id) {
    $sql = "UPDATE [3cuentasConstanciaSaldo] SET [sucursal] = ".$sucursal." , [cuenta] = ".$cuenta." , [digito] = ".$digito." WHERE id =" . $id;
    $elimina = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql); 
        
} else {
    echo $mensaje = "No se obutvieron los datos de la cuenta";
}

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
		<div id="contenido2">
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
                        <a href="constanciaSaldos.php"> <button class="btn btn-lg btn-bsc btn-block btn-dark" type="submit">Volver</button></a>
                    </div>
                </div>
                <br>
        </div>
		</div>
    </body>
</html>






