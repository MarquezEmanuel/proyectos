<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$producto = $_POST['producto'];
$sucursal = $_POST['sucursal'];
$prestamo = $_POST['prestamo'];
$cliente = $_POST['cliente'];
$monto = $_POST['monto'];
$signo = $_POST['signo'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *,convert(varchar,cast(saldoTerceros as money),1) AS saldoTerceros2 FROM [4cobroNoAplicado] WHERE producto <> 590 ";

if (isset($producto) && $producto != null) {
    //si tiene producto empieza el where
    $query = $query . " AND producto = " . $producto;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($prestamo) && $prestamo != null) {
            //si tiene sucursal y prestamo agrega en and
            $query = $query . " AND cuentaCredito = " . $prestamo;
            if (isset($cliente) && $cliente != null) {
                //si tiene sucursal y prestamo y cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y prestamo y cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }else{
                //no tiene cliente
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y prestamo y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }
        } else{
            //no tiene prestamo
            if (isset($cliente) && $cliente != null) {
                //si tiene sucursal y cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            } else{
                //no tiene prestamo ni cliente
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($prestamo) && $prestamo != null) {
            //si tiene prestamo agrega en and
            $query = $query . " AND cuentaCredito = " . $prestamo;
            if (isset($cliente) && $cliente != null) {
                //si tiene prestamo y cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene prestamo y cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }
        } else{
            //no tiene sucursal ni prestamo
            if (isset($cliente) && $cliente != null) {
                //si tiene cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            } else{
                //no tiene sucursal ni prestamo ni cliente
                if (isset($monto) && $monto != null) {
                    //si tiene saldo agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }
        }
    }
} else {
    //no tiene producto
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($prestamo) && $prestamo != null) {
            //si tiene sucursal y prestamo agrega en and
            $query = $query . " AND cuentaCredito = " . $prestamo;
            if (isset($cliente) && $cliente != null) {
                //si tiene sucursal y prestamo y cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y prestamo y cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            } else{
                //no tiene producto ni cliente
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y prestamo y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($cliente) && $cliente != null) {
                //si tiene sucursal y cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            } else{
                //no tiene prestamo ni cliente
                if (isset($monto) && $monto != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($prestamo) && $prestamo != null) {
             //si tiene prestamo empieza el where
            $query = $query . " AND cuentaCredito = " . $prestamo;
            if (isset($cliente) && $cliente != null) {
                //si tiene prestamo y cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene prestamo y cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            } else{
                //no tiene cliente
                if (isset($monto) && $monto != null) {
                    //si tiene prestamo y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            }
        } else{
            //no tiene prestamo
            if (isset($cliente) && $cliente != null) {
                //si tiene cliente agrega en and
                $query = $query . " AND numeroCliente = " . $cliente;
                if (isset($monto) && $monto != null) {
                    //si tiene cliente y monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
                }
            } else{
                //no tiene cliente
                if (isset($monto) && $monto != null) {
                    //si tiene monto agrega en and
                    $query = $query . " AND saldoTerceros $signo " . $monto;
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
        <table id='tb_buscar_cobro' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 8%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Producto</th>
                                            <th style='display:none;'>Sucursal</th>
                                            <th>Cuenta Prestamo</th>
                                            <th>Saldo de Terceros</th>
                                            <th>Numero de Cliente</th>
                                            <th style='display:none;'>Cliente</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td>{$row['producto']}</td>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td>{$row['cuentaCredito']}</td>
                <td>{$row['saldoTerceros2']}</td>
                <td>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td class='text-center' title='Ver detalles del cobro'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobro' name='{$row['id']}' width='18' height='18' > 
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


