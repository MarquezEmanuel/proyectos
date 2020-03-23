<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$numeroCliente = $_POST['numeroCliente'];
$cliente = $_POST['cliente'];
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
$query = "SELECT * FROM [3altaCliente] ";

if (isset($cliente) && $cliente != null) {
    $query = $query . " WHERE nombreCliente LIKE '%" . $cliente . "%'";
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
        <table id='tb_buscar_alta' class='table table-striped table-bordered' border='3' style='width: 100%'>
            <colgroup>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 23%'/>
                <col style='width: 8%'/>
            </colgroup>
            <thead style='background-color:#024d85;color:white;'>
                <tr>
                    <th>Numero de Cliente</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Fecha Alta</th>
                    <th style='display:none;'>Usuario alta</th>
                    <th style='display:none;'>Fecha de nacimiento</th>
                    <th style='display:none;'>Edad</th>
                    <th>Detalles</th>
                </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fechaNacimiento = isset($row['fechaNacimiento']) ? $row['fechaNacimiento']->format('d/m/Y') : "";
            $fechaAlta = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $nombreUsuario = utf8_encode($row['nombreUsuario']);
            $print = $print . "
            <tr>
                <td>{$row['numeroCliente']}</td>
                <td>{$nombreCliente}</td>
                <td>{$nombreUsuario}</td>
                <td>{$fechaAlta}</td>
                <td style='display:none;'>{$row['usuarioAlta']}</td>
                <td style='display:none;'>{$fechaNacimiento}</td>
                <td style='display:none;'>{$row['edad']}</td>
                <td class='text-center' title='Ir a ver detalles de alta'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='../../lib/img/SHOW.png' class='detallesAlta' name='{$row['id']}' width='18' height='18' > 
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

