<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuenta = $_POST['cuenta'];
$cliente = $_POST['cliente'];
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

if (isset($fechaInicio) && $fechaInicio != null) {
    $fechaInicio = date("d/m/Y", strtotime($fechaInicio));
    $fechaInicio = $fechaInicio . " 00:00:00";
}
if (isset($fechaFin) && $fechaFin != null) {
    $fechaFin = date("d/m/Y", strtotime($fechaFin));
    $fechaFin = $fechaFin . " 23:59:00";
}

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [3prestamosConCuentaAsociada] WHERE sucursalCuenta = {$_SESSION['sucursal']} ";

if (isset($cliente) && $cliente != null) {
    $query = $query . " AND cliente LIKE '%" . $cliente . "%'";
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND cuenta = " . $cuenta;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . "AND cuenta = " . $cuenta;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
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
        <table id='tb_buscar_cuotas' class='table table-striped table-bordered' border='3' style='width: 100%'>
            <colgroup>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 8%'/>
            </colgroup>
            <thead style='background-color:#024d85;color:white;'>
                <tr>
                    <th style='display:none;'>Transaccion</th>
                    <th style='display:none;'>Causal</th>
                    <th style='display:none;'>Nombre transaccion</th>
                    <th style='display:none;'>Tipo cuenta</th>
                    <th style='display:none;'>Producto cuenta</th>
                    <th style='display:none;'>Sucursal cuenta</th>
                    <th>Numero de Cuenta</th>
                    <th style='display:none;'>Digito cuenta</th>
                    <th>Nombre de la Cuenta</th>
                    <th style='display:none;'>Producto prestamo</th>
                    <th style='display:none;'>Sucursal Prestamo</th>
                    <th style='display:none;'>Prestamo</th>
                    <th>Cliente</th>
                    <th style='display:none;'>Sucursal operacion</th>
                    <th style='display:none;'>Usuario transaccion</th>
                    <th>Usuario</th>
                    <th style='display:none;'>Cliente prestamo</th>
                    <th style='display:none;'>Cliente cuenta</th>
                    <th style='display:none;'>Fecha transaccion</th>
                    <th style='display:none;'>Monto</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fechaTransaccion']) ? $row['fechaTransaccion']->format('d/m/Y') : "";
            $nombreTransaccion = utf8_encode($row['nombreTransaccion']);
            $nombreCuenta = utf8_encode($row['nombreCuenta']);
            $cliente = utf8_encode($row['cliente']);
            $nombreUsuario = utf8_encode($row['nombreUsuario']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['transaccion']}</td>
                <td style='display:none;'>{$row['causal']}</td>
                <td style='display:none;'>{$nombreTransaccion}</td>
                <td style='display:none;'>{$row['tipoCuenta']}</td>
                <td style='display:none;'>{$row['productoCuenta']}</td>
                <td style='display:none;'>{$row['sucursalCuenta']}</td>
                <td>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digitoCuenta']}</td>
                <td>{$nombreCuenta}</td>
                <td style='display:none;'>{$row['productoPrestamo']}</td>
                <td style='display:none;'>{$row['sucursalPrestamo']}</td>
                <td style='display:none;'>{$row['prestamo']}</td>
                <td>{$cliente}</td>
                <td style='display:none;'>{$row['sucursalOperacion']}</td>
                <td style='display:none;'>{$row['usuarioTransaccion']}</td>
                <td>{$nombreUsuario}</td>
                <td style='display:none;'>{$row['clientePrestamo']}</td>
                <td style='display:none;'>{$row['clienteCuenta']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['monto2']}</td>
                <td class='text-center' title='Ir a ver detalles de la Cuotas'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesCuotas' name='{$row['id']}' width='18' height='18' > 
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
}

echo $print;


