<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();

$idCuenta = $_POST['seleccionado'];
$queryCorreo = "SELECT * FROM [3chequerasPendientesEntrega] WHERE id= {$idCuenta}";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCorreo);

if (!$idCuenta || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la informaciÃ³n de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
				if($cuen['legajo'] == NULL){
				$html = '<input type="text" id="" name="" class="form-control mb-2" value=" '.$_SESSION['legajo'].' " readonly>';
				} else{
					$html = '<input type="text" id="" name="" class="form-control mb-2" value="'.$cuen['legajo'].'" readonly>';
				}
                ?>
				<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Chequeras Pendientes de Entrega</u></h3>
		<br>
        <div id="centro" class="container">
            <form action="procesarComentario.php" method="post">
                <div class="container">
				<input type="hidden" id="id" name="id" value="<?= $cuen['id'] ?>">
				<input type="hidden" id="legajo" name="legajo" value="<?= $_SESSION['legajo'] ?>">
                    <div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Legajo:</label>
                        <div class="col">
                            <?= $html; ?>
                        </div>  
						</div>
						<div class="form-group row">						
                        <label for="comentario" class="col-sm-2 col-form-label">Comentario:</label>
                        <div class="col" >
                            <textarea type="input" class="form-control mb-2" id="comentario" name="comentario"><?= $cuen['comentario']; }?></textarea>
                        </div>
                    </div>                    
                    <br>
                    <input type="submit" class="btn btn-dark" id="guardar" name="guardar" value="Guardar Comentario">
                        &nbsp;
                        <a href="<?=$_SERVER["HTTP_REFERER"]?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
			</div>
            </form>
        </div>
    </div>
</div>
</body>
</html>