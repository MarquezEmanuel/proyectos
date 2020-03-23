<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *,convert(varchar,cast(montoSFB as money),1) AS montoSFB2,convert(varchar,cast(debe as money),1) AS debe2,convert(varchar,cast(haber as money),1) AS haber2 from [9conciliacionContable] where transaccion IS NULL AND descripcion NOT LIKE '%CRED. VS. ACRED%' AND descripcion NOT LIKE '%TRASF.AUTOMATICA DE SALDOS%'";

if (isset($sucursal) && $sucursal != null) {
    //si tiene cuenta empieza el where
    $query = $query . " AND sucursalOrigen = " . $sucursal;
    if (isset($desde) && $desde != null && isset($hasta) && $hasta != null) {
			$desde = date("d/m/Y", strtotime($desde));
			$hasta = date("d/m/Y", strtotime($hasta));
		    $desde = $desde . " 00:00:00";
			$hasta = $hasta . " 23:59:59";
        //si tiene sucursal agrega en and
        $query = $query . " AND fechaImputacion between '" . $desde . "' and '". $hasta."'";
    } 
} else {				
    //no tiene cuenta
    if (isset($desde) && $desde != null && isset($hasta) && $hasta != null) {
		$desde = date("d/m/Y", strtotime($desde));
		$hasta = date("d/m/Y", strtotime($hasta));
		$desde = $desde . " 00:00:00";
		$hasta = $hasta . " 23:59:59";
        //si tiene sucursal agrega en and
        $query = $query . " AND fechaImputacion between '" . $desde . "' and '". $hasta."'";
    } 
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

$_SESSION['buscar'] = $query;

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#144c75;color:white;'>
                                        <tr>
                                            <th>Sucursal Destino</th>
											<th>Fecha Imputacion</th>
                                            <th style='display:none;'>Tipo de Asiento</th>
                                            <th style='display:none;'>Numero de Asiento</th>
											<th>Sucursal de Origen</th>
											<th>Fecha de Proceso</th>
											<th>Descripcion</th>
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
			$fechaImputacion = isset($row['fechaImputacion']) ? $row['fechaImputacion']->format('d/m/Y') : "";
			$fechaProceso = isset($row['fechaProceso']) ? $row['fechaProceso']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['sucursalDestino']}</td>
				<td>{$fechaImputacion}</td>
                <td style='display:none;'>{$row['tipoAsiento']}</td>
				<td style='display:none;'>{$row['numeroAsiento']}</td>
				<td>{$row['sucursalOrigen']}</td>
				<td>{$fechaProceso}</td>
				<td>{$row['descripcion']}</td>
				<td>{$row['debe2']}</td>
				<td>{$row['haber2']}</td>
				<td>{$row['montoSFB2']}</td> 
				<td style='display:none;'>{$row['origen']}</td>
				<td style='display:none;'>{$row['transaccion']}</td>
				<td style='display:none;'>{$row['causal']}</td>
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
    echo $query;
}

echo $print;


