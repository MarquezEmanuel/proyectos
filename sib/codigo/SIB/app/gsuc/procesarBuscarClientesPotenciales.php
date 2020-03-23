<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$nombre = $_POST['nombre'];
$numero = $_POST['numero'];
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
$query = "SELECT * FROM [3clientesPotenciales] ";

if (isset($nombre) && $nombre != null) {
    $query = $query . " WHERE nombreCliente LIKE '%" . $nombre . "%'";
    if (isset($numero) && $numero != null) {
        $query = $query . " AND nroCliente = " . $numero;
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    } else {
        if ($fechaInicio && $fechaFin) {
            $query = $query . " AND fechaActualizacion between '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        }
    }
} else {
    if (isset($numero) && $numero != null) {
        $query = $query . "WHERE nroCliente = " . $numero;
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
        <table id='tb_buscar_potenciales' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Nombre de Cliente</th>
                                            <th>Numero de Cliente</th>
                                            <th>Sucursal</th>
											<th>Documento</th>
											<th>Estado</th>
                                            <th>Fecha Alta</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fechaAlta']) ? $row['fechaAlta']->format('d/m/Y') : "";
            $nombreCliente = utf8_encode($row['nombreCliente']);
			$sql2 = "select * from openquery(M4000SF,'select ANO_LARGA from SFB_BSMTG MTG
							inner join SFB_BSMCL MCL ON MTG.ACO_CODIG = LPAD(MCL.SCOESTPER,2,0)
							WHERE MTG.ACO_CODIG <> '' '' AND MTG.ACO_TABLA = ''ESTCLIEN'' AND MCL.SCO_IDENT = {$row['nroCliente']}')";
			$result2 = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql2);
			$row2  = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC);
            $print = $print . "
            <tr>
                <td>{$row['usuario']}</td>
                <td>{$nombreCliente}</td>
                <td>{$row['nroCliente']}</td>
                <td>{$row['sucursal']}</td>
				<td>{$row['documento']}</td>
				<td>{$row2['ANO_LARGA']}</td>
                <td>{$fecha}</td>
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

