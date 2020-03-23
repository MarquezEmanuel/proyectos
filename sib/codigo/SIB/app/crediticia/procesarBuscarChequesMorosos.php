<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuenta = $_POST['cuenta'];
$sucursal = $_POST['sucursal'];
$producto = $_POST['producto'];
$monto = $_POST['monto'];
$signoSaldo = $_POST['signoSaldo'];
$dias = $_POST['dias'];
$signoMinimo = $_POST['signoMinimo'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(monto as money),1) AS monto2, convert(varchar,cast(deuda as money),1) AS deuda2 FROM [5chequesCobradosMorosos] ";

if (isset($cuenta) && $cuenta != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE cuenta = " . $cuenta;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND productoCuenta = " . $producto ;
            if (isset($monto) && $monto != null) {
                //si tiene sucursal y tipo debito y saldo agrega en and
                $query = $query . " AND monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            }else{
                //no tiene saldo
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y tipo debito y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            }
        } else{
            //no tiene tipo debito
            if (isset($monto) && $monto != null) {
                //si tiene sucursal y saldo agrega en and
                $query = $query . " AND monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            } else{
                //no tiene tipo debito ni saldo
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
            //si tiene tipo debito agrega en and
            $query = $query . " AND productoCuenta = " . $producto;
            if (isset($monto) && $monto != null) {
                //si tiene tipo debito y saldo agrega en and
                $query = $query . " AND monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            }
        } else{
            //no tiene sucursal ni tipo debito
            if (isset($monto) && $monto != null) {
                //si tiene saldo agrega en and
                $query = $query . " AND monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            } else{
                //no tiene sucursal ni prestamo ni saldo
                if (isset($dias) && $dias != null) {
                    //si tiene minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                } 
            }
        }
    }
} else {				
    //no tiene cuenta
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE sucursal = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito agrega en and
            $query = $query . " AND productoCuenta = " . $producto;
            if (isset($monto) && $monto != null) {
                //si tiene sucursal y tipo debito y saldo agrega en and
                $query = $query . " AND monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                } 
            } else{
                //no tiene producto ni saldo
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y tipo debito y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($monto) && $monto != null) {
                //si tiene sucursal y saldo agrega en and
                $query = $query . " AND monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            } else{
                //no tiene tipo debito ni saldo
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
             //si tiene tipo debito empieza el where
            $query = $query . " WHERE productoCuenta = " . $producto;
            if (isset($monto) && $monto != null) {
                //si tiene tipo debito y saldo agrega en and
                $query = $query . " AND monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene tipo debito y saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                } 
            } else{
                //no tiene saldo
                if (isset($dias) && $dias != null) {
                    //si tiene tipo debito y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                } 
            }
        } else{
            //no tiene tipo debito
            if (isset($monto) && $monto != null) {
                //si tiene saldo agrega en and
                $query = $query . " WHERE monto $signoSaldo " . $monto;
                if (isset($dias) && $dias != null) {
                    //si tiene saldo y minimo agrega en and
                    $query = $query . " AND diasAtraso $signoMinimo " . $dias;
                }
            } else{
                //no tiene saldo
                if (isset($dias) && $dias != null) {
                    //si tiene minimo agrega en and
                    $query = $query . " WHERE diasAtraso $signoMinimo " . $dias;
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
        <table id='tb_buscar_cheques' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th style='display:none;'>Nombre Cuenta</th>
                                            <th style='display:none;'>CUIL</th>
                                            <th>Producto</th>
                                            <th>Depositante</th>
                                            <th style='display:none;'>Ordenante</th>
                                            <th style='display:none;'>Documento del Cobrador</th>
                                            <th>Monto</th>
                                            <th style='display:none;'>Fecha</th>
                                            <th style='display:none;'>Codigo Usuario</th>
                                            <th>Nombre Usuario</th>
                                            <th style='display:none;'>Sucursal de Pago</th>
                                            <th style='display:none;'>CUIL deudor</th>
                                            <th>Dias de Atraso</th>
                                            <th>Deuda</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td style='display:none;'>{$row['nombreCuenta']}</td>
                <td style='display:none;'>{$row['cuilCuenta']}</td>
                <td>{$row['productoCuenta']}</td>
                <td>{$row['depositante']}</td>
                <td style='display:none;'>{$row['ordenante']}</td>
                <td style='display:none;'>{$row['documentoCobrador']}</td>
                <td>{$row['monto2']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['codigoUsuario']}</td>
                <td>{$row['nombreUsuario']}</td>
                <td style='display:none;'>{$row['sucursalPago']}</td>
                <td style='display:none;'>{$row['cuilDeudor']}</td>
                <td>{$row['diasAtraso']}</td>
                <td>{$row['deuda2']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesChequesCobrados' name='{$row['id']}' width='18' height='18' > 
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


