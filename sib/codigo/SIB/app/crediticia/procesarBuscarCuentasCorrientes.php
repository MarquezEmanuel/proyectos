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

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(saldo as money),1) AS saldo2, convert(varchar,cast(acuerdo as money),1) AS acuerdo2,"
        . "convert(varchar,cast(exceso as money),1) AS exceso2, convert(varchar,cast(rechazo as money),1) AS rechazo2, "
        . "convert(varchar,cast(promedioMes as money),1) AS promedioMes2, convert(varchar,cast(promedio180 as money),1) AS promedio1802 FROM [4cuentasCorrientes]";

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
                $query = $query . " AND saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            }else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            }
        } else{
            //no tiene cartera
            if (isset($cuota) && $cuota != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            } else{
                //no tiene cartera ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
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
                $query = $query . " AND saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            }
        } else{
            //no tiene sucursal ni cartera
            if (isset($cuota) && $cuota != null) {
                //si tiene atraso agrega en and
                $query = $query . " AND saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            } else{
                //no tiene sucursal ni prestamo ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
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
                $query = $query . " AND saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            } else{
                //no tiene producto ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($cuota) && $cuota != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            } else{
                //no tiene tipo debito ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
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
                $query = $query . " AND saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            }
        } else{
            //no tiene cartera
            if (isset($cuota) && $cuota != null) {
                //si tiene atraso agrega en and
                $query = $query . " WHERE saldo $signoCuota " . $cuota;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND nroDiasSobregiro $signoDias " . $dias;
                }
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " WHERE nroDiasSobregiro $signoDias " . $dias;
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
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th>Numero de Cliente</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th>Saldo</th>
                                            <th style='display:none;'>Acuerdo</th>
                                            <th style='display:none;'>Exceso</th>
                                            <th style='display:none;'>Rechazo</th>
                                            <th>Dias de Sobregiro</th>
                                            <th>Dias Saldo Deudor</th>
                                            <th style='display:none;'>Primer Vencimiento</th>
                                            <th>Promedio de Mes</th>
                                            <th>Promedio semestral</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
			$primerVencimiento = isset($row['primerVencimiento']) ? $row['primerVencimiento']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['moneda']}</td>
                <td>{$row['saldo2']}</td>
                <td style='display:none;'>{$row['acuerdo2']}</td>
                <td style='display:none;'>{$row['exceso2']}</td>
                <td style='display:none;'>{$row['rechazo2']}</td>
                <td>{$row['nroDiasSobregiro']}</td>
                <td>{$row['nroDiasSaldoDeudor']}</td>
                <td style='display:none;'>{$primerVencimiento}</td>
                <td>{$row['promedioMes2']}</td>
                <td>{$row['promedio1802']}</td>
                <td class='text-center' title='Ver detalles cuenta corriente'>
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


