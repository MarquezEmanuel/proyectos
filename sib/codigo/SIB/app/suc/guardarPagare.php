<?php
include_once '../conf/BDConexion.php';

$comentario = $_POST['comentario'];
$idCuenta = $_POST['idCuenta'];


$sql = "UPDATE [3crucePPMAPySAV] SET comentario = '$comentario' WHERE id = " . $idCuenta;

$consulta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
$html = '';
if ($consulta) {
    function mensaje() {
        $html = '
            <h4><u>Comentario guardado con exito</u></h4>
            <br>
            <h4 class="text-center">Seleccione una opcion:</h4>';
        return $html;
    }

} else {
    $log = new Log();
    $log->writeLine("[Error al guardar comentario de pagare no cargados en SAV en forma manual][QUERY: $sql]");
    function mensaje() {
        $html = '
            <div class=alert-danger><h4 class=text-center>Ocurrio Un Error Al Guardar Comentario</h4></div>
            <h4><u>Revise su conexion.</u></h4>
            <br>
            <h4 class="text-center">Seleccione una opcion:</h4>';
        return $html;
    }

}
require_once "./menuSucursal.php";
?>

<div class="container">
    <div class="card-header">
        <h3 class="text-center"><u>Pagare no cargados en SAV</u></h3>
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
                        <a href="formPagaresNoSAV.php"><input type="button" class="btn btn-lg btn-dark btn-block" id="" name="" value="Ver Pagare no cargado en SAV de la fecha"></a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="formBuscarPagare.php"><input type="button" class="btn btn-lg btn-dark btn-block" id="" name="" value="Buscar Pagare no cargados en SAV"></a>
                    </div>
                    <div class="col-lg-2 text-center">
                    </div>
                </div>
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-2 text-center">
                    </div>
                    <div class="col-lg-8 text-center">
                        <a href="inicioSucursal.php"><input type="button" class="btn btn-lg btn-dark btn-block" id="" name="" value="Salir"></a>
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

