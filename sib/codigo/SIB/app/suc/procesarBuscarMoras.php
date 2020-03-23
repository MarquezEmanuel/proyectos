<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuenta = $_POST['cuenta'];
$sucursal = $_POST['sucursal'];
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
$query = "SELECT *,convert(varchar,cast(deuda as money),1) AS deuda2,convert(varchar,cast(interes as money),1) AS interes2 FROM [3morasCPD] WHERE sucursal = {$_SESSION['sucursal']}";

if (isset($sucursal) && $sucursal != null) {
    $query = $query . " AND numeroCliente = '" . $sucursal . "'";
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND numeroCuenta = " . $cuenta;
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
        $query = $query . "AND numeroCuenta = " . $cuenta;
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
        <table id='tb_buscar_moras' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Producto</th>
                                            <th>Numero de Cuenta</th>
                                            <th>Numero de Cliente</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th>Deuda</th>
                                            <th>Interes</th>
                                            <th>Fecha de Vencimiento</th>
                                            <th style='display:none;'>Cheque</th>
                                            <th>Diferencia</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td>{$row['numeroCuenta']}</td>
                <td>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$row['nombreCliente']}</td>
                <td>{$row['deuda2']}</td>
                <td>{$row['interes2']}</td>
                <td>{$fecha}</td>
                <td style='display:none;'>{$row['cheque']}</td>
                <td>{$row['diferencia']}</td>
                <td class='text-center' title='Ir a ver detalles de Moras'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMoras' name='{$row['id']}' width='18' height='18' > 
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


