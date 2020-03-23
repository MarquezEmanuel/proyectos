<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cuit = $_POST['cuit'];
$sucursal = $_POST['sucursal'];
$producto = $_POST['producto'];
$cuenta = $_POST['cuenta'];
$embargos = $_POST['embargo'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "SELECT *, convert(varchar,cast(adhSumaMensual as money),1) AS adhSumaMensual2, convert(varchar,cast(montoTotal as money),1) AS montoTotal2,"
        . "convert(varchar,cast(montoExigible as money),1) AS montoExigible2, convert(varchar,cast(MME as money),1) AS MME2, "
        . "convert(varchar,cast(limite as money),1) AS limite2, convert(varchar,cast(valorUtilizado as money),1) AS valorUtilizado2,"
        . "convert(varchar,cast(valorUtilizadoTotal as money),1) AS valorUtilizadoTotal2, convert(varchar,cast(embMontoTotal as money),1) AS embMontoTotal2,"
		. "convert(varchar,cast(adcTotalMaestro as money),1) AS adcTotalMaestro2, convert(varchar,cast(adcTotalMaster as money),1) AS adcTotalMaster2,"
		. "convert(varchar,cast(adcTotalVisa as money),1) AS adcTotalVisa2, convert(varchar,cast(totalHaberesSFB as money),1) AS totalHaberesSFB2,"
		. "convert(varchar,cast(totalInterbanking as money),1) AS totalInterbanking2, convert(varchar,cast(disponible as money),1) AS disponible2"
        . " FROM [bd_sib].[dbo].[integradorBancaEmpresa]";

if (isset($cuit) && $cuit != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE documento = '" . $cuit . "'";
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND sucursal = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND producto =" . $producto;
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                }
        } else {
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND producto =" . $producto;
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                }
        } else {
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                }
        }
    }
} else {
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE sucursal = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " AND producto =" . $producto;
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                }
        } else {
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                }
        }
    } else {
        //no tiene sucursal
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y cartera agrega en and
            $query = $query . " WHERE producto =" . $producto;
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " AND cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                }
        } else {
                if (isset($cuenta) && $cuenta != null) {
                    //si tiene sucursal y cartera y atraso y monto agrega en and
                    $query = $query . " WHERE cuenta =" . $cuenta;
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "AND numeroBloqueos " . $embargos;
                    } 
                } else{
                    if (isset($embargos) && $embargos != null) {
                        //si tiene sucursal y cartera y atraso y monto agrega en and
                        $query = $query . "WHERE numeroBloqueos " . $embargos;
                    } 
                }
        }
    }
    
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_unificado' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th>Numero de CUIT</th>
                                            <th>Codigo de Cliente</th>
											<th>Sucursal</th>
                                            <th>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th>Producto</th>
											<th>Nombre de Cliente</th>
                                            <th>Estado de Cuenta</th>
                                            <th style='display:none;'>Correo</th>
                                            <th style='display:none;'>Telefono</th>
                                            <th style='display:none;'>Actividad AFIP</th>
                                            <th style='display:none;'>Mes Deuda Previsional</th>
											<th style='display:none;'>Tipo de Cuenta</th>
											<th style='display:none;'>Fecha de Alta</th>
											<th style='display:none;'>CBU</th>
											<th style='display:none;'>Mes situacion BCRA</th>
                                            <th style='display:none;'>Situacion BCRA</th>
                                            <th style='display:none;'>Ultima Fecha PAYCHECK</th>
                                            <th style='display:none;'>SITE EMPRESAS</th>
											<th style='display:none;'>Adhecion Depositaria Movimiento</th>
											<th style='display:none;'>Adhecion Depositaria Suma Mensual</th>
											<th style='display:none;'>Cheques Rechazados</th>
											<th style='display:none;'>Cheques Impagos</th>
                                            <th style='display:none;'>Dias Atraso</th>
											<th style='display:none;'>Monto Total</th>
											<th style='display:none;'>Monto Exigible</th>
                                            <th style='display:none;'>MME</th>
                                            <th style='display:none;'>Limite Plafond</th>
                                            <th style='display:none;'>Valor utilizado</th>
											<th style='display:none;'>Valor Utilizado Total</th> 
                                            <th style='display:none;'>Cantidad de Embargos</th>
                                            <th style='display:none;'>Embargos Monto Total</th>
                                            <th style='display:none;'>Numero de Bloqueo</th>
                                            <th style='display:none;'>Adhecion de Comercio Total Maestro</th>
                                            <th style='display:none;'>Adhecion de Comercio Total Master</th>
                                            <th style='display:none;'>Adhecion de Comercio Total Visa</th>
                                            <th style='display:none;'>Total Haberes SFB</th>                                            
                                            <th style='display:none;'>Total Interbanking</th>
											<th style='display:none;'>Valcetot</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombreCliente = utf8_encode($row['nombreCuenta']);
            $correo = utf8_encode($row['correo']);
			$ultimaFechaPayCheck = isset($row['ultimaFechaPayCheck']) ? $row['ultimaFechaPayCheck']->format('d/m/Y') : "";
			$fechaApertura = isset($row['fechaApertura']) ? $row['fechaApertura']->format('d/m/Y') : "";
			
			$print = $print . "
            <tr>
                <td>{$row['documento']}</td>
                <td>{$row['codigoCliente']}</td>
				<td>{$row['sucursal']}</td>
                <td>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td>{$row['producto']}</td>
				<td>{$nombreCliente}</td>
                <td>{$row['estadoCuenta']}</td>
                <td style='display:none;'>{$correo}</td>
                <td style='display:none;'>{$row['telefono']}</td>
                <td style='display:none;'>{$row['actividadAFIP']}</td>
                <td style='display:none;'>{$row['mesDeudaPrevisional']}</td>
				<td style='display:none;'>{$row['tipoCuenta']}</td>
				<td style='display:none;'>{$fechaApertura}</td>
				<td style='display:none;'>{$row['cbu']}</td>
				<td style='display:none;'>{$row['mesSituacionBCRA']}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$ultimaFechaPayCheck}</td>
                <td style='display:none;'>{$row['siteEmpresa']}</td>
				<td style='display:none;'>{$row['adhMovimientos']}</td>
				<td style='display:none;'>{$row['adhSumaMensual']}</td>
				<td style='display:none;'>{$row['chequesRechazados']}</td>
				<td style='display:none;'>{$row['chequesImpagos']}</td>
                <td style='display:none;'>{$row['diasAtraso']}</td>
				<td style='display:none;'>{$row['montoTotal2']}</td>
				<td style='display:none;'>{$row['montoExigible2']}</td>
                <td style='display:none;'>{$row['MME2']}</td>
                <td style='display:none;'>{$row['limite2']}</td>
                <td style='display:none;'>{$row['valorUtilizado2']}</td>
				<td style='display:none;'>{$row['valorUtilizadoTotal2']}</td>
                <td style='display:none;'>{$row['embargos']}</td>
                <td style='display:none;'>{$row['embMontoTotal2']}</td>
                <td style='display:none;'>{$row['numeroBloqueos']}</td>
                <td style='display:none;'>{$row['adcTotalMaestro2']}</td>
                <td style='display:none;'>{$row['adcTotalMaster2']}</td>
                <td style='display:none;'>{$row['adcTotalVisa2']}</td>
                <td style='display:none;'>{$row['totalHaberesSFB2']}</td>
                <td style='display:none;'>{$row['totalInterbanking2']}</td>
				<td style='display:none;'>{$row['disponible2']}</td>
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


