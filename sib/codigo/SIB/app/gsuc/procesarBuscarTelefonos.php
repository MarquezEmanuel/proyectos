<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cliente = $_POST['cliente'];
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
$query = "SELECT * FROM [3telefonosTarjetas] ";

if (isset($cliente) && $cliente != null) {
    $query = $query . " WHERE numeroCliente LIKE '%" . $cliente . "%'";
    if (isset($sucursal) && $sucursal != null) {
        $query = $query . " AND sucursal = " . $sucursal;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($sucursal) && $sucursal != null) {
        $query = $query . "WHERE sucursal = " . $sucursal;
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
        <table id='tb_buscar_telefonos' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 10%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 17%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Numero de sucursal</th>
                                            <th style='display:none;'>Numero de Documento</th>
                                            <th>Descripcion</th>
                                            <th style='display:none;'>Fecha Gra</th>
                                            <th style='display:none;'>Fecha Ingreso</th>
                                            <th style='display:none;'>Numero de Cliente</th>
                                            <th>Nombre de Cliente</th>
                                            <th>Correo de Cliente</th>
                                            <th>Telefono SFB</th>
                                            <th>Telefono Engage</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $descripcion = utf8_encode($row['descripcion']);
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $correoCliente = utf8_encode($row['correoCliente']);
            $fechaGra = isset($row['fechaGra']) ? $row['fechaGra']->format('d/m/Y') : "";
            $fechaIngreso = isset($row['fechaIngreso']) ? $row['fechaIngreso']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['numeroDocumento']}</td>
                <td>{$descripcion}</td>
                <td style='display:none;'>{$fechaGra}</td>
                <td style='display:none;'>{$fechaIngreso}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
                <td>{$nombreCliente}</td>
                <td>{$correoCliente}</td>
                <td>{$row['telefonoSFB']}</td>
                <td>{$row['telefonoEngage']}</td>

                <td class='text-center' title='Ir a ver detalles de Telefonos'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesTelefonos' name='{$row['id']}' width='18' height='18' > 
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

