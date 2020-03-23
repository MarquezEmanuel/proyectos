<?php
include_once '../conf/BDConexion.php';

$comentario = $_POST['comentario'];
$idCanje = $_POST['idCanje'];
$tratado = $_POST['tratado'];
$numeroTratado;

if($tratado === "TRATADO"){
    $numeroTratado = 1;
}else{
    $numeroTratado = 0;
}

$sql = "UPDATE [3canjeInterno] SET comentario = '$comentario', tratado = $numeroTratado WHERE id = " . $idCanje;

$consulta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
$html = '';
if ($consulta) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                    <h4><u>Comentario guardado con exito</u></h4>
                    <br>
                    <h4 class="text-center">Seleccione una opcion:</h4>';
        return $html;
    }

} else {
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                    <div class=alert-danger><h4 class=text-center>Ocurrio Un Error Al Guardar Comentario</h4></div>
                    <h4><u>Revise su conexion.</u></h4>
                    <br>
                    <h4 class="text-center">Seleccione una opcion:</h4>';
        return $html;
    }

}
require_once "./header.php";
?>

<div class="container">
    <div class="card-header">
        <h3 class="text-center"><u>Detalles de cheques con canje interno</u></h3>
        <div id="centro" class="container">
            <div class="container">
                <br>
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
                        <a href="canjeInterno.php"><input type="button" class="btn btn-lg btn-dark btn-block" id="" name="" value="Ver Cheques con canje interno de la fecha"></a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="buscarCanjeInterno.php"><input type="button" class="btn btn-lg btn-dark btn-block" id="" name="" value="Buscar Cheques con canje interno"></a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="reportesTablas.php"><input type="button" class="btn btn-lg btn-dark btn-block" id="" name="" value="Salir"></a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

