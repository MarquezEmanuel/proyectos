<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles Saldos a Favor</u></h3>
        <div id="centro" class="container">
            <?php
            /* Primes mes anterior*/
			
            $cliente = $_POST['seleccionado'];
            $query = "select DISTINCT *,convert(varchar,cast(saldoActual as money),1) AS saldoActual2, convert(varchar,cast(saldoAnterior as money),1) AS saldoAnterior2,
			convert(varchar,cast(saldoActualDolar as money),1) AS saldoActualDolar2, convert(varchar,cast(saldoAnteriorDolar as money),1) AS saldoAnteriorDolar2
			from openquery([BSCBASES3], 'SELECT ''MC'' marca, 
                                                                           SAL.cuenta_nume cuenta, 
                                                                           SAL.ope_esta estado, 
                                                                           SAL.liqui_meto MTU, 
                                                                           SAL.actualcierrefecha cierre, 
                                                                           SAL.pesos_actual_saldo saldoActual, 
                                                                           SAL.pesos_ante_saldo saldoAnterior, 
                                                                           SAL.dolar_actual_saldo saldoActualDolar, 
                                                                           SAL.dolar_ante_saldo SaldoAnteriorDolar
                                                              FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                                              INNER JOIN (SELECT DISTINCT cuenta_nume cuenta
                                                                                   FROM [SmartOpen].[dbo].[CredenSaldos]
                                                                                   WHERE (pesos_actual_saldo < 0 OR dolar_actual_saldo < 0) AND 
                                                                                              actualCierreFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE())-1,0))) FAV ON FAV.cuenta = SAL.cuenta_nume
                                                              WHERE (SAL.pesos_actual_saldo < 0 OR SAL.dolar_actual_saldo < 0) AND 
                                                                    SAL.actualCierreFecha >= DATEADD(MM, -12, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))
                                                              UNION ALL
                                                              SELECT ''VISA'' marca, 
                                                                           SA.cuenta, 
                                                                           so.cuentaesta estado, 
                                                                           liqModeCodi MTU, 
                                                                           SA.actualcierreFecha cierre, 
                                                                           SA.actualpesossaldo saldoActual, 
                                                                           SA.anteTotalSaldo saldoAnterior, 
                                                                           SA.actualDolarImpo saldoActualDola, 
                                                                           SA.antedolarsaldo SaldoAnteriorDolar
                                                              FROM [SmartOpen].[dbo].[visasaldos] SA 
                                                              INNER JOIN (SELECT DISTINCT SA.cuenta
                                                                                   FROM [SmartOpen].[dbo].[visasaldos] SA
                                                                                   WHERE (SA.actualpesossaldo < 0 or SA.actualDolarImpo < 0) AND 
                                                                                              SA.actualCierreFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE())-1,0))) FAV ON FAV.cuenta = SA.cuenta
                                                              INNER JOIN [SmartOpen].[dbo].[visasocios] SO on SA.cuenta = SO.cuenta
                                                              WHERE (actualpesossaldo < 0 or actualDolarImpo < 0) AND actualCierreFecha >= DATEADD(MM, -12, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))')    
															  WHERE cuenta = ". $cliente;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$cierre = isset($row['cierre']) ? $row['cierre']->format('d/m/Y') : "";
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Marca:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['marca'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Cuenta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['cuenta'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Estado:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['estado'].'" readonly>
                        </div>
						<label for="transaccion" class="col-sm-2 col-form-label">MTU:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['MTU'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Cierre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $cierre.'" readonly>
                        </div>
						<label for="transaccion" class="col-sm-2 col-form-label">Saldo Actual:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['saldoActual2'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Saldo Anterior:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['saldoAnterior2'].'" readonly>
                        </div>
						<label for="transaccion" class="col-sm-2 col-form-label">Saldo Actual Dolar:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['saldoActualDolar2'].'" readonly>
                        </div>
                        </div>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Saldo Anterior Dolar:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['SaldoAnteriorDolar2'].'" readonly>
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


