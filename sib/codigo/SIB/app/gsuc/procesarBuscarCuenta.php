<?php

include_once '../conf/BDConexion.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cliente = $_POST['cliente'];
$cuil = $_POST['cuil'];
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
$query = "SELECT * FROM [3cuentasInhabilitadas] ";

if (isset($cliente) && $cliente != null) {
    $query = $query . " WHERE nombreCliente LIKE '%" . $cliente . "%'";
    if (isset($cuil) && $cuil != null) {
        $query = $query . " AND cuit = " . $cuil;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($cuil) && $cuil != null) {
        $query = $query . "WHERE cuit = " . $cuil;
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

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cuenta' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 8%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Numero de cuenta</th>
                                            <th style='display:none;'>Digito Verificador</th>
                                            <th>Nombre de Cliente</th>
                                            <th>CUIT-CUIL</th>
                                            <th>Codigo de Usuario</th>
                                            <th>Nombre Cuenta</th>
                                            <th style='display:none;'>Codigo de Producto</th>
                                            <th style='display:none;'>Tipo de relacion</th>
                                            <th style='display:none;'>Fecha Alta</th>
                                            <th style='display:none;'>Fecha Fin</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fechaInicio = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
            $fechaFin = isset($row['fechaFin']) ? $row['fechaFin']->format('d/m/Y') : "";
            $nombreCuenta = utf8_encode($row['nombreCuenta']);
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['numeroCuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td>{$nombreCliente}</td>
                <td>{$row['cuit']}</td>
                <td>{$row['numeroCliente']}</td>
                <td>{$nombreCuenta}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['tipoRelacion']}</td>
                <td style='display:none;'>{$fechaInicio}</td>
                <td style='display:none;'>{$fechaFin}</td>

                <td class='text-center' title='Ir a ver detalles de la Cuenta'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCuenta' name='{$row['id']}' width='18' height='18' > 
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
