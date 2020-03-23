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
$query = "SELECT * FROM [3crucePPMAPySAV] WHERE pcuOfici = {$_SESSION['sucursal']} ";
if (isset($cuenta) && $cuenta != null) {
    $query = $query . " AND scoIdent = " . $cuenta;
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
        <table id='tb_buscar_pagare' class='table table-striped table-bordered' border='3' style='width: 100%'>
            <colgroup>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 8%'/>
            </colgroup>
            <thead style='background-color:#024d85;color:white;'>
                <tr>
                    <th style='display:none;'>PCU sucursal origen</th>
                    <th style='display:none;'>PCU numero de cuenta</th>
                    <th style='display:none;'>PCU producto</th>
                    <th style='display:none;'>Estado prestamo</th>
                    <th>Numero de Cuenta</th>
                    <th>Cliente</th>
                    <th>Fecha liquidacion</th>
                    <th>Fecha Vencimiento</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {


            $fechaLiquidacion = isset($row['fechaLiquidacion']) ? $row['fechaLiquidacion']->format('d/m/Y') : "";
            $fechaVencimiento = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
            $nombre = utf8_encode($row['snoCliente']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['pcuOfici']}</td>
                <td style='display:none;'>{$row['pcuNumeroCuenta']}</td>
                <td style='display:none;'>{$row['pcuProducto']}</td>
                <td style='display:none;'>{$row['estadoPrestamo']}</td>
                <td>{$row['scoIdent']}</td>
                <td>{$nombre}</td>
                <td>{$fechaLiquidacion}</td>
                <td>{$fechaVencimiento}</td>

                <td class='text-center' title='Ir a ver detalles del Pagare'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesPagare' name='{$row['id']}' width='18' height='18' > 
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

