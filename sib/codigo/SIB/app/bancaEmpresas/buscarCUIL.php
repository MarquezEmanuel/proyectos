<?php
include_once '../conf/Constants.php';
include_once '../conf/Log.php';
include_once '../conf/BDConexion.php';

session_start();
//Cobro no aplicado

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['nombreCuenta']);
			$documento = $row['documento'];
			$cliente = $row['codigoCliente'];
			if($row['ultimaFechaPayCheck'] != NULL){
				$paycheck = "SI";
			}else{
				$paycheck = "NO";
			}
			if($row['siteEmpresa'] != NULL){
				$site = "SI";
			}else{
				$site = "NO";
			}
            $fechaVencimiento = isset($row['fechaActualizacion']) ? $row['fechaActualizacion']->format('d/m/Y') : "";
			$ultimaFechaPayCheck = isset($row['ultimaFechaPayCheck']) ? $row['ultimaFechaPayCheck']->format('d/m/Y') : "";
			$fechaApertura = isset($row['fechaApertura']) ? $row['fechaApertura']->format('d/m/Y') : "";
            $print = $print . '
			<br><br>
			<div class="container">
            <fieldset id="datos" name="datos" class="border p-2" style="border-color: #b9b9b9 !important;">
            <h5>INFORMACION DEL CLIENTE</h5>
            <hr /><hr />
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Nombre:</label> 
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Nombre y Apellido" value = "'.$nombre.'">
                    </div>
                <label class="col-sm-2 col-form-label">* Numero de Cuenta:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Numero de Cuenta" value = "'.$row['sucursal'].'/'.$row['cuenta'].'-'.$row['digito'].'">
                    </div>
            </div>
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Codigo de Cliente:</label> 
                <div class="col">
                        <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Codigo de cliente" value = "'.$row['codigoCliente'].'">
                    </div>
                <label class="col-sm-2 col-form-label">* Documento:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Documento" value = "'.$row['documento'].'">
                    </div>
            </div>
			<div class="form-group row">
			<label class="col-sm-2 col-form-label">* Telefono:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Telefono" value = "'.$row['telefono'].'">
                    </div>
            <label class="col-sm-2 col-form-label">* Correo:</label> 
                <div class="col">
                        <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Correo" value = "'.$row['correo'].'">
                    </div>
            </div>
            <hr /><hr />
            <h5>INFORMACION DE LA CUENTA</h5>
            <hr /><hr />
            <div class="form-group row">
			<label class="col-sm-2 col-form-label">* Producto:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Producto" value = "'.$row['producto'].'">
                    </div>
            <label class="col-sm-2 col-form-label">* Estado de Cuenta:</label> 
                <div class="col">
                        <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Estado de Cuenta" value = "'.$row['estadoCuenta'].'">
                    </div>
            </div>
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Codigo actividad AFIP:</label> 
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Actividad AFIP" value = "'.$row['actividadAFIP'].'">
                    </div>
                <label class="col-sm-2 col-form-label">* Mes deuda previsional:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Deuda previsional" value = "'.$row['mesDeudaPrevisional'].'">
                    </div>
            </div>
			<div class="form-group row">
            <label class="col-sm-2 col-form-label">* Tipo de Cuenta:</label> 
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Tipo de Cuenta" value = "'.$row['tipoCuenta'].'">
                    </div>
                <label class="col-sm-2 col-form-label">* Fecha de Alta:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Fecha de Apertura" value = "'.$fechaApertura.'">
                    </div>
            </div>
			<div class="form-group row">
            <label class="col-sm-2 col-form-label">* CBU:</label> 
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="CBU" value = "'.$row['CBU'].'">
                    </div>
            </div>
            <hr /><hr />
            <h5>SITUACION BCRA</h5>
            <hr /><hr />
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Mes Situacion BCRA:</label> 
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Mes Situacion BCRA" value = "'.$row['mesSituacionBCRA'].'">
                    </div>
                <label class="col-sm-2 col-form-label">* Situacion BCRA:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Situacion BCRA" value = "'.$row['situacionBCRA'].'">
                    </div>
            </div>
			<hr /><hr />
            <h5>SERVICIO PAYCHECK</h5>
            <hr /><hr />
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Posee servicio:</label> 
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$paycheck.'">
                    </div>
                <label class="col-sm-2 col-form-label">* Ultima Utilizacion:</label>
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$ultimaFechaPayCheck.'">
                    </div>
            </div>
			<hr /><hr />
            <h5>SERVICIO SITE EMPRESAS</h5>
            <hr /><hr />
            <div class="form-group row">
            <label class="col-sm-2 col-form-label">* Posee servicio:</label> 
                <div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="SITE" value = "'.$site.'">
                    </div>
            </div>
			';
			
			//plazos fijos vigentes
			
			$limites = "SELECT *, convert(varchar,cast(montoDepositado as money),1) AS montoDepositado2,convert(varchar,cast(montoInteres as money),1) AS montoInteres2,convert(varchar,cast(montoPago as money),1) AS montoPago2 FROM [bd_sib].[dbo].[6plazosFijos] WHERE numeroCliente = '".$cliente."'";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $limites);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$fecha = isset($row['fechaOperacion']) ? $row['fechaOperacion']->format('d/m/Y') : "";
					$print = $print . '
					<hr /><hr />
					<h5>PLAZO FIJO VIGENTE  
					<button class="btn btn-sm btn-outline-info">
                    <img src="../../lib/img/EYE.png" class="detallesPlazoFijo" name="'.$row['numeroCliente'].'" width="15" height="15" >
					</button></h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Fecha:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$fecha.'">
                    </div>
					<label class="col-sm-2 col-form-label">* Dias:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['plazoDias'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Monto:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$row['montoDepositado2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Transferible:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$row['atm'].'">
                    </div>
					</div>
					';
				}
			} else {
				$print = $print . '
					<hr /><hr />
					<h5>PLAZO FIJO VIGENTE </h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Plazo Fijo Vigente:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "NO POSEE">
                    </div>
					</div>
					';
			}
			
			//calificaciones especiales
			
			$limites = "SELECT *, convert(varchar,cast(montoCalificacion as money),1) AS montoCalificacion2,convert(varchar,cast(montoCredito as money),1) AS montoCredito2 FROM [bd_sib].[dbo].[6calificacionesEspeciales] WHERE numeroCliente = '".$cliente."'";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $limites);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$fechaAutorizacion = isset($row['fechaAutorizacion']) ? $row['fechaAutorizacion']->format('d/m/Y') : "";
					$fechaVencimiento = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
					$print = $print . '
					<hr /><hr />
					<h5>CALIFICACIONES ESPECIALES </h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Fecha Autorizacion:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$fechaAutorizacion.'">
                    </div>
					<label class="col-sm-2 col-form-label">* Fecha Vencimiento:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$fechaVencimiento.'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Monto Calificacion:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$row['montoCalificacion2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Monto Credito:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$row['montoCredito2'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Producto:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$row['producto'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Moneda:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$row['moneda'].'">
                    </div>
					</div>
					';
				}
			} else {
				$print = $print . '
					<hr /><hr />
					<h5>CALIFICACIONES ESPECIALES </h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Calificaciones Especiales:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "NO POSEE">
                    </div>
					</div>
					';
			}
			
			//limites
			
			$limites = "SELECT *, convert(varchar,cast(limite as money),1) AS limite2,convert(varchar,cast(valorUtilizado as money),1) AS valorUtilizado2,convert(varchar,cast(valorUtilizadoTotal as money),1) AS valorUtilizadoTotal2 FROM [bd_sib].[dbo].[limites] WHERE codigoCliente = '".$cliente."'";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $limites);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$print = $print . '
					<hr /><hr />
					<h5>LIMITES PLAFOND  
					<button class="btn btn-sm btn-outline-info">
                    <img src="../../lib/img/EYE.png" class="detallesPlafond" name="'.$row['codigoCliente'].'" width="15" height="15" >
					</button></h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Limite:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['limite2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Valor utilizado:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['valorUtilizado2'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Valor utilizado total:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="PAYCHECK" value = "'.$row['valorUtilizadoTotal2'].'">
                    </div>
					</div>
					';
				}
			}
			
			//embargo
			
			$embargo = " SELECT count(codigoCliente) cantidad FROM [6embargosVigentes] WHERE codigoCliente = '".$cliente."'";
			$resultados = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $embargo);
			if($tiene = sqlsrv_has_rows($resultados)){
				while ($row = sqlsrv_fetch_array($resultados, SQLSRV_FETCH_ASSOC)){
					if($row['cantidad'] != 0){
					$print = $print . '
					<hr /><hr />
					<h5>EMBARGOS VIGENTES 
					<button class="btn btn-sm btn-outline-info">
                    <img src="../../lib/img/EYE.png" class="detallesEmbargos" name="'.$cliente.'" width="15" height="15" >
					</button></h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Cantidad de embargos:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="0" title="" value = "'.$row['cantidad'].'">
                    </div>
					</div>
					';
					}
				}
			}
			
			//mora comercial
			
			$moraComercial = "SELECT *,convert(varchar,cast(montoTotal as money),1) AS montoTotal2, convert(varchar,cast(montoExigible as money),1) AS montoExigible2, convert(varchar,cast(MME as money),1) AS MME2 FROM [bd_sib].[dbo].[moraComercial] WHERE numeroCliente = '".$cliente."'";
			$resultados = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $moraComercial);
			if($tiene = sqlsrv_has_rows($resultados)){
				while ($row = sqlsrv_fetch_array($resultados, SQLSRV_FETCH_ASSOC)){
					$nombre = utf8_encode($row['nombreCliente']);
					$print = $print . '
					<hr /><hr />
					<h5>MORA COMERCIAL</h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Nombre de Cliente:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$nombre.'">
                    </div>
					<label class="col-sm-2 col-form-label">* Sucursal:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Deuda previsional" value = "'.$row['sucursal'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Dias de Atraso:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="0" title="" value = "'.$row['diasAtraso'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Monto Total:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Deuda previsional" value = "'.$row['montoTotal2'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Monto Exigible:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="0" title="" value = "'.$row['montoExigible2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* MME:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Deuda previsional" value = "'.$row['MME2'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Producto:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="0" title="" value = "'.$row['producto'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Cartera/Proyeccion:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Deuda previsional" value = "'.$row['cartera'].' / '.$row['proyeccion'].'">
                    </div>
					</div>
					';
				}
			}
			
			//adhesion depositaria
			
			$adhesionDepositaria = "SELECT TOP 1 *,convert(varchar,cast(sumatoria as money),1) AS sumatoria2 FROM [bd_sib].[dbo].[adhesionDepositariaHistorica] WHERE codigoCliente = '".$cliente."' ORDER BY fechaTransaccion desc";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $adhesionDepositaria);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$nombre = utf8_encode($row['nombreCuenta']);
					$fecha = isset($row['fechaTransaccion']) ? $row['fechaTransaccion']->format('d/m/Y') : "";
					$print = $print . '
					<hr /><hr />
					<h5>ADHESION DEPOSITARIA
					<button class="btn btn-sm btn-outline-info">
                    <img src="../../lib/img/EYE.png" class="detallesAdhesionDepositaria" name="'.$row['codigoCliente'].'" width="15" height="15" >
					</button></h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Nombre de Cliente:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$nombre.'">
                    </div>
					<label class="col-sm-2 col-form-label">* Cantidad de Movimientos:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['nroMovimientos'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Valor Mensual:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$row['sumatoria2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Fecha Transaccion:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$fecha.'">
                    </div>
					</div>
					';
				}
			}
			
			//pago haberes empresas
			
			$pagoHaberes = "SELECT *,convert(varchar,cast(montoTotal as money),1) AS montoTotal2 FROM [bd_sib].[dbo].[pagoHaberesEmpresas] WHERE codigoEmpresa = '".$cliente."' OR documentoEmpresa = '".$documento."'";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $pagoHaberes);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$nombre = utf8_encode($row['nombreEmpresa']);
					$ultimoPago = isset($row['ultimoPago']) ? $row['ultimoPago']->format('d/m/Y') : "";
					$print = $print . '
					<hr /><hr />
					<h5>PAGO DE HABERES</h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Nombre de la Empresa:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$nombre.'">
                    </div>
					<label class="col-sm-2 col-form-label">* Origen:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['origen'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Fecha Ultimo Pago:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Ultimo pago" value = "'.$ultimoPago.'">
                    </div>
					<label class="col-sm-2 col-form-label">* Monto Total:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Monto Total" value = "'.$row['montoTotal2'].'">
                    </div>
					</div>
					';
				}
			}
			
			//cheques rechazados
			
			$embargo = " SELECT count(codigoCliente) cantidad FROM [6chequesRechazados] WHERE codigoCliente = '".$cliente."'";
			$resultados = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $embargo);
			if($tiene = sqlsrv_has_rows($resultados)){
				while ($row = sqlsrv_fetch_array($resultados, SQLSRV_FETCH_ASSOC)){
					if($row['cantidad'] != 0){
					$print = $print . '
					<hr /><hr />
					<h5>CHEQUES RECHAZADOS
					<button class="btn btn-sm btn-outline-info">
                    <img src="../../lib/img/EYE.png" class="detallesChequesRechazados" name="'.$cliente.'" width="15" height="15" >
					</button></h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Cantidad de cheques rechazados:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="0" title="" value = "'.$row['cantidad'].'">
                    </div>
					</div>
					';
					}
				}
			}
			
			//adhesion de comercio
			
			$adhesionDepositaria = "SELECT TOP 1 *,convert(varchar,cast(totalMaestro as money),1) AS totalMaestro2,convert(varchar,cast(totalMaster as money),1) AS totalMaster2
			,convert(varchar,cast(totalVisa as money),1) AS totalVisa2 FROM [bd_sib].[dbo].[adhesionComercioHistorica] WHERE codigoCliente = '".$cliente."' ORDER BY fechaValor desc";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $adhesionDepositaria);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$nombre = utf8_encode($row['nombreCuenta']);
					$fechaValor = isset($row['fechaValor']) ? $row['fechaValor']->format('d/m/Y') : "";
					$print = $print . '
					<hr /><hr />
					<h5>ADHESION DE COMERCIO ACTUAL
					<button class="btn btn-sm btn-outline-info">
                    <img src="../../lib/img/EYE.png" class="detallesAdhesionComercio" name="'.$row['codigoCliente'].'" width="15" height="15" >
					</button></h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Nombre de Cliente:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$nombre.'">
                    </div>
					<label class="col-sm-2 col-form-label">* Producto:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['producto'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Total Maestro:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$row['totalMaestro2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Total Master:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$row['totalMaster2'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Total Visa:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$row['totalVisa2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Fecha:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$fechaValor.'">
                    </div>
					</div>
					';
				}
			}
			
			//valcetot
			
			$adhesionDepositaria = "SELECT *,convert(varchar,cast(total as money),1) AS total2, convert(varchar,cast(limite as money),1) AS limite2,
			convert(varchar,cast(disponible as money),1) AS disponible2 FROM [bd_sib].[dbo].[6valcetot] WHERE documento = '".$documento."'";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $adhesionDepositaria);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$print = $print . '
					<hr /><hr />
					<h5>VALCETOT</h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Total:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['total2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Limite:</label>
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['limite2'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Disponible:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$row['disponible2'].'">
                    </div>
					<label class="col-sm-2 col-form-label">* Situacion:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$row['situacion'].'">
                    </div>
					</div>
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Fecha Cendeu:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="Valor mensual" value = "'.$row['fechaCendeu'].'">
                    </div>
					</div>
					';
				}
			}
			
			//valcesin
			
			$adhesionDepositaria = "SELECT count(documento) cantidad 
			 FROM [bd_sib].[dbo].[6valcesin] WHERE documento = '".$documento."'";
			$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $adhesionDepositaria);
			if($tiene = sqlsrv_has_rows($resultado)){
				while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)){
					$print = $print . '
					<hr /><hr />
					<h5>VALCESIN
					<button class="btn btn-sm btn-outline-info">
                    <img src="../../lib/img/EYE.png" class="detallesValcesin" name="'.$documento.'" width="15" height="15" >
					</button></h5>
					<hr /><hr />
					<div class="form-group row">
					<label class="col-sm-2 col-form-label">* Cantidad:</label> 
					<div class="col">
                    <input type="text" class="form-control" id="" name="" placeholder="NO POSEE" title="" value = "'.$row['cantidad'].'">
                    </div>
					</div>
					';
				}
			}
			
			$print = $print .'
			</fieldset>
		</div>
			';
        }
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el CUIL ingresado</div>';
    }
}
echo $print;
	}
}

require_once './header.php';
?>
<div class="card-header">
<div class="container" id="contenido">
    <div class="card-header">
        <div class="container">
		<form id="formBuscarCUIL" name="formBuscarCUIL" method="POST">
            <br>
            <div class="col-lg-12">
                <div class="row">
                    <div id="contenido1" class="col-lg-12 contenido1">
                        <div class="form-row align-items-center mx-auto">
                            <div class="col">
								<center><h3 class="text-black">CUIL - CUIT</h3></center>
								<br>
								<input type="number" class="form-control" 
									id="CUIL" name="CUIL"
									placeholder="Numero de CUIL o CUIT">
							</div>
							<div class="col">
								<center><h3 class="text-black">NOMBRE</h3></center>
								<br>
								<input type="text" class="form-control" 
									id="nombre" name="nombre"
									placeholder="Nombre y Apellido">
							</div>
                        </div>
                        <br>
						<div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCUIL" name="btnBuscarCUIL value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarCUIL.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Salir"></a>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
			</form>
        </div>
    </div>
</div>
<div id="contenido2" name="contenido2">
<?php
        echo busca();
	?>
</div>
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/cargando.gif" class="img-fluid" alt="Responsive image" background="" width="750" height="750">
                </div>
        </div>
</div>
</div>
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	$('#tb_buscar_cobro').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Informe SIB'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCUIL", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCUIL.php",
            data: $("#formBuscarCUIL").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_CUIL');
            },
			complete: function() {
					setTimeout(function(){
						$('#mdProcesando').modal('hide');
					},1000)		
				},
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
	
	/* DETALLES PLAZO FIJO */
    
    $("#contenido2").on("click", "img.detallesPlazoFijo", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesPlazoFijo.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
    
    /* CARGA EL FORMULARIO DE DETALLES PLAFOND */
    
    $("#contenido2").on("click", "img.detallesPlafond", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesPlafond.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
	/* CARGA EL FORMULARIO DE DETALLES EMBARGOS */
    
    $("#contenido2").on("click", "img.detallesEmbargos", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesEmbargos.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
	/* CARGA EL FORMULARIO DE DETALLES ADHESION DEPOSITARIA */
    
    $("#contenido2").on("click", "img.detallesAdhesionDepositaria", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesAdhesionDepositaria.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
	/* CARGA EL FORMULARIO DE DETALLES DE CHEQUES RECHAZADOS*/
	
	$("#contenido2").on("click", "img.detallesChequesRechazados", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesChequesRechazados.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
	/* CARGA EL FORMULARIO DE DETALLES DE ADHESION DE COMERCIO*/
	
	$("#contenido2").on("click", "img.detallesAdhesionComercio", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesAdhesionComercio.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
	
	/* CARGA EL FORMULARIO DE DETALLES VALCESIN*/
	
	$("#contenido2").on("click", "img.detallesValcesin", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesValcesin.php",
            data: "seleccionado="+idcuotas,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
});

</script>
</html>