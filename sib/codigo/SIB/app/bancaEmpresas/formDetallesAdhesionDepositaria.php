<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Detalles Adhesion Depositaria</u></h3>
        <div id="centro" class="container">
            <?php
            /* Primes mes anterior*/
			
			$primerDia = date('Y-m-d', mktime(0,0,0, date("m",(mktime(0,0,0,date("m")-1+1,1,date("Y"))-1)), 1, date("Y",(mktime(0,0,0,date("m")-1+1,1,date("Y"))-1))));
			$ultimoDia = date("Y-m-d",(mktime(0,0,0,date("m")-1+1,1,date("Y"))-1));
            $cliente = $_POST['seleccionado'];
            $query = "SELECT sum(nroMovimientos) movimientos, convert(varchar,cast(sum(sumatoria) as money),1) AS valor FROM [bd_sib].[dbo].[adhesionDepositariaHistorica]
                                    WHERE codigoCliente = '". $cliente ."' AND fechaTransaccion between '". $primerDia ."' and '". $ultimoDia ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Fecha: '.$primerDia.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Total movimientos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['movimientos'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Valor Mensual:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['valor'].'" readonly>
                        </div>
                        </div>
						</fieldset>
						</div>
					';
				}
			}
			
			/* Segundo mes anterior*/
			
			$primerDia = date('Y-m-d', mktime(0,0,0, date("m",(mktime(0,0,0,date("m")-2+1,1,date("Y"))-1)), 1, date("Y",(mktime(0,0,0,date("m")-2+1,1,date("Y"))-1))));
			$ultimoDia = date("Y-m-d",(mktime(0,0,0,date("m")-2+1,1,date("Y"))-1));
            $query = "SELECT sum(nroMovimientos) movimientos, convert(varchar,cast(sum(sumatoria) as money),1) AS valor FROM [bd_sib].[dbo].[adhesionDepositariaHistorica]
                                    WHERE codigoCliente = '". $cliente ."' AND fechaTransaccion between '". $primerDia ."' and '". $ultimoDia ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Fecha: '.$primerDia.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Total movimientos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['movimientos'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Valor Mensual:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['valor'].'" readonly>
                        </div>
                        </div>
						</fieldset>
						</div>
					';
				}
			}
			
			/* Tercer mes anterior*/
			
			$primerDia = date('Y-m-d', mktime(0,0,0, date("m",(mktime(0,0,0,date("m")-3+1,1,date("Y"))-1)), 1, date("Y",(mktime(0,0,0,date("m")-3+1,1,date("Y"))-1))));
			$ultimoDia = date("Y-m-d",(mktime(0,0,0,date("m")-3+1,1,date("Y"))-1));
            $query = "SELECT sum(nroMovimientos) movimientos, convert(varchar,cast(sum(sumatoria) as money),1) AS valor FROM [bd_sib].[dbo].[adhesionDepositariaHistorica]
                                    WHERE codigoCliente = '". $cliente ."' AND fechaTransaccion between '". $primerDia ."' and '". $ultimoDia ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Fecha: '.$primerDia.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Total movimientos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['movimientos'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Valor Mensual:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['valor'].'" readonly>
                        </div>
                        </div>
						</fieldset>
						</div>
					';
				}
			}
			
			/* Cuarto mes anterior*/
			
			$primerDia = date('Y-m-d', mktime(0,0,0, date("m",(mktime(0,0,0,date("m")-4+1,1,date("Y"))-1)), 1, date("Y",(mktime(0,0,0,date("m")-4+1,1,date("Y"))-1))));
			$ultimoDia = date("Y-m-d",(mktime(0,0,0,date("m")-4+1,1,date("Y"))-1));
            $query = "SELECT sum(nroMovimientos) movimientos, convert(varchar,cast(sum(sumatoria) as money),1) AS valor FROM [bd_sib].[dbo].[adhesionDepositariaHistorica]
                                    WHERE codigoCliente = '". $cliente ."' AND fechaTransaccion between '". $primerDia ."' and '". $ultimoDia ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Fecha: '.$primerDia.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Total movimientos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['movimientos'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Valor Mensual:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['valor'].'" readonly>
                        </div>
                        </div>
						</fieldset>
						</div>
					';
				}
			}
			
			/* Quinto mes anterior*/
			
			$primerDia = date('Y-m-d', mktime(0,0,0, date("m",(mktime(0,0,0,date("m")-5+1,1,date("Y"))-1)), 1, date("Y",(mktime(0,0,0,date("m")-5+1,1,date("Y"))-1))));
			$ultimoDia = date("Y-m-d",(mktime(0,0,0,date("m")-5+1,1,date("Y"))-1));
            $query = "SELECT sum(nroMovimientos) movimientos, convert(varchar,cast(sum(sumatoria) as money),1) AS valor FROM [bd_sib].[dbo].[adhesionDepositariaHistorica]
                                    WHERE codigoCliente = '". $cliente ."' AND fechaTransaccion between '". $primerDia ."' and '". $ultimoDia ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Fecha: '.$primerDia.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Total movimientos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['movimientos'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Valor Mensual:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['valor'].'" readonly>
                        </div>
                        </div>
						</fieldset>
						</div>
					';
				}
			}
			
			/* Sexo mes anterior*/
			
			$primerDia = date('Y-m-d', mktime(0,0,0, date("m",(mktime(0,0,0,date("m")-6+1,1,date("Y"))-1)), 1, date("Y",(mktime(0,0,0,date("m")-6+1,1,date("Y"))-1))));
			$ultimoDia = date("Y-m-d",(mktime(0,0,0,date("m")-6+1,1,date("Y"))-1));
            $query = "SELECT sum(nroMovimientos) movimientos, convert(varchar,cast(sum(sumatoria) as money),1) AS valor FROM [bd_sib].[dbo].[adhesionDepositariaHistorica]
                                    WHERE codigoCliente = '". $cliente ."' AND fechaTransaccion between '". $primerDia ."' and '". $ultimoDia ."'";
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
            if (!$cliente || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
				while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
				$html = $html .'
					<div class="container">
					<br>
						<fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
						<legend class="w-auto" 
                        style="font-size: 1.1em; font-weight: bold;">Fecha: '.$primerDia.'</legend>
						<div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Total movimientos:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'. $row['movimientos'].'" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Valor Mensual:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="'.$row['valor'].'" readonly>
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


