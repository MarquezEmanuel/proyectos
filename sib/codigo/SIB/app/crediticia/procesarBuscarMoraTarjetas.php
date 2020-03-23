<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuenta = $_POST['cuenta'];
$sucursal = $_POST['sucursal'];
$documento = $_POST['elegido'];
$mora = $_POST['mora'];
$signoMora = $_POST['signoMora'];
$dias = $_POST['dias'];
$signoDias = $_POST['signoDias'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(total as money),1) AS total2, convert(varchar,cast(minimo as money),1) AS minimo2,"
        . "convert(varchar,cast(mora as money),1) AS mora2, convert(varchar,cast(saldo as money),1) AS saldo2 FROM [4moraTarjetas] ";

if (isset($cuenta) && $cuenta != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE cuenta = " . $cuenta;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($documento) && $documento != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "AND tipoCuenta IN(";
                        for ($i = 0; $i < count($documento); $i++) {
                            $i = $i +1;
                            if($i == count($documento)){
                                $i = $i -1;
                                $query = $query . "'$documento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$documento[$i]',";
                            }
                        }
            if (isset($mora) && $mora != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }
        } else{
            //no tiene cartera
            if (isset($mora) && $mora != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            } else{
                //no tiene cartera ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($documento) && $documento != null) {
            //si tiene cartera agrega en and
            $query = $query . "AND tipoCuenta IN(";
                        for ($i = 0; $i < count($documento); $i++) {
                            $i = $i +1;
                            if($i == count($documento)){
                                $i = $i -1;
                                $query = $query . "'$documento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$documento[$i]',";
                            }
                        }
            if (isset($mora) && $mora != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }
        } else{
            //no tiene sucursal ni cartera
            if (isset($mora) && $mora != null) {
                //si tiene atraso agrega en and
                $query = $query . " AND mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            } else{
                //no tiene sucursal ni prestamo ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }
        }
    }
} else {
    //no tiene documento
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE sucursal = " . $sucursal;
        if (isset($documento) && $documento != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "AND tipoCuenta IN(";
                        for ($i = 0; $i < count($documento); $i++) {
                            $i = $i +1;
                            if($i == count($documento)){
                                $i = $i -1;
                                $query = $query . "'$documento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$documento[$i]',";
                            }
                        }
            if (isset($mora) && $mora != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            } else{
                //no tiene producto ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($mora) && $mora != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            } else{
                //no tiene tipo debito ni atraso
                if (isset($dias) && $dias != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($documento) && $documento != null) {
             //si tiene cartera empieza el where
            $query = $query . "WHERE tipoCuenta IN(";
                        for ($i = 0; $i < count($documento); $i++) {
                            $i = $i +1;
                            if($i == count($documento)){
                                $i = $i -1;
                                $query = $query . "'$documento[$i]')";
                            }else{
                                $i = $i -1;
                                $query = $query . "'$documento[$i]',";
                            }
                        }
            if (isset($mora) && $mora != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene cartera y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            }
        } else{
            //no tiene cartera
            if (isset($mora) && $mora != null) {
                //si tiene atraso agrega en and
                $query = $query . " WHERE mora $signoMora " . $mora;
                if (isset($dias) && $dias != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND diasAtraso $signoDias " . $dias;
                }
            } else{
                //no tiene atraso
                if (isset($dias) && $dias != null) {
                    //si tiene monto agrega en and
                    $query = $query . " WHERE diasAtraso $signoDias " . $dias;
                }
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
                                            <th>Marca</th>
                                            <th>Sucursal</th>
                                            <th>Cuenta Tarjeta</th>
                                            <th style='display:none;'>Total</th>
                                            <th style='display:none;'>Minimo</th>
                                            <th>Mora</th>
                                            <th>Dias de Atraso</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th>Documento</th>
                                            <th style='display:none;'>Tipo de cuenta</th>
                                            <th style='display:none;'>Sucursal Cuenta</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th style='display:none;'>Saldo</th>
                                            <th style='display:none;'>Codigo de Cliente</th>
                                            <th style='display:none;'>Producto</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCliente']);
            $print = $print . "
            <tr>
                <td>{$row['marca']}</td>
                <td>{$row['sucursal']}</td>
                <td>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$row['total2']}</td>
                <td style='display:none;'>{$row['minimo2']}</td>
                <td>{$row['mora2']}</td>
                <td>{$row['diasAtraso']}</td>
                <td style='display:none;'>{$nombreCliente}</td>
                <td>{$row['documento']}</td>
                <td style='display:none;'>{$row['tipoCuenta']}</td>
                <td style='display:none;'>{$row['sucursalCuenta']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td style='display:none;'>{$row['saldo2']}</td>
                <td style='display:none;'>{$row['codigoCliente']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td class='text-center' title='Ver detalles de la tarjeta en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMoraTarjetas' name='{$row['id']}' width='18' height='18' > 
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


