<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$transaccion = $_POST['transaccion'];
$depositante = $_POST['depositante'];
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
$query = "SELECT *,convert(varchar,cast(monto as money),1) AS monto2 FROM [3transaccionIncorrecta] ";

if (isset($transaccion) && $transaccion != null) {
    $query = $query . " WHERE nombreTransaccion LIKE '%" . $transaccion . "%'";
    if (isset($depositante) && $depositante != null) {
        $query = $query . " AND documentoDepositante = " . $depositante;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($depositante) && $depositante != null) {
        $query = $query . "WHERE documentoDepositante = " . $depositante;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " WHERE fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
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
        <table id='tb_buscar_incorrecta' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th style='display:none;'>Numero de transaccion</th>
                                            <th>Nombre Transaccion</th>
                                            <th style='display:none;'>Concepto</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th>Nombre Depositante</th>
                                            <th>CUIL Depositante</th>
                                            <th style='display:none;'>Ordenante</th>
                                            <th style='display:none;'>CUIL Ordenante</th>
                                            <th style='display:none;'>Sucursal operacion</th>
                                            <th style='display:none;'>Usuario</th>
                                            <th style='display:none;'>Fecha</th>
                                            <th style='display:none;'>Numero de operacion</th>
                                            <th style='display:none;'>Monto</th>
                                            <th>Nombre Usuario</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $depositante = utf8_encode($row['depositante']);
            $ordenante = utf8_encode($row['ordenante']);
            $nombreUsuario = utf8_encode($row['nombreUsuario']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['causal']}</td>
                <td style='display:none;'>{$row['transaccion']}</td>
                <td>{$row['nombreTransaccion']}</td>
                <td style='display:none;'>{$row['concepto']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td>{$depositante}</td>
                <td>{$row['documentoDepositante']}</td>
                <td style='display:none;'>{$ordenante}</td>
                <td style='display:none;'>{$row['documentoOrdenante']}</td>
                <td style='display:none;'>{$row['sucursalOperacion']}</td>
                <td style='display:none;'>{$row['usuario']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['numeroOperacion']}</td>
                <td style='display:none;'>{$row['monto2']}</td>
                <td>{$nombreUsuario}</td>

                <td class='text-center' title='Ir a ver detalles de alta'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesIncorrecta' name='{$row['id']}' width='18' height='18' > 
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

