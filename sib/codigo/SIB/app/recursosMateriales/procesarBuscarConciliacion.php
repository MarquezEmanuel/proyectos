<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";


// RECIBE LOS DATOS ENVIADOS POR AJAX

$desde = $_POST['desde'];
$hasta = $_POST['hasta'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *,convert(varchar,cast(debe as money),1) AS debe2,convert(varchar,cast(haber as money),1) AS haber2,convert(varchar,cast(montoSFB as money),1) AS montoSFB2 FROM [9conciliacionContable]";


if (isset($desde) && $desde != null && isset($hasta) && $hasta != null) {
			$desde = date("d/m/Y", strtotime($desde));
			$hasta = date("d/m/Y", strtotime($hasta));
		    $desde = $desde . " 00:00:00";
			$hasta = $hasta . " 23:59:59";
        //si tiene sucursal agrega en and
        $query = $query . " WHERE fechaImputacion between '" . $desde . "' and '". $hasta."'";
    }

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;


if ($result) {
    $filas = sqlsrv_has_rows($result);
	$sumaSCB = $sumaSFB = 0;
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#144c75;color:white;'>
                                        <tr>
                                            <th>Sucursal Destino</th>
											<th>Fecha Imputacion</th>
                                            <th>Tipo de Asiento</th>
                                            <th>Numero de Asiento</th>
											<th>Sucursal de Origen</th>
											<th>Fecha de Proceso</th>
											<th style='display:none;'>Descripcion</th>
											<th>Debe</th>
											<th>Haber</th>
											<th>Monto SFB</th>
											<th style='display:none;'>Origen</th>
											<th style='display:none;'>Transaccion</th>
											<th style='display:none;'>Causal</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$sumaSCB = $sumaSCB + $row['debe'];
			$sumaSFB = $sumaSFB + $row['haber'];
			$fechaImputacion = isset($row['fechaImputacion']) ? $row['fechaImputacion']->format('d/m/Y') : "";
			$fechaProceso = isset($row['fechaProceso']) ? $row['fechaProceso']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['sucursalDestino']}</td>
				<td>{$fechaImputacion}</td>
                <td>{$row['tipoAsiento']}</td>
				<td>{$row['numeroAsiento']}</td>
				<td>{$row['sucursalOrigen']}</td>
				<td>{$fechaProceso}</td>
				<td style='display:none;'>{$row['descripcion']}</td>
				<td>{$row['debe2']}</td>
				<td>{$row['haber2']}</td>
				<td>{$row['montoSFB2']}</td>
				<td style='display:none;'>{$row['origen']}</td>
				<td style='display:none;'>{$row['transaccion']}</td>
				<td style='display:none;'>{$row['causal']}</td>
            </tr>";
        }
		$resta = $sumaSCB - $sumaSFB;
		$sumaSCB = number_format($sumaSCB, 2, ',', '.');
		$sumaSFB = number_format($sumaSFB, 2, ',', '.');
		$resta = number_format($resta, 2, ',', '.');
		$print = $print . "
				<tfoot>
				<tr>
					<th>Total SCB: {$sumaSCB} -- Total SFB: {$sumaSFB} -- Diferencia: {$resta}</th>
				</tr>
				</tfoot>
			";
        $print = $print . "</tbody></table>
        ";
    }  else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    // OCURRIO UN ERROR 
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    echo $query;
}

echo $print;


