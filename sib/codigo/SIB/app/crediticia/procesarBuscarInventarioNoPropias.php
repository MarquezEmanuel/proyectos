<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$sucursal = $_POST['sucursal'];
$producto = $_POST['producto'];
$cuil = $_POST['estudio'];
$deuda = $_POST['plazo'];
$signoDeuda = $_POST['signoPlazo'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *, convert(varchar,cast(capital as money),1) AS capital2, convert(varchar,cast(capitalOrigen as money),1) AS capitalOrigen2 from [4lineasNoPropias]
 ";

if (isset($sucursal) && $sucursal != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE SUCURSAL = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND PRODUCTO = " . $producto;
				if (isset($cuil) && $cuil != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND documento = " . $cuil;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DIASMORA $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DIASMORA $signoDeuda " . $deuda;
					}
				}
            } else{
				if (isset($cuil) && $cuil != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND documento = " . $cuil;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DIASMORA $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DIASMORA $signoDeuda " . $deuda;
					}
				}
			}
}else{
	if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE PROD = " . $producto;
				if (isset($cuil) && $cuil != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND documento = " . $cuil;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DIASMORA $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DIASMORA $signoDeuda " . $deuda;
					}
				}
            } else{
				if (isset($cuil) && $cuil != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " WHERE documento = " . $cuil;
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " AND DIASMORA $signoDeuda " . $deuda;
					}
				} else{
					if (isset($deuda) && $deuda != null) {
					//si tiene sucursal y tipo debito y saldo y minimo agrega en and
					$query = $query . " WHERE DIASMORA $signoDeuda " . $deuda;
					}
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
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Operacion</th>
                                            <th>Nombre</th>
                                            <th>Dias de Mora</th>
                                            <th>CUIL/CUIT</th>
                                            <th>F. Alta</th>
                                            <th style='display:none;'>F. Vencimiento Final</th>
                                            <th style='display:none;'>F. Vencimiento Pago</th>
                                            <th>S. Capital</th>
                                            <th style='display:none;'>N. Cliente</th>
                                            <th>F. Ultimo Pago</th>
                                            <th>F. Primer Impago</th>
											<th>Capital Origen</th>
											<th>F. Primer Vencimiento</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombre']);
            $print = $print . "
            <tr>
                <td>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['operacion']}</td>
                <td>{$nombre}</td>
                <td>{$row['diasMora']}</td>
                <td>{$row['documento']}</td>
                <td>{$row['fechaAlta']}</td>
                <td style='display:none;'>{$row['fechaVencimientoFinal']}</td>
                <td style='display:none;'>{$row['fechaVencimientoPago']}</td>
                <td>{$row['capital2']}</td>
                <td style='display:none;'>{$row['numeroCliente']}</td>
                <td>{$row['fechaUltimoPago']}</td>
                <td>{$row['fechaPrimerImpago']}</td>
				<td>{$row['capitalOrigen2']}</td>
				<td>{$row['fechaPrimerVencimiento']}</td>
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


