<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$documento = $_POST['documento'];
$sucursal = $_POST['sucursal'];
$cartera = $_POST['cartera'];
$atraso = $_POST['atraso'];
$signoAtraso = $_POST['signoAtraso'];
$monto = $_POST['monto'];
$signoMonto = $_POST['signoMonto'];
$saldo = $_POST['saldo'];
$signoSaldo = $_POST['signoSaldo'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(montoTotal as money),1) AS montoTotal2, convert(varchar,cast(deudaVencidaTotal as money),1) AS deudaVencidaTotal2,"
        . "convert(varchar,cast(montoExigible as money),1) AS montoExigible2, convert(varchar,cast(mme as money),1) AS mme2, "
        . "convert(varchar,cast(saldoCuentas as money),1) AS saldoCuentas2 FROM [4saldosClientesMora] ";

if (isset($documento) && $documento != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE numeroDocumento = '" . $documento ."'";
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($cartera) && $cartera != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND cartera = " . $cartera ;
            if (isset($atraso) && $atraso != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
                }
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
				}
            }
			}else{
                //no tiene atraso
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
                }
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
				}
            }
        }
		}		else{
            //no tiene cartera
            if (isset($atraso) && $atraso != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
				}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
				}
            }
            } else{
                //no tiene cartera ni atraso
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
				}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            }
        }
	}
    else {
        //no tiene sucursal
        if (isset($cartera) && $cartera != null) {
            //si tiene cartera agrega en and
            $query = $query . " AND cartera = " . $cartera;
            if (isset($atraso) && $atraso != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            }
        } else{
            //no tiene sucursal ni cartera
            if (isset($atraso) && $atraso != null) {
                //si tiene atraso agrega en and
                $query = $query . " AND diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            } else{
                //no tiene sucursal ni prestamo ni atraso
                if (isset($monto) && $monto != null) {
                    //si tiene monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            }
        }
    }
	}  else {
    //no tiene documento
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE sucursal = " . $sucursal;
        if (isset($cartera) && $cartera != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND cartera = " . $cartera;
            if (isset($atraso) && $atraso != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            } else{
                //no tiene producto ni atraso
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($atraso) && $atraso != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            } else{
                //no tiene tipo debito ni atraso
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            }
        }
    } else {
        //no tiene sucursal
        if (isset($cartera) && $cartera != null) {
             //si tiene cartera empieza el where
            $query = $query . " WHERE cartera = " . $cartera;
            if (isset($atraso) && $atraso != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            } else{
                //no tiene atraso
                if (isset($monto) && $monto != null) {
                    //si tiene cartera y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            }
        } else{
            //no tiene cartera
            if (isset($atraso) && $atraso != null) {
                //si tiene atraso agrega en and
                $query = $query . " WHERE diasAtraso $signoAtraso " . $atraso;
                if (isset($monto) && $monto != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
				}
            } else{
                //no tiene atraso
                if (isset($monto) && $monto != null) {
                    //si tiene monto agrega en and
                    $query = $query . " WHERE montoTotal $signoMonto " . $monto;
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND saldoCuentas $signoSaldo " . $saldo;
					}
                } else{
					if (isset($saldo) && $saldo != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
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
        <table id='tb_buscar_saldosMora' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Numero de Cliente</th>
                                            <th style='display:none;'>CUIT</th>
                                            <th style='display:none;'>Documento</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Cartera</th>
                                            <th>Dias de Atraso</th>
                                            <th>Producto Mayor Atraso</th>
                                            <th>Monto Total</th>
                                            <th style='display:none;'>Deuda Vencida Total</th>
                                            <th style='display:none;'>Monto Exigible</th>
                                            <th>MME</th>
                                            <th style='display:none;'>Fallecido</th>
                                            <th style='display:none;'>Confidencial</th>
                                            <th style='display:none;'>Agencia</th>
                                            <th style='display:none;'>Etapa</th>
                                            <th style='display:none;'>Fecha Alta Etapa</th>
                                            <th style='display:none;'>Situacion BCRA</th>
                                            <th style='display:none;'>Conyuge</th>
                                            <th style='display:none;'>Organismo</th>
                                            <th style='display:none;'>Empresa Haberes</th>
                                            <th>Tipo de Gestion</th>
                                            <th style='display:none;'>Cantidad de Cuentas</th>
                                            <th style='display:none;'>Saldo de Cuentas</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['nombre']);
            $conyuge = utf8_encode($row['conyuge']);
            $fechaAltaEtapa = isset($row['fechaAltaEtapa']) ? $row['fechaAltaEtapa']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroDocumento']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['diasAtraso']}</td>
                <td>{$row['productoMayorAtraso']}</td>
                <td>{$row['montoTotal2']}</td>
                <td style='display:none;'>{$row['deudaVencidaTotal2']}</td>
                <td style='display:none;'>{$row['montoExigible2']}</td>
                <td>{$row['mme2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['confidencial']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$fechaAltaEtapa}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['empresaHaberes']}</td>
                <td>{$row['tipoGestion']}</td>
                <td style='display:none;'>{$row['cantidadCuentas']}</td>
                <td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td class='text-center' title='Ver detalles de el saldo en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesSaldosMora' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
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


