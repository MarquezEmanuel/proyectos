<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX

$producto = $_POST['producto'];
$pagare = $_POST['pagare'];
$sucursal = $_POST['sucursal'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select * FROM [3pagaresCancelados] ";

if (isset($pagare) && $pagare != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE numeroPagare = " . $pagare;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND codigoSucursalDeposito = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND producto = " . $producto ;
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
            //si tiene cartera agrega en and
            $query = $query . " AND PRODUCTO = " . $producto;
        } 
    }
} else {
    //no tiene documento
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE codigoSucursalDeposito = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND producto = " . $producto;
        } 
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
             //si tiene cartera empieza el where
            $query = $query . " WHERE producto = " . $producto;
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
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Codigo de Cliente</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th>Producto</th>
                                            <th>Pagare</th>
                                            <th>Fecha Liquidacion</th>
                                            <th style='display:none;'>Fecha de Vencimiento</th>
                                            <th>Descripcion</th>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Nombre Sucursal Deposito</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
		$fila = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['nombreCliente']);
			$fechaLiquidacion = isset($row['fechaLiquidacion']) ? $row['fechaLiquidacion']->format('d/m/Y') : "";
			$fechaVencimiento = isset($row['fechaVencimiento']) ? $row['fechaVencimiento']->format('d/m/Y') : "";
            $print = $print . "
            <tr id='{$fila}'>
                <td>{$row['codigoCliente']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td>{$row['producto']}</td>
                <td>{$row['numeroPagare']}</td>
                <td>{$fechaLiquidacion}</td>
                <td style='display:none;'>{$fechaVencimiento}</td>
                <td>{$row['descripcion']}</td>
                <td>{$row['codigoSucursalDeposito']}</td>
                <td style='display:none;'>{$row['nombreSucursalDeposito']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info detallesCobranzasTC' name='{$fila}'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
			$fila++;
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


