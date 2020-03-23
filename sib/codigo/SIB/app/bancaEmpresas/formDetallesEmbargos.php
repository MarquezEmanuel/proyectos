<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles Embargos</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $cliente = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [6embargosVigentes]
                                    WHERE codigoCliente = '". $cliente ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				$cantidad = 1;
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreCliente = utf8_encode($row['nombreCliente']);
				$fechaAlta = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Embargo '.$cantidad.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Codigo Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['codigoCliente'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Nombre Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$nombreCliente.'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Fecha Alta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $fechaAlta.'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Monto:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $row['monto2'].'" readonly>
                        </div>
                        </div>
						</fieldset>
						</div>
					';
					$cantidad++;
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


