<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
date_default_timezone_set('America/Argentina/Buenos_Aires');
$idCuenta = $_POST['seleccionado'];
if (substr($idCuenta,0,1) == 0){
	$idCuenta = substr($idCuenta,1);
}
$queryCorreo = "SELECT * FROM [bd_sib].[dbo].[3comentariosCuentacorrentistas] WHERE id LIKE '{$idCuenta}'";
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $queryCorreo);

if (!$idCuenta) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la informaciÃ³n de la cuenta </div>';
            } else {
                $cuen = sqlsrv_fetch_array($result);
				$tiene = sqlsrv_has_rows($result);
                /* Se controla que las fechas no se encuentren vacias antes de convertir el formato */
				if($tiene == 0){
				$html = '<input type="text" id="" name="" class="form-control mb-2" value=" '.$_SESSION['legajo'].' " readonly>';
				$html2 = '<input type="text" id="fecha" name="fecha" class="form-control mb-2" value=" '.date("d/m/Y").' " readonly>';
				} else{
					$idCuenta = $cuen['id'];
					$fecha = isset($cuen['fechaActualizacion']) ? $cuen['fechaActualizacion']->format('d/m/Y') : "";
					$html = '<input type="text" id="" name="" class="form-control mb-2" value="'.$cuen['legajo'].'" readonly>';
					$html2 = '<input type="text" id="fecha" name="fecha" class="form-control mb-2" value="'.$fecha.'" readonly>';
				}
                ?>
				<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Central de cuentacorrentistas inhabilitados</u></h3>
		<br>
        <div id="centro" class="container">
            <form action="procesarComentarioCuentacorrentista.php" method="post">
                <div class="container">
				<input type="hidden" id="id" name="id" value="<?= $idCuenta ?>">
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
					<div class="form-group row">
                        <label for="causal" class="col-sm-2 col-form-label">Fecha:</label>
                        <div class="col">
                            <?= $html2; ?>
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