<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuit = $_POST['cuit'];
$sucursal = $_POST['sucursal'];
$mora = $_POST['mora'];
$signoMora = $_POST['signoMora'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(montoTotal as money),1) AS montoTotal2, convert(varchar,cast(montoExigible as money),1) AS montoExigible2,"
        . "convert(varchar,cast(MME as money),1) AS MME2 FROM [bd_sib].[dbo].[moraComercial] ";

if (isset($cuit) && $cuit != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE numeroCuit = " . $cuit;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($mora) && $mora != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND diasAtraso $signoMora" . $mora ;
        } 
    } else {
        //no tiene sucursal
        if (isset($mora) && $mora != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND diasAtraso $signoMora" . $mora ;
        } 
    }
} else {
    //no tiene documento
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE sucursal = " . $sucursal;
        if (isset($mora) && $mora != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND diasAtraso $signoMora" . $mora ;
        } 
    } else {
        //no tiene sucursal
        if (isset($mora) && $mora != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " WHERE diasAtraso $signoMora" . $mora ;
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
        <table id='tb_buscar_MoraTarjetas' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th>Numero de Cliente</th>
                                            <th>CUIT</th>
                                            <th>Nombre de Cliente</th>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Dias de Atraso</th>
                                            <th>Monto Total</th>
                                            <th>Monto Exigible</th>
                                            <th style='display:none;'>MME</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Cartera</th>
                                            <th style='display:none;'>Proyeccion</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td>{$row['numeroCliente']}</td>
                <td>{$row['numeroCuit']}</td>
                <td>{$nombreCliente}</td>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['diasAtraso']}</td>
                <td>{$row['montoTotal2']}</td>
                <td>{$row['montoExigible2']}</td>
                <td style='display:none;'>{$row['MME2']}</td>
                <td>{$row['producto']}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td style='display:none;'>{$row['proyeccion']}</td>
                <td class='text-center' title='Ver detalles de la tarjeta en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMoraTarjetas' name='{$row['numeroCliente']}' width='18' height='18' > 
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
    echo $query;
}

echo $print;


