<?php
include_once '../conf/BDConexion.php';

$id = $_POST['id'];
$legajo = $_POST['legajo'];
$comentario = $_POST['comentario'];
$fecha = $_POST['fecha'];


$sql2 = "SELECT * FROM [bd_sib].[dbo].[3comentariosCuentacorrentistas] WHERE id LIKE '$id'";

$consulta2 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql2);
$html = '';
$tiene = sqlsrv_has_rows($consulta2);
if ($tiene != 0) {
    $sql = "UPDATE [bd_sib].[dbo].[3comentariosCuentacorrentistas] SET [legajo] = '$legajo', [comentario] = '$comentario', [fechaActualizacion] = '$fecha' WHERE id LIKE '$id'";
	$consulta = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    function mensaje() {
        $html = '
                    <h4><u>Comentario guardado con exito</u></h4>
                    <br>
                    <a href="centralCuentacorrentista.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>';
        return $html;
    }

} else {
	$sql2 = "INSERT INTO [bd_sib].[dbo].[3comentariosCuentacorrentistas] (id,legajo,comentario,fechaActualizacion) VALUES
	( ".$id.",
	'$legajo',
	'$comentario',
	'$fecha'
	)";
	$consulta2 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql2);
	if($consulta2){

		function mensaje() {
        $html = '
                    <h4><u>Comentario guardado con exito</u></h4>
                    <br>
                    <a href="centralCuentacorrentista.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>';
        return $html;
		}
	}else {
	echo $sql2;
    sqlsrv_rollback(BDConexion::getInstancia()->getConexion());

    function mensaje() {
        $html = '
                    <div class=alert-danger><h4 class=text-center>Ocurrio Un Error Al Guardar Comentario</h4></div>
                    <h4><u>Revise su conexion.</u></h4>
                    <br>
                    <a href="centralCuentacorrentista.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>';
        return $html;
    }
	}
}
require_once "./header.php";
?>

<div class="container">
    <div class="card-header">
        <h3 class="text-center"><u>Central de cuentacorrentistas inhabilitados</u></h3>
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
