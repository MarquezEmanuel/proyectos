<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles Plafond</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $cliente = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(limite as money),1) AS limite2,convert(varchar,cast(valorUtilizado as money),1) AS valorUtilizado2,convert(varchar,cast(valorUtilizadoTotal as money),1) AS valorUtilizadoTotal2 FROM [6sublimites]
                                    WHERE codigoCliente = '". $cliente ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreLimite = utf8_encode($row['nombreLimite']);
				$fechaVencimiento = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
				$fechaAutorizacion = isset($row['fechaAutorizacion']) ? $row['fechaAutorizacion']->format('d/m/Y') : "";
					$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Codigo Limite:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['codigoLimite'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Nombre Limite:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$nombreLimite.'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Limite:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['limite2'].'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Valor Utilizado:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $row['valorUtilizado2'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Valor Utilizado Total:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="'. $row['valorUtilizadoTotal2'].'" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Fecha Autorizacion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$fechaAutorizacion.'" readonly>
                        </div>  
						</div>	
						<div class="form-group row">
						<label for="sucursalCuenta" class="col-sm-2 col-form-label">Fecha Vencimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $fechaVencimiento.'" readonly>
                        </div>
						</div>
						</fieldset>
						</div>
					';
				}
			}
                ?>
                <div class="container">
                    <br>
                    <?php echo $html;?>
                </div>                    
				<br>
                <div class="text-center"><a href="<?= $_SERVER["HTTP_REFERER"] ?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a></div> 
            </div>
        </div>
    </div>
</div>
</body>
</html>


