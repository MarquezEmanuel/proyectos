<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$movimiento = $_POST['movimiento'];
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
$query = "SELECT *,convert(varchar,cast(montoOrigen as money),1) AS montoOrigen2, convert(varchar,cast(montoPesos as money),1) AS montoPesos2 FROM [3movimientoSinDepositantes]";

if (isset($movimiento) && $movimiento != null) {
    $query = $query . " WHERE tipo LIKE '%" . $movimiento . "%'";
    if ($sucursal) {
        $query = $query . " AND codigoSucursal = " . $sucursal;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if ($sucursal) {
        $query = $query . " WHERE codigoSucursal = " . $sucursal;
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
        <table id='tb_buscar_movimientos' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Tipo</th>
                                            <th style='display:none;'>Concepto</th>
                                            <th style='display:none;'>Codigo Sucursal</th>
                                            <th>Numero de Cuenta</th>
                                            <th style='display:none;'>Digito Verificador</th>
                                            <th>Codigo de Moneda</th>
                                            <th>Usuario</th>
                                            <th style='display:none;'>Nombre Usuario</th>
                                            <th style='display:none;'>Fecha Valor</th>
                                            <th>Monto Origen</th>
                                            <th>Monto en Pesos</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fechaValor = isset($row['fechaValor']) ? $row['fechaValor']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['tipo']}</td>
                <td style='display:none;'>{$row['concepto']}</td>
                <td style='display:none;'>{$row['codigoSucursal']}</td>
                <td>{$row['numeroCuenta']}</td>
                <td style='display:none;'>{$row['digitoVerificador']}</td>
                <td>{$row['codigoMoneda']}</td>
                <td>{$row['codigoUsuario']}</td>
                <td style='display:none;'>{$row['nombreUsuario']}</td>
                <td style='display:none;'>{$fechaValor}</td>
                <td>{$row['montoOrigen2']}</td>
                <td>{$row['montoPesos2']}</td>

                <td class='text-center' title='Ir a ver detalles de los Movimientos'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMovimientos' name='{$row['id']}' width='18' height='18' > 
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


