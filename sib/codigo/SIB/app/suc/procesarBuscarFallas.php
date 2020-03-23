<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$usuario = $_POST['usuario'];
$supervisor = $_POST['supervisor'];
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
$query = "SELECT *,convert(varchar,cast(montoTransaccion as money),1) AS monto2 FROM [3fallas] WHERE sucursalCuenta = {$_SESSION['sucursal']} ";

if (isset($usuario) && $usuario != null) {
    $query = $query . " AND usuario LIKE '%" . $usuario . "%'";
    if (isset($supervisor) && $supervisor != null) {
        $query = $query . " AND supervisor = " . $supervisor;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($supervisor) && $supervisor != null) {
        $query = $query . "AND supervisor = " . $supervisor;
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
        <table id='tb_buscar_fallas' class='table table-striped table-bordered' border='3' style='width: 100%'>
            <colgroup>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 8%'/>
            </colgroup>
            <thead style='background-color:#024d85;color:white;'>
                <tr>
                    <th style='display:none;'>Sucursal cuenta</th>
                    <th style='display:none;'>Numero cuenta</th>
                    <th style='display:none;'>Numero sucursal origen</th>
                    <th style='display:none;'>Numero comprobante</th>
                    <th style='display:none;'>Moneda</th>
                    <th>Usuario</th>
                    <th>Supervisor</th>
                    <th style='display:none;'>Numero de secuencia</th>
                    <th style='display:none;'>Categoria transaccion</th>
                    <th style='display:none;'>Estado transaccion</th>
                    <th style='display:none;'>Tipo transaccion</th>
                    <th style='display:none;'>Fecha transaccion</th>
                    <th style='display:none;'>Hora sistema</th>
                    <th>Nombre Transaccion</th>
                    <th>Monto</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fechaTransaccion']) ? $row['fechaTransaccion']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursalCuenta']}</td>
                <td style='display:none;'>{$row['numeroCuenta']}</td>
                <td style='display:none;'>{$row['numeroSucursalOrigen']}</td>
                <td style='display:none;'>{$row['numeroComprobante']}</td>
                <td style='display:none;'>{$row['moneda']}</td>
                <td>{$row['usuario']}</td>
                <td>{$row['supervisor']}</td>
                <td style='display:none;'>{$row['numeroSecuencia']}</td>
                <td style='display:none;'>{$row['categoriaTransaccion']}</td>
                <td style='display:none;'>{$row['estadoTransaccion']}</td>
                <td style='display:none;'>{$row['tipoTransaccion']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['horaSistema']}</td>
                <td>{$row['nombreTransaccion']}</td>
                <td>{$row['monto2']}</td>
                <td class='text-center' title='Ir a ver detalles de fallas'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesFallas' name='{$row['id']}' width='18' height='18' > 
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