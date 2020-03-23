<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles Calificaciones Vigente</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $cliente = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(montoCalificacion as money),1) AS montoCalificacion2,convert(varchar,cast(montoCredito as money),1) AS montoCredito2 FROM [bd_sib].[dbo].[6calificacionesEspeciales] WHERE numeroCliente ='". $cliente ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$fechaAutorizacion = isset($row['fechaAutorizacion']) ? $row['fechaAutorizacion']->format('d/m/Y') : "";
				$fechaVencimiento = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
					$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Fecha de Operacion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $fechaOperacion.'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Plazo en Dias:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['plazoDias'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Numero de Certificado:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['numeroCertificado'].'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Concepto:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $row['concepto'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Moneda:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="'. $row['moneda'].'" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['sucursal'].'" readonly>
                        </div>  
						</div>	
						<div class="form-group row">
						<label for="sucursalCuenta" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['cuenta'].'" readonly>
                        </div>
						<label for="sucursalCuenta" class="col-sm-2 col-form-label">Digito:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['digito'].'" readonly>
                        </div>
						</div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['numeroCliente'].'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Fecha de Vencimiento:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $fechaVencimiento.'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Monto Depositado:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['montoDepositado2'].'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Monto Interes:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $row['montoInteres2'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Monto Pago:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['montoPago2'].'" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Transferible:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="'. $row['atm'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Renovacion Automatica:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['renovacionAutomatica'].'" readonly>
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


