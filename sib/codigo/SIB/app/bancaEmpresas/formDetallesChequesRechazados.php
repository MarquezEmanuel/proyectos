<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles Cheques Rechazados</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $cliente = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(importeCheque as money),1) AS importeCheque2, convert(varchar,cast(importeMulta as money),1) AS importeMulta2,
			convert(varchar,cast(importeDebitadoMulta as money),1) AS importeDebitadoMulta2 FROM [6chequesRechazados] WHERE codigoCliente = '". $cliente ."'ORDER BY fechaRechazo desc";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				$cantidad = 1;
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreCliente = utf8_encode($row['nombreCliente']);
				$fechaRechazo = isset($row['fechaRechazo']) ? $row['fechaRechazo']->format('d/m/Y') : "";
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Cheque Rechazado '.$cantidad.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['sucursal'].'/'.$row['numeroCuenta'].'-'.$row['digito'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Nombre Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$nombreCliente.'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Fecha de Rechazo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $fechaRechazo.'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Numero de Cheque:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $row['numeroCheque'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Importe de Cheque:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['importeCheque2'].'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Importe de Multa:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $row['importeMulta2'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Importe Debitado de la Multa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['importeDebitadoMulta2'].'" readonly>
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


