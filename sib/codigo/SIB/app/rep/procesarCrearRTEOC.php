<?php

include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

/* empieza la transaccion */

sqlsrv_begin_transaction(BDConexion::getInstancia()->getConexion());

/* Carga Datos Comunes */

$fecha = utf8_decode($_POST['fecha']);
$provincia = utf8_decode($_POST['provincia']);
$localidad = utf8_decode($_POST['localidad']);
$calle = utf8_decode($_POST['calle']);
$numero = $_POST['numero'];
$operacion = utf8_decode($_POST['operacion']);
$transaccion = utf8_decode($_POST['transaccion']);
$moneda = utf8_decode($_POST['moneda']);
$monto = $_POST['monto'];
$equivalente = $_POST['equivalente'];
$sql = "INSERT INTO transaccion (fecha, provincia, localidad, calle, numero, operacion, transaccion, moneda, monto, equivalente) "
        . "VALUES ('$fecha','$provincia','$localidad','$calle',$numero,'$operacion','$transaccion','$moneda',$monto,$equivalente)";
$crea = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);


/* Carga Personas Juridicas */

$fisica = $juridica = true;


if (isset($_POST['operadorJuridica'])) {
    $operador = $_POST['operadorJuridica'];
    $identificacion = $_POST['identificacionJuridica'];
    $cuit = $_POST['cuitJuridica'];
    $denominacion = $_POST['denominacionJuridica'];
    $persona = utf8_decode("Persona Jurídica");
    $cont = count($operador);
    $busca = "SELECT * FROM transaccion WHERE fecha LIKE '{$fecha}' AND provincia LIKE '{$provincia}' AND localidad LIKE '{$localidad}' AND calle LIKE '{$calle}'"
            . "AND numero = {$numero} AND operacion LIKE '{$operacion}' AND transaccion LIKE '{$transaccion}' AND moneda LIKE '{$moneda}' AND monto = {$monto} AND equivalente = {$equivalente}";
    $esta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $busca);
    if ($esta) {
        $dale = sqlsrv_has_rows($esta);
        if ($dale) {
            while ($row = sqlsrv_fetch_array($esta, SQLSRV_FETCH_ASSOC)) {
                $idTransaccion = $row['idTransaccion'];
            }
        } else {
            $idTransaccion = 'null';
        }
    } else {
        $idTransaccion = 'null';
    }
    //$existe = sqlsrv_fetch_array($esta);
    //$idTransaccion = $esta["id"];
    for ($i = 0; $i < $cont; ++$i) {
        $ope = utf8_decode($operador[$i]);
        $iden = utf8_decode($identificacion[$i]);
        $deno = utf8_decode($denominacion[$i]);
        $sql = "INSERT INTO vinculado (operador, identificacion, cuit, tipo, apellidoDenominacion, idTransaccion) "
                . "VALUES('$ope','$iden',$cuit[$i],'$persona','$deno',$idTransaccion)";
        $juridica = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    }
}


/* Carga Personas Fisicas */


if (isset($_POST['operador'])) {
    $operador = $_POST['operador'];
    $identificacion = $_POST['identificacion'];
    $cuit = $_POST['cuit'];
    $apellido = $_POST['apellidos'];
    $nombres = $_POST['nombres'];
    $tipo = $_POST['tipo'];
    $persona = utf8_decode("Persona Física");
    $documento = $_POST['documento'];
    $cont = count($operador);
    $busca = "SELECT * FROM transaccion WHERE fecha LIKE '{$fecha}' AND provincia LIKE '{$provincia}' AND localidad LIKE '{$localidad}' AND calle LIKE '{$calle}'"
            . "AND numero = {$numero} AND operacion LIKE '{$operacion}' AND transaccion LIKE '{$transaccion}' AND moneda LIKE '{$moneda}' AND monto = {$monto} AND equivalente = {$equivalente}";
    $esta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $busca);
    if ($esta) {
        $dale = sqlsrv_has_rows($esta);
        if ($dale) {
            while ($row = sqlsrv_fetch_array($esta, SQLSRV_FETCH_ASSOC)) {
                $idTransaccion = $row['idTransaccion'];
            }
        } else {
            $idCar = 'null';
        }
    } else {
        $idCar = 'null';
    }
    for ($i = 0; $i < $cont; ++$i) {
        $ope = utf8_decode($operador[$i]);
        $iden = utf8_decode($identificacion[$i]);
        $ape = utf8_decode($apellido[$i]);
        $nom = utf8_decode($nombres[$i]);
        $ti = utf8_decode($tipo[$i]);
        $sql = "INSERT INTO vinculado (operador, identificacion, cuit, tipo, apellidoDenominacion, nombre, tipoDocumento, numeroDocumento, idTransaccion) "
                . "VALUES('$ope','$iden',$cuit[$i],'$persona','$ape','$nom','$ti',$documento[$i],$idTransaccion)";
        $fisica = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    }
}


$html = '';
if ($fisica && $juridica && $crea) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                    <h1><u>Guardado con exito</u></h1>
					<h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
                    
';
        return $html;
    }

} else {
    $log = new Log();
    $log->writeLine("[Error al crear transaccion o vinculado en la BD][QUERY: $sql]");
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                    <div class=alert-danger><h2 class=text-center>Ocurrio Un Error Al Guardar</h2></div>
                    <h3 class="h3 mb-3 font-weight-normal text-blue">Seleccione una opcion:</h3>
	';
        return $html;
    }

}



/* INICIALIZA LA SESION */
session_start();

require_once './menuReportes.php';
?>
    <body>
        <div class="container">
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
        </div>
    </body>
</html>
