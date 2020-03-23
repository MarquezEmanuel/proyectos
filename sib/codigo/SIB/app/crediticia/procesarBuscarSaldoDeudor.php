<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$numeroCliente = $_POST['numeroCliente'];
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
$query = "SELECT *,convert(varchar,cast(saldo as money),1) AS saldo2 FROM [3ACMOL] ";

if (isset($sucursal) && $sucursal != null) {
    $query = $query . " WHERE sucursal = " . $sucursal;
    if (isset($numeroCliente) && $numeroCliente != null) {
        $query = $query . " AND numeroCliente = " . $numeroCliente;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($numeroCliente) && $numeroCliente != null) {
        $query = $query . "WHERE numeroCliente = " . $numeroCliente;
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
        <table id='tb_buscar_saldoDeudor' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                        <th>Cuenta</th>
                                        <th style='display:none;'>Producto</th>
                                        <th style='display:none;'>Definicion estado</th>
                                        <th style='display:none;'>Saldo</th>
                                        <th style='display:none;'>Sucursal</th>
                                        <th>Numero de Cliente</th>
                                        <th>Nombre de Cliente</th>
                                        <th>Estado</th>
                                        <th>Ultimo Movimiento</th>
                                        <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fechaUltimoMovimiento = isset($row['fechaUltimoMovimiento']) ? $row['fechaUltimoMovimiento']->format('d/m/Y') : "";
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['definicionEstado']}</td>
                <td style='display:none;'>{$row['saldo2']}</td>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td>{$row['numeroCliente']}</td>
                <td>{$nombreCliente}</td>
                <td>{$row['estado']}</td>
                <td>{$fechaUltimoMovimiento}</td>
                <td class='text-center' title='Ir a ver detalles de las Cuentas'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesSaldoDeudor' name='{$row['id']}' width='18' height='18' > 
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


