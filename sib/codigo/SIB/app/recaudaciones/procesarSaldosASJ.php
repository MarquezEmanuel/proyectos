<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$cuenta = $_POST['cuenta'];
$digito = $_POST['digito'];

$clientes = "select * from [10cuentasASJ]";

/*saca campos para poner dentro de un IN()*/

$cuits = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $clientes);
 while ($row = sqlsrv_fetch_array($cuits, SQLSRV_FETCH_ASSOC)) {
            $suc = $suc . "{$row['sucursal']},";
			$cuen = $cuen . "{$row['cuenta']},";
			$dig = $dig . "{$row['digito']},";
        }
$suc = trim($suc, ',');
$cuen = trim($cuen, ',');
$dig = trim($dig, ',');

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *, convert(varchar,cast(SALDO_HOY as money),1) AS SALDO_HOY2 from openquery (M4000SF,'select

CCU_MONED MONEDA,

CCU_PRODU PRODUCTO,

CCU_OFICI SUCURSAL,

CCUNUMCUE CUENTA,

CCUDIGVER DIGITO,

CCOESTCUE ESTADO,

SCO_IDENT CLIENTE,

CNO_CUENT NOMBRE,

CSATOTHOY SALDO_HOY,

SYSDATE DIA_HORA

from sfb_acmol where

(ccu_ofici in (".$suc.") and ccunumcue in (".$cuen.") and ccudigver in (".$dig."))
       
       order by ccu_ofici, ccunumcue

') ";

if (isset($cuenta) && $cuenta != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE cuenta LIKE '%" . $cuenta . "%'";
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal LIKE '%" . $sucursal . "%'";
		if (isset($digito) && $digito != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND digito LIKE '%" . $digito . "%'";
    } 
    } else{
		if (isset($digito) && $digito != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND digito LIKE '%" . $digito . "%'";
    }
	} 
} else {				
    //no tiene cuenta
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE sucursal LIKE '%" . $sucursal . "%'";
		if (isset($digito) && $digito != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND digito LIKE '%" . $digito . "%'";
    }
    }else{
		if (isset($digito) && $digito != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE digito LIKE '%" . $digito . "%'";
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
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#0a4b7a;color:white;'>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th>Cuenta</th>
											<th>Digito</th>
                                            <th>Nombre</th>
											<th>Saldo</th>
											<th style='display:none;'>Moneda</th>
											<th style='display:none;'>Producto</th>
											<th style='display:none;'>Estado</th>
											<th style='display:none;'>Cliente</th>
											<th style='display:none;'>Dia/Hora</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$dia = isset($row['DIA_HORA']) ? $row['DIA_HORA']->format('d/m/Y H:m:s') : "";
            $nombre = utf8_encode($row['NOMBRE']);
			if($row['SALDO_HOY2'] >= 0){
				$print = $print . "
            <tr>
                <td>{$row['SUCURSAL']}</td>
                <td>{$row['CUENTA']}</td>
				<td>{$row['DIGITO']}</td>
				<td>{$nombre}</td>
				<td>{$row['SALDO_HOY2']}</td>
				<td style='display:none;'>{$row['MONEDA']}</td>
				<td style='display:none;'>{$row['PRODUCTO']}</td>
				<td style='display:none;'>{$row['ESTADO']}</td>
				<td style='display:none;'>{$row['CLIENTE']}</td>
				<td style='display:none;'>{$dia}</td>
            </tr>";
			} else {
				$print = $print . "
            <tr style='color:red;'>
                <td>{$row['SUCURSAL']}</td>
                <td>{$row['CUENTA']}</td>
				<td>{$row['DIGITO']}</td>
				<td>{$nombre}</td>
				<td>{$row['SALDO_HOY2']}</td>
				<td style='display:none;'>{$row['MONEDA']}</td>
				<td style='display:none;'>{$row['PRODUCTO']}</td>
				<td style='display:none;'>{$row['ESTADO']}</td>
				<td style='display:none;'>{$row['CLIENTE']}</td>
				<td style='display:none;'>{$dia}</td>
            </tr>";
			}
            
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


