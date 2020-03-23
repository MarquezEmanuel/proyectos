<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$marca = $_POST['marca'];
$cuenta = $_POST['cuenta'];


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select * from openquery([BSCBASES3], 'SELECT ''MC'' marca, 
                                            SAL.cuenta_nume cuenta, 
                                            SAL.ope_esta estado, 
                                            SAL.liqui_meto MTU, 
                                            SAL.actualcierrefecha cierre, 
                                            SAL.pesos_actual_saldo saldoActual,
                                            M02.saldoMes02, M03.saldoMes03,
                                            M04.saldoMes04, M05.saldoMes05,
                                            M06.saldoMes06, M07.saldoMes07,
                                            M08.saldoMes08, M09.saldoMes09,
                                            M10.saldoMes10, M11.saldoMes11,
                                            M12.saldoMes12,
                                            SAL.dolar_actual_saldo saldoActualDolar,
                                            M02.saldoDolarMes02,M03.saldoDolarMes03,
                                            M04.saldoDolarMes04, M05.saldoDolarMes05,
                                            M06.saldoDolarMes06, M07.saldoDolarMes07,
                                            M08.saldoDolarMes08, M09.saldoDolarMes09,
                                            M10.saldoDolarMes10, M11.saldoDolarMes11,
                                            M12.saldoDolarMes12
                                FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                INNER JOIN (SELECT DISTINCT cuenta_nume cuenta
                                            FROM [SmartOpen].[dbo].[CredenSaldos]
                                            WHERE (pesos_actual_saldo < 0 OR dolar_actual_saldo < 0) AND 
                                                    actualCierreFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE())-1,0))) FAV ON FAV.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes02, SAL.dolar_actual_saldo saldoDolarMes02
                                        FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                        WHERE SAL.actualCierreFecha >= DATEADD(MM, -2, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										SAL.actualCierreFecha < DATEADD(MM, -1, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M02 ON M02.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes03, SAL.dolar_actual_saldo saldoDolarMes03
                                        FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                        WHERE SAL.actualCierreFecha >= DATEADD(MM, -3, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										SAL.actualCierreFecha < DATEADD(MM, -2, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M03 ON M03.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes04, SAL.dolar_actual_saldo saldoDolarMes04
                                        FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                        WHERE SAL.actualCierreFecha >= DATEADD(MM, -4, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND
										SAL.actualCierreFecha < DATEADD(MM, -3, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M04 ON M04.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes05, SAL.dolar_actual_saldo saldoDolarMes05
                                        FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                        WHERE SAL.actualCierreFecha >= DATEADD(MM, -5, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										SAL.actualCierreFecha < DATEADD(MM, -4, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M05 ON M05.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes06, SAL.dolar_actual_saldo saldoDolarMes06
                                            FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                            WHERE SAL.actualCierreFecha >= DATEADD(MM, -6, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											SAL.actualCierreFecha < DATEADD(MM, -5, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M06 ON M06.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes07, SAL.dolar_actual_saldo saldoDolarMes07
                                            FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                            WHERE SAL.actualCierreFecha >= DATEADD(MM, -7, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											SAL.actualCierreFecha < DATEADD(MM, -6, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M07 ON M07.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes08, SAL.dolar_actual_saldo saldoDolarMes08
                                            FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                            WHERE SAL.actualCierreFecha >= DATEADD(MM, -8, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											SAL.actualCierreFecha < DATEADD(MM, -7, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M08 ON M08.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes09, SAL.dolar_actual_saldo saldoDolarMes09
                                            FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                            WHERE SAL.actualCierreFecha >= DATEADD(MM, -9, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											SAL.actualCierreFecha < DATEADD(MM, -8, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M09 ON M09.cuenta = SAL.cuenta_nume
                                LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes10, SAL.dolar_actual_saldo saldoDolarMes10
                                            FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                            WHERE SAL.actualCierreFecha >= DATEADD(MM, -10, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											SAL.actualCierreFecha < DATEADD(MM, -9, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M10 ON M10.cuenta = SAL.cuenta_nume
								LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes11, SAL.dolar_actual_saldo saldoDolarMes11
                                            FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                            WHERE SAL.actualCierreFecha >= DATEADD(MM, -11, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											SAL.actualCierreFecha < DATEADD(MM, -10, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M11 ON M11.cuenta = SAL.cuenta_nume
								LEFT JOIN (SELECT SAL.cuenta_nume cuenta, SAL.pesos_actual_saldo saldoMes12, SAL.dolar_actual_saldo saldoDolarMes12
                                        FROM [SmartOpen].[dbo].[CredenSaldos] SAL
                                        WHERE SAL.actualCierreFecha >= DATEADD(MM, -12, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										SAL.actualCierreFecha < DATEADD(MM, -11, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M12 ON M12.cuenta = SAL.cuenta_nume
                                WHERE (SAL.pesos_actual_saldo < 0 OR SAL.dolar_actual_saldo < 0) AND SAL.actualCierreFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE())-1,0))') 
UNION ALL
select * from openquery([BSCBASES3], 'SELECT ''VISA'' marca, 
                                            SA.cuenta, 
                                            so.cuentaesta estado, 
                                            liqModeCodi MTU, 
                                            SA.actualcierreFecha cierre, 
                                            SA.actualpesossaldo saldoActual, 
                                            M02.saldoMes02,
                                            M03.saldoMes03,
                                            M04.saldoMes04,
                                            M05.saldoMes05,
                                            M06.saldoMes06,
                                            M07.saldoMes07,
                                            M08.saldoMes08,
                                            M09.saldoMes09,
                                            M10.saldoMes10,
                                            M11.saldoMes11,
                                            M12.saldoMes12, 
                                            SA.actualDolarImpo saldoActualDolar,
                                            M02.saldoDolarMes02,
                                            M03.saldoDolarMes03,
                                            M04.saldoDolarMes04,
                                            M05.saldoDolarMes05,
                                            M06.saldoDolarMes06,
                                            M07.saldoDolarMes07,
                                            M08.saldoDolarMes08,
                                            M09.saldoDolarMes09,
                                            M10.saldoDolarMes10,
                                            M11.saldoDolarMes11,
                                            M12.saldoDolarMes12
                                FROM [SmartOpen].[dbo].[visasaldos] SA 
                                INNER JOIN (SELECT DISTINCT SA.cuenta
                                            FROM [SmartOpen].[dbo].[visasaldos] SA
                                            WHERE (SA.actualpesossaldo < 0 or SA.actualDolarImpo < 0) AND 
                                            SA.actualCierreFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE())-1,0))) FAV ON FAV.cuenta = SA.cuenta
                                INNER JOIN [SmartOpen].[dbo].[visasocios] SO on SA.cuenta = SO.cuenta
                                LEFT JOIN (SELECT SA.cuenta,  SA.actualpesossaldo saldoMes02, SA.actualDolarImpo saldoDolarMes02
										   FROM [SmartOpen].[dbo].[visasaldos] SA 
										WHERE actualCierreFecha >= DATEADD(MM, -02, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											actualCierreFecha < DATEADD(MM, -01, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M02 ON M02.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes03, SA.actualDolarImpo saldoDolarMes03
                                            FROM [SmartOpen].[dbo].[visasaldos] SA
                                            WHERE actualCierreFecha >= DATEADD(MM, -03, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											actualCierreFecha < DATEADD(MM, -02, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M03 ON M03.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta,  SA.actualpesossaldo saldoMes04, SA.actualDolarImpo saldoDolarMes04
                                            FROM [SmartOpen].[dbo].[visasaldos] SA 
                                            WHERE actualCierreFecha >= DATEADD(MM, -04, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											actualCierreFecha < DATEADD(MM, -03, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M04 ON M04.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes05, SA.actualDolarImpo saldoDolarMes05
                                            FROM [SmartOpen].[dbo].[visasaldos] SA
                                            WHERE actualCierreFecha >= DATEADD(MM, -05, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
											actualCierreFecha < DATEADD(MM, -04, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M05 ON M05.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes06, SA.actualDolarImpo saldoDolarMes06
                                        FROM [SmartOpen].[dbo].[visasaldos] SA
                                        WHERE actualCierreFecha >= DATEADD(MM, -06, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										actualCierreFecha < DATEADD(MM, -05, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M06 ON M06.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes07, SA.actualDolarImpo saldoDolarMes07
                                            FROM [SmartOpen].[dbo].[visasaldos] SA
                                            WHERE actualCierreFecha >= DATEADD(MM, -07, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND
											actualCierreFecha < DATEADD(MM, -06, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M07 ON M07.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes08, SA.actualDolarImpo saldoDolarMes08
                                        FROM [SmartOpen].[dbo].[visasaldos] SA
                                        WHERE actualCierreFecha >= DATEADD(MM, -08, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										actualCierreFecha < DATEADD(MM, -07, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M08 ON M08.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta,  SA.actualpesossaldo saldoMes09, SA.actualDolarImpo saldoDolarMes09
                                        FROM [SmartOpen].[dbo].[visasaldos] SA
                                        WHERE actualCierreFecha >= DATEADD(MM, -09, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										actualCierreFecha < DATEADD(MM, -08, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M09 ON M09.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes10, SA.actualDolarImpo saldoDolarMes10
                                        FROM [SmartOpen].[dbo].[visasaldos] SA
                                        WHERE actualCierreFecha >= DATEADD(MM, -10, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND
										actualCierreFecha < DATEADD(MM, -09, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M10 ON M10.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes11, SA.actualDolarImpo saldoDolarMes11
                                        FROM [SmartOpen].[dbo].[visasaldos] SA
                                        WHERE actualCierreFecha >= DATEADD(MM, -11, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										actualCierreFecha < DATEADD(MM, -10, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M11 ON M11.cuenta = SA.cuenta
                                LEFT JOIN (SELECT SA.cuenta, SA.actualpesossaldo saldoMes12, SA.actualDolarImpo saldoDolarMes12
                                        FROM [SmartOpen].[dbo].[visasaldos] SA 
                                        WHERE actualCierreFecha >= DATEADD(MM, -12, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0))) AND 
										actualCierreFecha < DATEADD(MM, -11, DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE()),0)))) M12 ON M12.cuenta = SA.cuenta
                                WHERE (actualpesossaldo < 0 or actualDolarImpo < 0) AND actualCierreFecha >= DATEADD(s,0,DATEADD(mm, DATEDIFF(m,0,GETDATE())-1,0))')            
															  ";

if (isset($marca) && $marca != null) {
    //si tiene documento empieza el where
    $query = $query . " WHERE marca " . $marca[0];
    if (isset($cuenta) && $cuenta != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND cuenta = " . $cuenta;
    } 
} else {
    //no tiene documento
    if (isset($cuenta) && $cuenta != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE cuenta = " . $cuenta ;
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
                                            <th>Marca</th>
                                            <th>Cuenta</th>
											<th>Estado</th>
											<th>MTU</th>
											<th>Cierre</th>
											<th>Saldo Actual</th>
											<th style='display:none;'>Saldo Mes 2</th>
											<th style='display:none;'>Saldo Mes 3</th>
											<th style='display:none;'>Saldo Mes 4</th>
											<th style='display:none;'>Saldo Mes 5</th>
											<th style='display:none;'>Saldo Mes 6</th>
											<th style='display:none;'>Saldo Mes 7</th>
											<th style='display:none;'>Saldo Mes 8</th>
											<th style='display:none;'>Saldo Mes 9</th>
											<th style='display:none;'>Saldo Mes 10</th>
											<th style='display:none;'>Saldo Mes 11</th>
											<th style='display:none;'>Saldo Mes 12</th>
											<th>Saldo Actual Dolar</th>
											<th style='display:none;'>Saldo Mes 2 Dolar</th>
											<th style='display:none;'>Saldo Mes 3 Dolar</th>
											<th style='display:none;'>Saldo Mes 4 Dolar</th>
											<th style='display:none;'>Saldo Mes 5 Dolar</th>
											<th style='display:none;'>Saldo Mes 6 Dolar</th>
											<th style='display:none;'>Saldo Mes 7 Dolar</th>
											<th style='display:none;'>Saldo Mes 8 Dolar</th>
											<th style='display:none;'>Saldo Mes 9 Dolar</th>
											<th style='display:none;'>Saldo Mes 10 Dolar</th>
											<th style='display:none;'>Saldo Mes 11 Dolar</th>
											<th style='display:none;'>Saldo Mes 12 Dolar</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$cierre = isset($row['cierre']) ? $row['cierre']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td>{$row['marca']}</td>
                <td>{$row['cuenta']}</td>
				<td>{$row['estado']}</td>
				<td>{$row['MTU']}</td>
				<td>{$cierre}</td>
				<td>{$row['saldoActual']}</td>
				<td style='display:none;'>{$row['saldoMes02']}</td>
				<td style='display:none;'>{$row['saldoMes03']}</td>
				<td style='display:none;'>{$row['saldoMes04']}</td>
				<td style='display:none;'>{$row['saldoMes05']}</td>
				<td style='display:none;'>{$row['saldoMes06']}</td>
				<td style='display:none;'>{$row['saldoMes07']}</td>
				<td style='display:none;'>{$row['saldoMes08']}</td>
				<td style='display:none;'>{$row['saldoMes09']}</td>
				<td style='display:none;'>{$row['saldoMes10']}</td>
				<td style='display:none;'>{$row['saldoMes11']}</td>
				<td style='display:none;'>{$row['saldoMes12']}</td>
				<td>{$row['saldoActualDolar']}</td>
				<td style='display:none;'>{$row['saldoDolarMes02']}</td>
				<td style='display:none;'>{$row['saldoDolarMes03']}</td>
				<td style='display:none;'>{$row['saldoDolarMes04']}</td>
				<td style='display:none;'>{$row['saldoDolarMes05']}</td>
				<td style='display:none;'>{$row['saldoDolarMes06']}</td>
				<td style='display:none;'>{$row['saldoDolarMes07']}</td>
				<td style='display:none;'>{$row['saldoDolarMes08']}</td>
				<td style='display:none;'>{$row['saldoDolarMes09']}</td>
				<td style='display:none;'>{$row['saldoDolarMes10']}</td>
				<td style='display:none;'>{$row['saldoDolarMes11']}</td>
				<td style='display:none;'>{$row['saldoDolarMes12']}</td>
                <td class='text-center' title='Ver detalles de la tarjeta en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesClientesPrestamos' name='{$row['cuenta']}' width='18' height='18' > 
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


