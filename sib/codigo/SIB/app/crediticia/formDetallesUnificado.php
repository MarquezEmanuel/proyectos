<?php
include_once '../conf/BDConexion.php';
/* Recibe el identificador de la cuenta seleccionada */
?>
<div class="container">
    <div id="contenido">
        <h3 class="text-center"><u>Integrador de Recuperacion Crediticia</u></h3>
        <div id="centro" class="container">
            <?php
            /* Se obtiene el id para obtener los datos de la BD */
            $idUnificado = $_POST['seleccionado'];
            $query = "SELECT *, convert(varchar,cast(deudaTotalConsolidada as money),1) AS deudaTotalConsolidada2, convert(varchar,cast(deudaTotalVencida as money),1) AS deudaTotalVencida2,"
        . "convert(varchar,cast(deudaTotalMME as money),1) AS deudaTotalMME2, convert(varchar,cast(sdoTotPendientePrestamo as money),1) AS sdoTotPendientePrestamo2, "
        . "convert(varchar,cast(mtoTotalMoraPrestamo as money),1) AS mtoTotalMoraPrestamo2, convert(varchar,cast(mmePrestamo as money),1) AS mmePrestamo2,"
        . "convert(varchar,cast(sdoTotalPendienteTC as money),1) AS sdoTotalPendienteTC2, convert(varchar,cast(mtoTotalMoraTC as money),1) AS mtoTotalMoraTC2,"
        . "convert(varchar,cast(mmeTC as money),1) AS mmeTC2, convert(varchar,cast(sdoTotalPendienteGYM as money),1) AS sdoTotalPendienteGYM2,"
        . "convert(varchar,cast(mtoTotalMoraGYM as money),1) AS mtoTotalMoraGYM2, convert(varchar,cast(mmeGYM as money),1) AS mmeGYM2,"
        . "convert(varchar,cast(capitalGYM as money),1) AS capitalGYM2, convert(varchar,cast(saldoContableGYM as money),1) AS saldoContableGYM2, "
        . "convert(varchar,cast(sdoTotPendienteCC as money),1) AS sdoTotPendienteCC2, convert(varchar,cast(mtoTotalMoraCC as money),1) AS mtoTotalMoraCC2,"
        . "convert(varchar,cast(mmeCC as money),1) AS mmeCC2, convert(varchar,cast(saldoTerceros as money),1) AS saldoTerceros2,"
        . "convert(varchar,cast(cobranzasTanqueSFB as money),1) AS cobranzasTanqueSFB2, convert(varchar,cast(saldoCuentas as money),1) AS saldoCuentas2 FROM [bd_sib].[dbo].[recuperacionCrediticia] WHERE id = ". $idUnificado;
            $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

            if (!$idUnificado || !$result) {
                echo '<div class="alert alert-danger text-center" role="alert"> No se obtuvo la información de la cuenta </div>';
                echo $query;
            } else {
                $cuen = sqlsrv_fetch_array($result);
                $nombre = utf8_encode($cuen['nombreCliente']);
                $conyuge = utf8_encode($cuen['conyuge']);
				$total= 0;
				$diasTC = $cuen['diasAtrasoTC'];
				$diasPrestamo = $cuen['diasAtrasoPrestamo'];
				$diasCC = $cuen['diasAtrasoCC'];
				$diasGYM = $cuen['diasAtrasoGYM'];
			if ($diasTC != null){
				if($total < $diasTC){
					$total = $diasTC;
					if($diasPrestamo != null){
						if($total < $diasPrestamo){
							$total = $diasPrestamo;
							if($diasCC != null){
								if($total < $diasCC){
									$total = $diasCC;
									if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
								}
							}
						}
					}
				}
			}else{
				if($diasPrestamo != null){
						if($total < $diasPrestamo){
							$total = $diasPrestamo;
							if($diasCC != null){
								if($total < $diasCC){
									$total = $diasCC;
									if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
								}
							}
						}
					}else{
						if($diasCC != null){
								if($total < $diasCC){
									$total = $diasCC;
									if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
								}
							}else{
								if($diasGYM != null){
										if($total < $diasGYM){
											$total = $diasGYM;
										}
									}
							}
					}
			}
                ?>
                <div class="container">
                    <br><br>
                    <div class="form-group row">
                        <label for="transaccion" class="col-sm-2 col-form-label">Numero CUIT:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCuit']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Numero de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['numeroCliente']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Nombre de Cliente:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $nombre; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Cartera:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cartera']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Sucursal:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['sucursal']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Deuda Total Consolidada:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['deudaTotalConsolidada2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">Deuda Total Vencida:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['deudaTotalVencida2']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Deuda Total MME:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['deudaTotalMME']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Segmento:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['segmento']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Dias de Atraso en Prestamo:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasAtrasoPrestamo']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Saldo Total Pendiente Prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['sdoTotPendientePrestamo2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Monto Total Mora Prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['mtoTotalMoraPrestamo2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="transaccion" class="col-sm-2 col-form-label">MME Prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['mmePrestamo']; ?>" readonly>
                        </div>
                        <label for="causal" class="col-sm-2 col-form-label">Dias de Atraso TC:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasAtrasoTC']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="nombreTransaccion" class="col-sm-2 col-form-label">Saldo Total Pendiente TC:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sdoTotalPendienteTC2']; ?>" readonly>
                        </div>
                        <label for="tipo" class="col-sm-2 col-form-label">Monto Total Mora TC:</label>
                        <div class="col" >
                            <input type="text" class="form-control mb-2" value="<?= $cuen['mtoTotalMoraTC2']; ?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">MME TC:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['mmeTC']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Dias de Atraso GYM:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasAtrasoGYM'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo Total Pendiente GYM:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sdoTotalPendienteGYM2'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Monto Total Mora GYM:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['mtoTotalMoraGYM2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">MME GYM:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['mmeGYM2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Capital GYM:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['capitalGYM2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo Contable GYM:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoContableGYM2'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Dias de Atraso CC:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['diasAtrasoCC'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo Total Pendiente CC:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['sdoTotPendienteCC2'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Monto Total Mora CC:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['mtoTotalMoraCC2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">MME CC:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $cuen['mmeCC2']; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Fallecido:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['fallecido'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Quiebra:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['quiebra'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Agencia:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['agencia'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Etapa:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['etapa'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Situacion BCRA:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['situacionBCRA'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Proyeccion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['proyeccion'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Datos Empleador:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['datosEmpleador'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="productoCuenta" class="col-sm-2 col-form-label">Conyuge:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"  value="<?= $conyuge; ?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Tipo de Gestion:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['tipoGestion'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo de Terceros:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoTerceros2'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Marca:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['marca'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cuenta de Tarjeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cuentaTarjeta'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Cobranzas de Tanque SFB:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['cobranzasTanqueSFB2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Producto del Prestamo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['productoPrestamo'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Carpeta:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['carpeta'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Forma de pago:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['formaPago'];?>" readonly>
                        </div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Saldo en Cuentas:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['saldoCuentas2'];?>" readonly>
                        </div>
                        <div class="w-100"></div>
                        <label for="sucursalCuenta" class="col-sm-2 col-form-label">Organismo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $cuen['organismo'];?>" readonly>
                        </div>
						<label for="sucursalCuenta" class="col-sm-2 col-form-label">Mayor dia de atraso:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" value="<?= $total;}?>" readonly>
                        </div>
                </div>                    
                <br>
                &nbsp;
                <a href="<?= $_SERVER["HTTP_REFERER"] ?>"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>


