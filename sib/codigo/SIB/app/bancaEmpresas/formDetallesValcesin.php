<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles Valcesin</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $cliente = $_POST['seleccionado'];
            $query = "SELECT *,convert(varchar,cast(importe as money),1) AS importe2 FROM [6valcesin]
                                    WHERE documento = '". $cliente ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				$cantidad = 1;
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $nombreBanco = utf8_encode($row['nombreBanco']);
				$nombreFirmante = utf8_encode($row['nombreFirmante']);
				$fechaPresentacionCamara = isset($row['fechaPresentacionCamara']) ? $row['fechaPresentacionCamara']->format('d/m/Y') : "";
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Valcesin '.$cantidad.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Tipo de Movimiento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['tipoMovimiento'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Tipo de Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['tipoCuenta'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Numero de Cheque:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['numeroCheque'].'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Fecha de Presentacion a Camara:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $fechaPresentacionCamara.'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Importe:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['importe2'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Nombre de Banco:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$nombreBanco.'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Codigo Postal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['codigoPostal'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Documento Firmante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['documentoFirmante'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Nombre de Firmante:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $nombreFirmante.'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Numero de Prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['numeroPrestamo'].'" readonly>
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


