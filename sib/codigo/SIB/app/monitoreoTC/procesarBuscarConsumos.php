<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$rubro = $_POST['rubro'];
$cuenta = $_POST['cuenta'];
$tipo = $_POST['tipo'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$transaccion = $_POST['transaccion'];

$desde = date("d-m-Y", strtotime($desde));
$desde = $desde . " 00:00:00";
$hasta = date("d-m-Y", strtotime($hasta));
$hasta = $hasta . " 23:59:00";

if($tipo[0] == 'MC'){
	if($transaccion[0] == 'costo'){
		$trans = "TransacCodi = 6601";
	}else{
		$trans = "TransacCodi != 6601";
	}
	$query = "SELECT Cuenta_Nume cuenta,
	   TransacCodi transaccion,
	   CuponNume cupon,
	   OriFecha fecha,
	   MoviDescip movimiento,
	   CodSucurMovimien sucursal,
	   ImpVenta importe,
	   FecPresentacion fechaPresentacion,
	   RubroComercio rubro,
	   ComercioMaster comercio
  FROM [BSCBASES3].[Smartopen].[dbo].[CredenMoviConsumos] 
  where OriFecha between '$desde' and '$hasta' AND $trans";
  
  if (isset($rubro) && $rubro != null) {
    $query = $query . " AND rubroComercio = " . $rubro;
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta_Nume = " . $cuenta;
	}
} else {
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta_Nume = " . $cuenta;
	}
}
//VISA CONSULTA
}else{
	if($transaccion[0] == 'costo'){
		$trans = "CodOp = 523";
	}else{
		$trans = "CodOp != 523";
	}
	$query = "SELECT SucurCodi sucursal,
	   Cuenta cuenta,
	   FOrigen fecha,
	   DenEst movimiento,
	   MoneOrig moneda,
	   ImpOrig importe,
	   FPres fechaPresentacion,
	   CodOp transaccion,
	   Rubro rubro,
	   Cupon cupon
  FROM [BSCBASES3].[Smartopen].[dbo].[VisaCompras]
  where FOrigen between '$desde' and '$hasta'
  AND ImpOrig != 0.00 AND $trans";
  
  if (isset($rubro) && $rubro != null) {
    $query = $query . " AND Rubro = " . $rubro;
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta = " . $cuenta;
	}
} else {
    if (isset($cuenta) && $cuenta != null) {
        $query = $query . " AND Cuenta = " . $cuenta;
	}
}
}



// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);


if($tipo[0] == 'MC'){
	if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Cuenta</th>
											<th>Transaccion</th>
											<th>Cupon</th>
                                            <th>Fecha Origen</th>
                                            <th>Movimiento</th>
                                            <th>Sucursal</th>
											<th>Importe</th>
											<th>Fecha Presentacion</th>
											<th>Rubro</th>
											<th>Comercio</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$movimiento = utf8_encode($row['movimiento']);
			$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
			$fechaPresentacion = isset($row['fechaPresentacion']) ? $row['fechaPresentacion']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['cuenta']}</td>
				<td>{$row['transaccion']}</td>
				<td>{$row['cupon']}</td>
                <td>{$fecha}</td>
                <td>{$movimiento}</td>
                <td>{$row['sucursal']}</td>
				<td>{$row['importe']}</td>
				<td>{$fechaPresentacion}</td>
				<td>{$row['rubro']}</td>
				<td>{$row['comercio']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
    echo $query;
}
}else{
	//TABLA DE VISA
	if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th>Cuenta</th>
                                            <th>Fecha Origen</th>
                                            <th>Movimiento</th>
											<th>Moneda</th>
											<th>Importe</th>
											<th>Fecha Presentacion</th>
											<th>Transaccion</th>
											<th>Rubro</th>
											<th>Cupon</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$movimiento = utf8_encode($row['movimiento']);
			$fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
			$fechaPresentacion = isset($row['fechaPresentacion']) ? $row['fechaPresentacion']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td>{$row['cuenta']}</td>
                <td>{$fecha}</td>
                <td>{$movimiento}</td>
				<td>{$row['moneda']}</td>
				<td>{$row['importe']}</td>
				<td>{$fechaPresentacion}</td>
				<td>{$row['transaccion']}</td>
				<td>{$row['rubro']}</td>
				<td>{$row['cupon']}</td>
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
}


echo $print;


