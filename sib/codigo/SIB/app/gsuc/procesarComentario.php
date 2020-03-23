<?php
include_once '../conf/BDConexion.php';

$id = $_POST['id'];
$legajo = $_POST['legajo'];
$comentario = $_POST['comentario'];

$sql = "UPDATE [3chequerasPendientesEntrega] SET [legajo] = '$legajo', [comentario] = '$comentario' WHERE id= " . $id;


$consulta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
$html = '';
if ($consulta) {
    sqlsrv_commit(BDConexion::getInstancia()->getConexion());
    function mensaje() {
        $html = '
                    <h4><u>Comentario guardado con exito</u></h4>
                    <br>
                    <a href="chequerasPendientes.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>';
        return $html;
    }

} else {
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                    <div class=alert-danger><h4 class=text-center>Ocurrio Un Error Al Guardar Comentario</h4></div>
                    <h4><u>Revise su conexion.</u></h4>
                    <br>
                    <a href="chequerasPendientes.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>';
        return $html;
    }

}
require_once "./header.php";
?>

<div class="container">
    <div class="card-header">
        <h3 class="text-center"><u>Chequeras Pendientes de Entrega</u></h3>
        <div id="centro" class="container">
            <div class="container">
                <br>
                <div class="form-row align-items-center mx-auto">
                    <div class="col-lg-12 text-center">
                        <?php echo $output = mensaje(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
