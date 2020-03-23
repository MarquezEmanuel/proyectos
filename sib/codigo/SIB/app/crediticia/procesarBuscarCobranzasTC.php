<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuenta = $_POST['cuenta'];
$sucursal = $_POST['sucursal'];
$tipoDebito = $_POST['debito'];
$saldo = $_POST['saldo'];
$signoSaldo = $_POST['signoSaldo'];
$minimo = $_POST['minimo'];
$signoMinimo = $_POST['signoMinimo'];
$cobranzasReafa = $_POST['cobranzasReafa'];
$signoCobranzasReafa = $_POST['signoCobranzasReafa'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(saldoPesos as money),1) AS saldoPesos2, convert(varchar,cast(minimoPesos as money),1) AS minimoPesos2,"
        . "convert(varchar,cast(saldoDolares as money),1) AS saldoDolares2, convert(varchar,cast(cobranzasSo as money),1) AS cobranzasSo2, "
        . "convert(varchar,cast(cobranzasTanqueSFB as money),1) AS cobranzasTanqueSFB2, convert(varchar,cast(cobranzasReafa as money),1) AS cobranzasReafa2, "
        . "convert(varchar,cast(saldoCuentaSFB as money),1) AS saldoCuentaSFB2, convert(varchar,cast(bloqueo as money),1) AS bloqueo2, cast ([fechaVencimiento] AS smalldatetime) fechaVencimiento2 FROM [4cobranzasTC] ";

if (isset($cuenta) && $cuenta != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE cuentaBanco = " . $cuenta;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursalCuentaBanco = " . $sucursal;
        if (isset($tipoDebito) && $tipoDebito != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND tipoDebito LIKE '%" . $tipoDebito . "%'";
            if (isset($saldo) && $saldo != null) {
                //si tiene sucursal y tipo debito y saldo agrega en and
                $query = $query . " AND saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            }else{
                //no tiene saldo
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y tipo debito y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            }
        } else{
            //no tiene tipo debito
            if (isset($saldo) && $saldo != null) {
                //si tiene sucursal y saldo agrega en and
                $query = $query . " AND saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            } else{
                //no tiene tipo debito ni saldo
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            }
        }
    } else {
        //no tiene sucursal
        if (isset($tipoDebito) && $tipoDebito != null) {
            //si tiene tipo debito agrega en and
            $query = $query . " AND tipoDebito LIKE '%" . $tipoDebito . "%'";
            if (isset($saldo) && $saldo != null) {
                //si tiene tipo debito y saldo agrega en and
                $query = $query . " AND saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
                }
            }
        } else{
            //no tiene sucursal ni tipo debito
            if (isset($saldo) && $saldo != null) {
                //si tiene saldo agrega en and
                $query = $query . " AND saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            } else{
                //no tiene sucursal ni prestamo ni saldo
                if (isset($minimo) && $minimo != null) {
                    //si tiene minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            }
        }
    }
} else {				
    //no tiene cuenta
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE sucursalCuentaBanco = " . $sucursal;
        if (isset($tipoDebito) && $tipoDebito != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND tipoDebito LIKE '%" . $tipoDebito . "%'";
            if (isset($saldo) && $saldo != null) {
                //si tiene sucursal y tipo debito y saldo agrega en and
                $query = $query . " AND saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            } else{
                //no tiene producto ni saldo
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y tipo debito y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($saldo) && $saldo != null) {
                //si tiene sucursal y saldo agrega en and
                $query = $query . " AND saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            } else{
                //no tiene tipo debito ni saldo
                if (isset($minimo) && $minimo != null) {
                    //si tiene sucursal y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            }
        }
    } else {
        //no tiene sucursal
        if (isset($tipoDebito) && $tipoDebito != null) {
             //si tiene tipo debito empieza el where
            $query = $query . " WHERE tipoDebito LIKE '%" . $tipoDebito . "%'";
            if (isset($saldo) && $saldo != null) {
                //si tiene tipo debito y saldo agrega en and
                $query = $query . " AND saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            } else{
                //no tiene saldo
                if (isset($minimo) && $minimo != null) {
                    //si tiene tipo debito y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
                }
				}
            }
        } else{
            //no tiene tipo debito
            if (isset($saldo) && $saldo != null) {
                //si tiene saldo agrega en and
                $query = $query . " WHERE saldoPesos $signoSaldo " . $saldo;
                if (isset($minimo) && $minimo != null) {
                    //si tiene saldo y minimo agrega en and
                    $query = $query . " AND minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
					}
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
					}
				}
            } else{
                //no tiene saldo
                if (isset($minimo) && $minimo != null) {
                    //si tiene minimo agrega en and
                    $query = $query . " WHERE minimoPesos $signoMinimo " . $minimo;
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
					}
                } else{
					if (isset($cobranzasReafa) && $cobranzasReafa != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " WHERE cobranzasTanqueSFB $signoCobranzasReafa " . $cobranzasReafa;
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
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th style='display:none;'>Marca</th>
                                            <th style='display:none;'>Cuenta Tarjeta</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>Cuenta Banco</th>
                                            <th>Sucursal</th>
                                            <th>Tipo de Cuenta</th>
                                            <th>Tipo de Debito</th>
                                            <th>Saldo en Pesos</th>
                                            <th>Minimo en Pesos</th>
                                            <th style='display:none;'>Saldo en Dolares</th>
                                            <th>Fecha de Vencimiento</th>
                                            <th style='display:none;'>Cobranzas So</th>
                                            <th style='display:none;'>Cobranzas Tanque SFB</th>
                                            <th style='display:none;'>Fecha de Pago Tanque SFB</th>
                                            <th style='display:none;'>Cobranzas Reafa</th>
                                            <th style='display:none;'>Fecha Pago Reafa</th>
                                            <th style='display:none;'>Cliente</th>
                                            <th style='display:none;'>Saldo Cuentas SFB</th>
                                            <th style='display:none;'>Bloqueo</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['nombre']);
            $fechaVencimiento = isset($row['fechaVencimiento2']) ? $row['fechaVencimiento2']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['marca']}</td>
                <td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['cuentaBanco']}</td>
                <td>{$row['sucursalCuentaBanco']}</td>
                <td>{$row['tipoCuenta']}</td>
                <td>{$row['tipoDebito']}</td>
                <td>{$row['saldoPesos2']}</td>
                <td>{$row['minimoPesos2']}</td>
                <td style='display:none;'>{$row['saldoDolares2']}</td>
                <td>{$fechaVencimiento}</td>
                <td style='display:none;'>{$row['cobranzasSo2']}</td>
                <td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['fechaPagoTanqueSFB']}</td>
                <td style='display:none;'>{$row['cobranzasReafa2']}</td>
                <td style='display:none;'>{$row['fechaPagoReafa']}</td>
                <td style='display:none;'>{$row['cliente']}</td>
                <td style='display:none;'>{$row['saldoCuentaSFB2']}</td>
                <td style='display:none;'>{$row['bloqueo2']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='{$row['id']}' width='18' height='18' > 
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


