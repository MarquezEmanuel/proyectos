<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuit = $_POST['cuit'];
$sucursal = $_POST['sucursal'];
$tipoGestion = $_POST['tipoGestion'];
$atraso = $_POST['atraso'];
$signoAtraso = $_POST['signoAtraso'];
$monto = $_POST['monto'];
$signoMonto = $_POST['signoMonto'];
$segmento = $_POST["elegido"];
$saldo = $_POST["saldo"];
$signoSaldo = $_POST["signoSaldo"];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(deudaTotalConsolidada as money),1) AS deudaTotalConsolidada2, convert(varchar,cast(deudaTotalVencida as money),1) AS deudaTotalVencida2,"
        . "convert(varchar,cast(deudaTotalMME as money),1) AS deudaTotalMME2, convert(varchar,cast(sdoTotPendientePrestamo as money),1) AS sdoTotPendientePrestamo2, "
        . "convert(varchar,cast(mtoTotalMoraPrestamo as money),1) AS mtoTotalMoraPrestamo2, convert(varchar,cast(mmePrestamo as money),1) AS mmePrestamo2,"
        . "convert(varchar,cast(sdoTotalPendienteTC as money),1) AS sdoTotalPendienteTC2, convert(varchar,cast(mtoTotalMoraTC as money),1) AS mtoTotalMoraTC2,"
        . "convert(varchar,cast(mmeTC as money),1) AS mmeTC2, convert(varchar,cast(sdoTotalPendienteGYM as money),1) AS sdoTotalPendienteGYM2,"
        . "convert(varchar,cast(mtoTotalMoraGYM as money),1) AS mtoTotalMoraGYM2, convert(varchar,cast(mmeGYM as money),1) AS mmeGYM2,"
        . "convert(varchar,cast(capitalGYM as money),1) AS capitalGYM2, convert(varchar,cast(saldoContableGYM as money),1) AS saldoContableGYM2, "
        . "convert(varchar,cast(sdoTotPendienteCC as money),1) AS sdoTotPendienteCC2, convert(varchar,cast(mtoTotalMoraCC as money),1) AS mtoTotalMoraCC2,"
        . "convert(varchar,cast(mmeCC as money),1) AS mmeCC2, convert(varchar,cast(saldoTerceros as money),1) AS saldoTerceros2,"
        . "convert(varchar,cast(cobranzasTanqueSFB as money),1) AS cobranzasTanqueSFB2, convert(varchar,cast(saldoCuentas as money),1) AS saldoCuentas2 FROM [bd_sib].[dbo].[recuperacionCrediticia] ";

if (isset($cuit) && $cuit != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE numeroCuit = '" . $cuit . "'";
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($tipoGestion) && $tipoGestion != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND tipoGestion LIKE '%" . $tipoGestion . "%'";
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND deudaTotalConsolidada $signoMonto " . $monto;
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                } else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        } else {
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND deudaTotalConsolidada $signoMonto " . $monto;
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                } else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        }
    } else {
        //no tiene sucursal
        if (isset($tipoGestion) && $tipoGestion != null) {
            //si tiene cartera agrega en and
            $query = $query . " AND tipoGestion LIKE '%" . $tipoGestion . "%'";
                if (isset($monto) && $monto != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND deudaTotalConsolidada $signoMonto " . $monto;
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                } else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    }else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        } else {
            //no tiene sucursal ni cartera
                if (isset($monto) && $monto != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND deudaTotalConsolidada $signoMonto " . $monto;
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    }else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                } else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    }else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        }
    }
} else {
    //no tiene documento
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE sucursal = " . $sucursal;
        if (isset($tipoGestion) && $tipoGestion != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND tipoGestion LIKE '%" . $tipoGestion . "%'";
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND deudaTotalConsolidada $signoMonto " . $monto; 
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                } else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        } else {
            //no tiene producto ni prestamo
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND deudaTotalConsolidada $signoMonto " . $monto;
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                } else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        }
    } else {
        //no tiene sucursal
        if (isset($tipoGestion) && $tipoGestion != null) {
            //si tiene cartera empieza el where
            $query = $query . " WHERE tipoGestion LIKE '%" . $tipoGestion . "%'";
                if (isset($monto) && $monto != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND deudaTotalConsolidada $signoMonto " . $monto;
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                } else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        } else {
            //no tiene cartera
                if (isset($monto) && $monto != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " WHERE deudaTotalConsolidada $signoMonto " . $monto;
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }else{
                    if (isset($segmento) && $segmento != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "WHERE segmento IN(";
                        for ($i = 0; $i < count($segmento); $i++) {
                            $i = $i +1;
                            if($i == count($segmento)){
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$segmento[$i]',";
                            }
                        }
						if (isset($saldo) && $saldo != null) {
							$query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
						}
                    } else{
						if (isset($saldo) && $saldo != null) {
							$query = $query . " WHERE saldoCuentas $signoSaldo " . $saldo;
						}
					}
                }
        }
    }
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_unificado' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                        <col style='width: 10%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
										<col style='width: 10%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Numero de CUIT</th>
                                            <th style='display:none;'>Numero de Cliente</th>
											<th style='display:none;'>Saldo de Cuentas</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th style='display:none;'>Cartera</th>
                                            <th>Sucursal</th>
											<th>Mayor dia de atraso</th>
                                            <th style='display:none;'>Deuda Total Consolidada</th>
                                            <th>Deuda Total Vencida</th>
                                            <th>Deuda Total MME</th>
                                            <th>Segmento</th>
                                            <th>Dias de Atraso en Prestamo</th>
											<th style='display:none;'>Producto Prestamo</th>
                                            <th style='display:none;'>Saldo Total Pendiente Prestamo</th>
                                            <th style='display:none;'>Monto Total Mora Prestamo</th>
                                            <th style='display:none;'>MME Prestamo</th>
											<th style='display:none;'>Saldo de Terceros</th>
											<th style='display:none;'>Carpeta</th>
											<th style='display:none;'>Forma de Pago</th>
											<th style='display:none;'>Organismo</th>
                                            <th style='display:none;'>Dias Atraso TC</th>
											<th style='display:none;'>Marca</th>
											<th style='display:none;'>Cuenta Tarjeta</th>
                                            <th style='display:none;'>Saldo Total Pendiente TC</th>
                                            <th style='display:none;'>Monto Total Mora TC</th>
                                            <th style='display:none;'>MME TC</th>
											<th style='display:none;'>Cobranzas Tanques SFB</th> 
                                            <th style='display:none;'>Dias de Atraso en GYM</th>
                                            <th style='display:none;'>Saldo Total Pendiente GYM</th>
                                            <th style='display:none;'>Monto Total Mora GYM</th>
                                            <th style='display:none;'>MME GYM</th>
                                            <th style='display:none;'>Capital GYM</th>
                                            <th style='display:none;'>Saldo contable GYM</th>
                                            <th style='display:none;'>Dias de Atraso CC</th>                                            
                                            <th style='display:none;'>Saldo Total Pendiente CC</th>
                                            <th style='display:none;'>Monto Total Mora CC</th>
                                            <th style='display:none;'>MME CC</th>
                                            <th style='display:none;'>Fallecido</th>
                                            <th style='display:none;'>Quiebra</th>
                                            <th style='display:none;'>Agencia</th>
                                            <th style='display:none;'>Etapa</th>
                                            <th style='display:none;'>Situacion BCRA</th>
                                            <th style='display:none;'>Proyeccion</th>                                           
                                            <th style='display:none;'>Datos Empleador</th>
                                            <th style='display:none;'>Conyuge</th>
                                            <th style='display:none;'>Tipo de Gestion</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $conyuge = utf8_encode($row['conyuge']);
			$total= 0;
			$diasTC = isset($row['diasAtrasoTC']) ? $row['diasAtrasoTC'] :  0;
			$diasPrestamo = isset($row['diasAtrasoPrestamo']) ? $row['diasAtrasoPrestamo'] :  0;
			$diasCC = isset($row['diasAtrasoCC']) ? $row['diasAtrasoCC'] :  0;
			$diasGYM = isset($row['diasAtrasoGYM']) ? $row['diasAtrasoGYM'] : 0;
			if ($total < $diasTC){
				$total = $diasTC;
					if($total < $diasPrestamo){
						$total = $diasPrestamo;
							if($total < $diasCC){
								$total = $diasCC;
									if($total < $diasGYM){
										$total = $diasGYM;
									}
							}else{
								if($total < $diasGYM){
									$total = $diasGYM;
									}
							}
					}else{
						if($total < $diasCC){
							$total = $diasCC;
								if($total < $diasGYM){
									$total = $diasGYM;
								}
							}else{
								if($total < $diasGYM){
										$total = $diasGYM;
									}
							}
					}
			}else{
				if($total < $diasPrestamo){
					$total = $diasPrestamo;
						if($total < $diasCC){
							$total = $diasCC;
								if($total < $diasGYM){
									$total = $diasGYM;
								}
							}else{
								if($total < $diasGYM){
									$total = $diasGYM;
								}
							}
					}else{
						if($total < $diasCC){
							$total = $diasCC;
								if($total < $diasGYM){
									$total = $diasGYM;
								}
							}else{
								if($total < $diasGYM){
									$total = $diasGYM;
								}
							}
					}
			}
			
			
		if (isset($atraso) && $atraso != null){	
		if($signoAtraso == '>'){
				if($total > $atraso){
					$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
				}
			} else{
				if($signoAtraso == '<'){
				if($total < $atraso){
					$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
				}
			} else{
				if($signoAtraso == '='){
				if($total == $atraso){
					$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
				}
			}
			}
			}
		}else{
			$print = $print . "
            <tr>
                <td>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
				<td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$total}</td>
                <td style='display:none;'>{$row['deudaTotalConsolidada2']}</td>
                <td>{$row['deudaTotalVencida2']}</td>
                <td>{$row['deudaTotalMME2']}</td>
                <td>{$row['segmento']}</td>
                <td>{$row['diasAtrasoPrestamo']}</td>
				<td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sdoTotPendientePrestamo2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraPrestamo2']}</td>
                <td style='display:none;'>{$row['mmePrestamo2']}</td>
				<td style='display:none;'>{$row['saldoTerceros2']}</td>
				<td style='display:none;'>{$row['carpeta']}</td>
				<td style='display:none;'>{$row['formaPago']}</td>
				<td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['diasAtrasoTC']}</td>
				<td style='display:none;'>{$row['marca']}</td>
				<td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteTC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraTC2']}</td>
                <td style='display:none;'>{$row['mmeTC2']}</td>
				<td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['diasAtrasoGYM']}</td>
                <td style='display:none;'>{$row['sdoTotalPendienteGYM2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraGYM2']}</td>
                <td style='display:none;'>{$row['mmeGYM2']}</td>
                <td style='display:none;'>{$row['capitalGYM2']}</td>
                <td style='display:none;'>{$row['saldoContableGYM2']}</td>
                <td style='display:none;'>{$row['diasAtrasoCC']}</td>
                <td style='display:none;'>{$row['sdoTotPendienteCC2']}</td>
                <td style='display:none;'>{$row['mtoTotalMoraCC2']}</td>
                <td style='display:none;'>{$row['mmeCC2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['quiebra']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td style='display:none;'>{$row['datosEmpleador']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['tipoGestion']}</td>
                <td class='text-center' title='Ver detalles de el unificado'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesUnificado' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
		}
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    // OCURRIO UN ERROR 
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    echo $query;
}

echo $print;


