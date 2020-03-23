<?php

include_once '../conf/BDConexion.php';
include_once '../conf/Constants.php';
include_once '../conf/Log.php';

// RECIBE LOS DATOS ENVIADOS POR AJAX

$print = "";
$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$cuenta = $_POST['cuenta'];
$nombre = $_POST['nombre'];
$cuit = $_POST['cuit'];

// FECHA DEL DIA
if(isset($fechaInicio) && $fechaInicio != null && isset($fechaFin) && $fechaFin != null){
	$fecha2 = str_replace("/", "", date('d/m/y',strtotime($fechaInicio)));
	$fecha3 = str_replace("/", "", date('d/m/y',strtotime($fechaFin)));
} else {
date_default_timezone_set('America/Argentina/Buenos_Aires');
$month = date('m', strtotime('-1 month'));
$day = date("d", mktime(0, 0, 0, $month + 1, 0, date('Y')));
$fecha = ($month == 12) ? date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y', strtotime('-1 year')))) : date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y')));
$fecha2 = str_replace("/", "", $fecha);
}

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "CONCAT(CONCAT(sucursal, cuenta), digito) cuenta from [3cuentasConstanciaSaldo]";
$top = "SELECT ";
if (isset($sucursal) && $sucursal != null) {
    $query = $query . " WHERE sucursal = {$sucursal}";
    $query .= (isset($cuenta) && $cuenta != null) ? " AND cuenta LIKE '%{$cuenta}%' " : "";
} else {
	if (isset($cuenta) && $cuenta != null) {
    $query .= (isset($cuenta) && $cuenta != null) ? " WHERE cuenta LIKE '%{$cuenta}%' " : "";
    $top .= (isset($cuenta) && $cuenta != null) ? "" : " TOP(150) ";
	} else {
		$top .= (isset($cuit) && $cuit != null) ? "" : " TOP(150) ";
	}
}

$query = $top . $query;

$resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
if ($resultado) {
    $cuentas = "";
    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
        $cuentas .= $row["cuenta"] . ",";
    }
    if (isset($nombre) && $nombre != null) {
		if($fecha3){
			$query = " select *, (SALDO_AYER-CREDITO + DEBITO) CALCULO from openquery(M4000SF, 'SELECT MOL.CCU_OFICI SUCURSAL, 
                            MOL.CCUNUMCUE CUENTA, 
                            MOL.CCUDIGVER DIGITO, 
                            MOL.CNO_CUENT NOMBRE, 
                            MOL.CSATOTAYE SALDO_AYER, 
                            MOL.CSATOTHOY SALDO_HOY, 
                            (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO, 
                            (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO 
             FROM SFB_ACMOL MOL 
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1
									AND ARE_VALOR <= (to_date(lpad(''" . $fecha3 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 2
									AND ARE_VALOR <= (to_date(lpad(''" . $fecha3 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN (" . substr($cuentas, 0, -1) . ") AND MOL.CNO_CUENT LIKE ''%" . strtoupper($nombre) . "%'' ')";
		} else {
			$query = " select *, (SALDO_AYER-CREDITO + DEBITO) CALCULO from openquery(M4000SF, 'SELECT MOL.CCU_OFICI SUCURSAL, 
                            MOL.CCUNUMCUE CUENTA, 
                            MOL.CCUDIGVER DIGITO, 
                            MOL.CNO_CUENT NOMBRE, 
                            MOL.CSATOTAYE SALDO_AYER, 
                            MOL.CSATOTHOY SALDO_HOY, 
                            (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO, 
                            (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO 
             FROM SFB_ACMOL MOL 
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 2 
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN (" . substr($cuentas, 0, -1) . ") AND MOL.CNO_CUENT LIKE ''%" . strtoupper($nombre) . "%'' ')";
		}
    } else {
		if(isset($cuit) && $cuit != null){
			if($fecha3){
				$query = " select *, (SALDO_AYER-CREDITO + DEBITO) CALCULO from openquery(M4000SF, 'SELECT MOL.CCU_OFICI SUCURSAL, 
                            MOL.CCUNUMCUE CUENTA, 
                            MOL.CCUDIGVER DIGITO, 
                            MOL.CNO_CUENT NOMBRE, 
                            MOL.CSATOTAYE SALDO_AYER, 
                            MOL.CSATOTHOY SALDO_HOY, 
                            (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO, 
                            (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO 
				FROM SFB_ACMOL MOL 
				INNER JOIN SFB_BSADO ADO ON ADO.SCO_IDENT = MOL.SCO_IDENT
				LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 
									AND ARE_VALOR <= (to_date(lpad(''" . $fecha3 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
				LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 2
									AND ARE_VALOR <= (to_date(lpad(''" . $fecha3 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
				WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN (" . substr($cuentas, 0, -1) . ") AND ADO.SNU_DOCUM = ". $cuit ."')";
			} else{
			$query = " select *, (SALDO_AYER-CREDITO + DEBITO) CALCULO from openquery(M4000SF, 'SELECT MOL.CCU_OFICI SUCURSAL, 
                            MOL.CCUNUMCUE CUENTA, 
                            MOL.CCUDIGVER DIGITO, 
                            MOL.CNO_CUENT NOMBRE, 
                            MOL.CSATOTAYE SALDO_AYER, 
                            MOL.CSATOTHOY SALDO_HOY, 
                            (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO, 
                            (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO 
             FROM SFB_ACMOL MOL 
			 INNER JOIN SFB_BSADO ADO ON ADO.SCO_IDENT = MOL.SCO_IDENT
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 2 
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN (" . substr($cuentas, 0, -1) . ") AND ADO.SNU_DOCUM = ". $cuit ."')";
			}
		} else {
			if($fecha3){
				$query = " select *, (SALDO_AYER-CREDITO + DEBITO) CALCULO from openquery(M4000SF, 'SELECT MOL.CCU_OFICI SUCURSAL, 
                            MOL.CCUNUMCUE CUENTA, 
                            MOL.CCUDIGVER DIGITO, 
                            MOL.CNO_CUENT NOMBRE, 
                            MOL.CSATOTAYE SALDO_AYER, 
                            MOL.CSATOTHOY SALDO_HOY, 
                            (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO, 
                            (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO 
				FROM SFB_ACMOL MOL 
				LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 
									AND ARE_VALOR <= (to_date(lpad(''" . $fecha3 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
				LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 2 
									AND ARE_VALOR <= (to_date(lpad(''" . $fecha3 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
				WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN (" . substr($cuentas, 0, -1) . ") ')";
			} else {
			$query = " select *, (SALDO_AYER-CREDITO + DEBITO) CALCULO from openquery(M4000SF, 'SELECT MOL.CCU_OFICI SUCURSAL, 
                            MOL.CCUNUMCUE CUENTA, 
                            MOL.CCUDIGVER DIGITO, 
                            MOL.CNO_CUENT NOMBRE, 
                            MOL.CSATOTAYE SALDO_AYER, 
                            MOL.CSATOTHOY SALDO_HOY, 
                            (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO, 
                            (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO 
             FROM SFB_ACMOL MOL 
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito 
                                    FROM SFB_ACAHI WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 2 
                                    GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER) 
             WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN (" . substr($cuentas, 0, -1) . ") ')";
			}
		}
    }
    
    $resultado = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);
    if ($resultado && sqlsrv_has_rows($resultado)) {
        $filas = "";
        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $filas .= "
                <tr>
                    <td><input type='checkbox' value='{$row['SUCURSAL']}{$row['CUENTA']}{$row['DIGITO']}' id='cbCorreos' name='cbCorreos[]'></td>
                    <td>{$row['SUCURSAL']}</td>
                    <td>{$row['CUENTA']}</td>
                    <td>{$row['DIGITO']}</td>
                    <td>" . utf8_encode($row['NOMBRE']) . "</td>
                    <td>{$row['CALCULO']}</td>
                </tr>";
        }
        $print = "
            <form method='POST' action='procesarGenerarConstanciaSaldos.php'> 
		<input type='submit' class='btn btn-dark' id='btnEnviarCorreo' name='btnEnviarCorreo' value='Generar'></a>
                &nbsp;
                <a href=reportesTablas.php'><input type='button' class='btn btn-dark' value='Volver'></a>
		&nbsp;
                <a href='descargarSaldos.php'><input type='button' class='btn btn-dark' value='Descargar'></a>
		&nbsp;
                <a href='eliminarSaldos.php'><input type='button' class='btn btn-dark' value='Eliminar'></a>
                <br><br>
                <div class='table-responsive'>
                    <table id='tb_buscar_cuenta' class='table table-striped table-bordered' border='3' style='width: 100%'>
					<input type='hidden' id='fechaInicio' name='fechaInicio' value='{$fecha2}'>
					<input type='hidden' id='fechaFin' name='fechaFin' value='{$fecha3}'>
                        <thead style='background-color:#024d85;color:white;'>
                            <tr>
                                <th class='text-center align-middle'><input type='checkbox' id='seleccionarTodos' name='seleccionarTodos'></th>
                                <th>Sucursal</th>
				<th>Cuenta</th>
                                <th>Digito</th>
				<th>Nombre</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>{$filas}</tbody>
                    </table>
                </div>
            </form>";
    } else {
        ($resultado) ?: Log::escribirError("[{$query}]");
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
    // NO SE CONSULTARON LAS CUENTAS
    Log::escribirError("[{$query}]");
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}
echo $print;
