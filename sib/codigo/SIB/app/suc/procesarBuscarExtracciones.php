<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cliente = $_POST['cliente'];
$numeroCuenta = $_POST['cuenta'];
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
$query = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [3mayores15] WHERE sucursal = {$_SESSION['sucursal']}";

if (isset($cliente) && $cliente != null) {
    $query = $query . " AND nombre LIKE '%" . $cliente . "%'";
    if (isset($numeroCuenta) && $numeroCuenta != null) {
        $query = $query . " AND cuenta = " . $numeroCuenta;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($numeroCuenta) && $numeroCuenta != null) {
        $query = $query . "AND cuenta = " . $numeroCuenta;
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
        <table id='tb_buscar_extracciones' class='table table-striped table-bordered' border='3' style='width: 100%'>
            <colgroup>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 8%'/>
            </colgroup>
            <thead style='background-color:#024d85;color:white;'>
                <tr>
                    <th style='display:none;'>Causal</th>
                    <th style='display:none;'>Transaccion</th>
                    <th style='display:none;'>Sucursal</th>
                    <th style='display:none;'>Digito</th>
                    <th style='display:none;'>Fecha</th>
                    <th style='display:none;'>Usuario</th>
                    <th>Numero de cuenta</th>
                    <th>Monto</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th style='display:none;'>Sucursal pago</th>
                    <th style='display:none;'>Tarjeta SAV</th>
                    <th style='display:none;'>Sucursal origen</th>
                    <th style='display:none;'>Titular</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
			$nombre = utf8_encode($row['nombre']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['causal']}</td>
                <td style='display:none;'>{$row['transaccion']}</td>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['usuario']}</td>
                <td>{$row['cuenta']}</td>
                <td>{$row['monto2']}</td>
                <td>{$nombre}</td>
                <td>{$row['producto']}</td>
                <td style='display:none;'>{$row['sucursalPago']}</td>
                <td style='display:none;'>{$row['tarjetaSAV']}</td>
                <td style='display:none;'>{$row['sucursalOrigen']}</td>
                <td style='display:none;'>{$row['titular']}</td>

                <td class='text-center' title='Ir a ver detalles de la Extraccion'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesExtracciones' name='{$row['id']}' width='18' height='18' > 
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
    echo $query;
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $print;


