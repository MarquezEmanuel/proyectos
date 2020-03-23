<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuenta = $_POST['cuenta'];
$sucursal = $_POST['sucursal'];
$producto = $_POST['producto'];
$cuota = $_POST['cuota'];
$signoCuota = $_POST['signoCuota'];
$dias = $_POST['dias'];
$signoDias = $_POST['signoDias'];
$formaPago = $_POST['formaPago'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(importeCuota as money),1) AS importeCuota2, convert(varchar,cast(interesNormal as money),1) AS interesNormal2,"
        . "convert(varchar,cast(capital as money),1) AS capital2, convert(varchar,cast(punitorios as money),1) AS punitorios2, "
        . "convert(varchar,cast(gastos as money),1) AS gastos2, convert(varchar,cast(compensatorios as money),1) AS compensatorios2 FROM [4moraPrestamos]";
		

if (isset($cuenta) && $cuenta != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE cuenta = " . $cuenta;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND producto = " . $producto ;
            if (isset($cuota) && $cuota != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                }else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            }else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                }else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            }
        } else{
            //no tiene cartera
            if (isset($cuota) && $cuota != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            } else{
                //no tiene cartera ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                }else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
            //si tiene cartera agrega en and
            $query = $query . " AND producto = " . $producto;
            if (isset($cuota) && $cuota != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            }
        } else{
            //no tiene sucursal ni cartera
            if (isset($cuota) && $cuota != null) {
                //si tiene atraso agrega en and
                $query = $query . " AND importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            } else{
                //no tiene sucursal ni prestamo ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
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
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND producto = " . $producto;
            if (isset($cuota) && $cuota != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            } else{
                //no tiene producto ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($cuota) && $cuota != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            } else{
                //no tiene tipo debito ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
             //si tiene cartera empieza el where
            $query = $query . " WHERE producto = " . $producto;
            if (isset($cuota) && $cuota != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            }
        } else{
            //no tiene cartera
            if (isset($cuota) && $cuota != null) {
                //si tiene atraso agrega en and
                $query = $query . " WHERE importeCuota $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                } else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
				}
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " WHERE diasMora $signoDias " . $dias;
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "AND carpeta $formaPago[0]";
						}
					}
                }else{
					if(count($formaPago) != 0){
						if(count($formaPago) == 1){
							$query = $query . "WHERE carpeta $formaPago[0]";
						}
					}
				}
            }
        }
    }
}

// SE EJECUTA LA CONSULTA+
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;


if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraPrestamos' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th>Numero de Cliente</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th style='display:none;'>Atributo</th>
                                            <th style='display:none;'>Cuota</th>
                                            <th>Vencimiento</th>
                                            <th>Importe de Cuota</th>
                                            <th style='display:none;'>Interes Normal</th>
                                            <th style='display:none;'>Capital</th>
                                            <th style='display:none;'>Punitorios</th>
                                            <th style='display:none;'>Gastos</th>
                                            <th style='display:none;'>Compensatorios</th>
                                            <th>Dias de Mora</th>
                                            <th style='display:none;'>Legajo</th>
                                            <th style='display:none;'>Carpeta</th>
                                            <th style='display:none;'>Tipo de Credito</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $vencimiento = isset($row['vencimiento']) ? $row['vencimiento']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td>{$row['producto']}</td>
                <td style='display:none;'>{$row['moneda']}</td>
                <td style='display:none;'>{$row['atributo']}</td>
                <td style='display:none;'>{$row['cuota']}</td>
                <td>{$vencimiento}</td>
                <td>{$row['importeCuota2']}</td>
                <td style='display:none;'>{$row['interesNormal2']}</td>
                <td style='display:none;'>{$row['capital2']}</td>
                <td style='display:none;'>{$row['punitorios2']}</td>
                <td style='display:none;'>{$row['gastos2']}</td>
                <td style='display:none;'>{$row['compensatorios2']}</td>
                <td>{$row['diasMora']}</td>
                <td style='display:none;'>{$row['legajo']}</td>
                <td style='display:none;'>{$row['carpeta']}</td>
                <td style='display:none;'>{$row['tipoCredito']}</td>
                <td class='text-center' title='Ver detalles de el prestamo en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMoraPrestamos' name='{$row['id']}' width='18' height='18' > 
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


