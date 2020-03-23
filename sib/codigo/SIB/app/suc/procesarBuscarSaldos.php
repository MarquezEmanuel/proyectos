<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuenta = $_POST['cuenta'];
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
$query = "SELECT * FROM [3saldosSucursales] WHERE numeroSucursal = {$_SESSION['sucursal']} ";

if (isset($cuenta) && $cuenta != null) {
    $query = $query . " AND cuenta LIKE '%" . $cuenta."%'";
    if ($fechaInicio && $fechaFin) {
        $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
    }
} else {
    if ($fechaInicio && $fechaFin) {
        $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
    }
}
// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_saldos' class='table table-striped table-bordered' border='3' style='width: 100%'>
            <colgroup>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 8%'/>
            </colgroup>
            <thead style='background-color:#024d85;color:white;'>
                <tr>
                    <th style='display:none;'>Cuenta</th>
                                            <th>Numero de sucursal</th>
                                            <th>Saldo SCB</th>
                                            <th>Saldo SFB</th>
                                            <th>Diferencia</th>
                                            <th>Detalles</th>
                </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td>{$row['numeroSucursal']}</td>
                <td>{$row['saldoSCB']}</td>
                <td>{$row['saldoSFB']}</td>
                <td>{$row['diferencias']}</td>

                <td class='text-center' title='Ir a ver detalles de saldos'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesSaldos' name='{$row['id']}' width='18' height='18' > 
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

