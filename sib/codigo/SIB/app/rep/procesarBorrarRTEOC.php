<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* Obtiene los datos del formulario de modificacion */

$idTransaccion = $_POST['seleccionado'];


/* empieza la transaccion*/

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* PREPARA LOS UPDATE PARA EJECUTAR */

if ($idTransaccion) {
    $sql = "DELETE transaccion WHERE idTransaccion =" . $idTransaccion;
    $eliminaTransaccion = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    
    
    $tiene = "SELECT * FROM vinculados WHERE idTransaccion =" . $idTransaccion;
    $tieneVinculados = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $tiene);
    
    if($tieneVinculados){
        $vinculados = "DELETE vinculados WHERE idTransaccion =" . $idTransaccion;
        $eliminaVinculados = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $vinculados);
    }
    else{
        $eliminaVinculados = true;
    }    
} else {
    echo $mensaje = "No se obutvieron los datos del reporte";
}

$html = '';
if ($eliminaTransaccion && $eliminaVinculados) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <h1><u>Reporte eliminado con exito</u></h1>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
    return $html;
	}
} else {
    $log = new Log();
    $log->writeLine("[Error al borrar RTEOC en la BD][INFO: $eliminaTransaccion][INFO: $eliminaVinculados]");
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());
    function mensaje(){
    $html = '
                        <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Eliminar Reporte</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
';
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
                        <a href="formCrearRTEPF.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear RTE Plazo Fijo</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="formCrearRTEOC.php"> <button class="btn btn-lg btn-bsc btn-block" type="submit">Crear RTE Operación de Cambio</button></a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto text-center">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="formBuscarRTEPF.php">
                            <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar RTE Plazo Fijo</button>
                        </a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto text-center">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="formBuscarRTEOC.php">
                            <button class="btn btn-lg btn-bsc btn-block" type="submit">Buscar RTE Operación de Cambio</button>
                        </a>
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="../procesarLogout.php">
                            <button class="btn btn-lg btn-bsc btn-block" type="submit">Salir</button>
                        </a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
                <br>
        </div>
    </body>
</html>






