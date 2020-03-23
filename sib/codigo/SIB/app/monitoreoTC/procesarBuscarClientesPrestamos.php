<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuit = $_POST['CUIT'];
$producto = $_POST['producto'];
$fallecidos = $_POST['fallecidos'];
$visa = $_POST['visa'];
$master = $_POST['master'];

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(CAPITALREAL as money),1) AS CAPITALREAL2, convert(varchar,cast(SALDOREAL as money),1) AS SALDOREAL2,"
        . "convert(varchar,cast(SOLICITADO as money),1) AS SOLICITADO2, convert(varchar,cast(MSALANT as money),1) AS MSALANT2 ,
			convert(varchar,cast(MSALACT as money),1) AS MSALACT2, convert(varchar,cast(MIMPORTE as money),1) AS MIMPORTE2,
			convert(varchar,cast(VSALANT as money),1) AS VSALANT2, convert(varchar,cast(VSALACT as money),1) AS VSALACT2,
			convert(varchar,cast(VIMPORTE as money),1) AS VIMPORTE2, convert(varchar,cast(MDEUDA as money),1) AS MDEUDA2,
			convert(varchar,cast(VDEUDA as money),1) AS VDEUDA2
		FROM [7prestamosTC] ";

if (isset($cuit) && $cuit != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE CUIT = " . $cuit;
    if (isset($producto) && $producto != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND PRODUCTO = " . $producto;
        if (isset($fallecidos) && $fallecidos != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "AND FALLECIDO " . $fallecidos;
            if (isset($visa) && $visa != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }else{
                //no tiene atraso
                if (isset($master) && $master != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }
        } else{
            //no tiene cartera
            if (isset($visa) && $visa != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            } else{
                //no tiene cartera ni atraso
                if (isset($master) && $master != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($fallecidos) && $fallecidos != null) {
            //si tiene cartera agrega en and
            $query = $query . "AND FALLECIDO " . $fallecidos;
            if (isset($visa) && $visa != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }
        } else{
            //no tiene sucursal ni cartera
            if (isset($visa) && $visa != null) {
                //si tiene atraso agrega en and
                $query = $query . " AND VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            } else{
                //no tiene sucursal ni prestamo ni atraso
                if (isset($master) && $master != null) {
                    //si tiene monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }
        }
    }
} else {
    //no tiene documento
    if (isset($producto) && $producto != null) {
        //si tiene sucursal empieza el where
        $query = $query . " WHERE PRODUCTO = " . $producto;
        if (isset($fallecidos) && $fallecidos != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . "AND FALLECIDO " . $fallecidos;
            if (isset($visa) && $visa != null) {
                //si tiene sucursal y cartera y atraso agrega en and
                $query = $query . " AND VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            } else{
                //no tiene producto ni atraso
                if (isset($master) && $master != null) {
                    //si tiene sucursal y cartera y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }
        } else{
            //no tiene producto ni prestamo
            if (isset($visa) && $visa != null) {
                //si tiene sucursal y atraso agrega en and
                $query = $query . " AND VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene sucursal y atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            } else{
                //no tiene tipo debito ni atraso
                if (isset($master) && $master != null) {
                    //si tiene sucursal y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }
        }
    } else {
        //no tiene sucursal
        if (isset($fallecidos) && $fallecidos != null) {
             //si tiene cartera empieza el where
            $query = $query . "WHERE FALLECIDO " . $fallecidos;
            if (isset($visa) && $visa != null) {
                //si tiene cartera y atraso agrega en and
                $query = $query . " AND VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene cartera y atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            } else{
                //no tiene atraso
                if (isset($master) && $master != null) {
                    //si tiene cartera y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            }
        } else{
            //no tiene cartera
            if (isset($visa) && $visa != null) {
                //si tiene atraso agrega en and
                $query = $query . " WHERE VCUENTA = " . $visa;
                if (isset($master) && $master != null) {
                    //si tiene atraso y monto agrega en and
                    $query = $query . " AND MCUENTA = " . $master;
                }
            } else{
                //no tiene atraso
                if (isset($master) && $master != null) {
                    //si tiene monto agrega en and
                    $query = $query . " WHERE MCUENTA = " . $master;
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
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Codigo Cliente</th>
                                            <th>CUIT</th>
                                            <th style='display:none;'>DNI</th>
                                            <th>Nombre y Apellido</th>
                                            <th style='display:none;'>Producto</th>
                                            <th>Numero de Prestamo</th>
                                            <th style='display:none;'>Vencimiento</th>
                                            <th style='display:none;'>Capital</th>
                                            <th style='display:none;'>Saldo</th>
                                            <th style='display:none;'>Monto Solicitado</th>
                                            <th style='display:none;'>Fecha de Fallecimiento</th>
                                            <th style='display:none;'>Cuenta Master</th>
                                            <th style='display:none;'>Relacion Master</th>
                                            <th>Estado Master</th>
                                            <th>MTU Master</th>
                                            <th style='display:none;'>Saldo Anterior Master</th>
											<th>Saldo Actual Master</th>
											<th style='display:none;'>Ultima Fecha de Ajuste Master</th>
											<th style='display:none;'>Importe de Ajuste Master</th>
											<th style='display:none;'>Importe de Deuda Master</th>
											<th style='display:none;'>Cuenta Visa</th>
                                            <th style='display:none;'>Relacion Visa</th>
                                            <th>Estado Visa</th>
                                            <th>MTU Visa</th>
                                            <th style='display:none;'>Saldo Anterior Visa</th>
											<th>Saldo Actual Visa</th>
											<th style='display:none;'>Ultima Fecha de Ajuste Visa</th>
											<th style='display:none;'>Importe de Ajuste Visa</th>
											<th style='display:none;'>Importe de Deuda Visa</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['NOMBRE']);
			$vencimiento = isset($row['VENCIMIENTO']) ? $row['VENCIMIENTO']->format('d/m/Y') : "";
			$fallecido = isset($row['FALLECIDO']) ? $row['FALLECIDO']->format('d/m/Y') : "";
			$fechaMaster = isset($row['MFECHA']) ? $row['MFECHA']->format('d/m/Y') : "";
			$fechaVisa = isset($row['VFECHA']) ? $row['VFECHA']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['IDCLIENTE']}</td>
                <td>{$row['CUIT']}</td>
                <td style='display:none;'>{$row['DNI']}</td>
                <td>{$nombre}</td>
                <td style='display:none;'>{$row['PRODUCTO']}</td>
                <td>{$row['NROPRESTAMO']}</td>
                <td style='display:none;'>{$vencimiento}</td>
                <td style='display:none;'>{$row['CAPITALREAL2']}</td>
                <td style='display:none;'>{$row['SALDOREAL2']}</td>
                <td style='display:none;'>{$row['SOLICITADO2']}</td>
                <td style='display:none;'>{$fallecido}</td>
                <td style='display:none;'>{$row['MCUENTA']}</td>
                <td style='display:none;'>{$row['MRELACION']}</td>
                <td>{$row['MESTADO']}</td>
                <td>{$row['MMTU']}</td>
                <td style='display:none;'>{$row['MSALANT2']}</td>
				<td>{$row['MSALACT2']}</td>
				<td style='display:none;'>{$fechaMaster}</td>
				<td style='display:none;'>{$row['MIMPORTE2']}</td>
				<td style='display:none;'>{$row['MDEUDA2']}</td>
				<td style='display:none;'>{$row['VCUENTA']}</td>
				<td style='display:none;'>{$row['VRELACION']}</td>
				<td>{$row['VESTADO']}</td>
				<td>{$row['VMTU']}</td>
				<td style='display:none;'>{$row['VSALANT2']}</td>
				<td>{$row['VSALACT2']}</td>
				<td style='display:none;'>{$fechaVisa}</td>
				<td style='display:none;'>{$row['VIMPORTE2']}</td>
				<td style='display:none;'>{$row['VDEUDA2']}</td>
                <td class='text-center' title='Ver detalles de la tarjeta en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesClientesPrestamos' name='{$row['ID']}' width='18' height='18' > 
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


