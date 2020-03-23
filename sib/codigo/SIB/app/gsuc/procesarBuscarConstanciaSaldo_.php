<?php

include_once '../conf/BDConexion.php';
include_once '../conf/Constants.php';
include_once '../conf/Log.php';

$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX

$sucursal = $_POST['sucursal'];
$cuenta = $_POST['cuenta'];
$nombre = $_POST['nombre'];

// FECHA DEL DIA

date_default_timezone_set('America/Argentina/Buenos_Aires');
$month = date('m', strtotime('-1 month'));
$day = date("d", mktime(0, 0, 0, $month + 1, 0, date('Y')));
if ($month == 12) {
    $fecha2 = date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y', strtotime('-1 year'))));
} else {
    $fecha2 = date('d/m/y', mktime(0, 0, 0, $month, $day, date('Y')));
}
$fecha2 = str_replace("/", "", $fecha2);

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "";

if (isset($cuenta) && $cuenta != null) {

// SE INGRESO UN NUMERO DE CUENTA

    $query = "select *, convert(varchar,cast((SALDO_AYER-CREDITO + DEBITO) as money),1) AS CALCULO
		from openquery(M4000SF,'SELECT MOL.CCU_OFICI SUCURSAL,
                        MOL.CCUNUMCUE CUENTA, 
                        MOL.CCUDIGVER DIGITO, 
                        MOL.CNO_CUENT NOMBRE,
                        MOL.CSATOTAYE SALDO_AYER, 
                        MOL.CSATOTHOY SALDO_HOY, 
                        (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO,
                        (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO
             FROM SFB_ACMOL MOL
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito
                        FROM SFB_ACAHI 
                        WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 AND (ACUNUMCUE) IN 
                        (" . $cuenta . ")
                       GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
             LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito
                        FROM SFB_ACAHI 
                        WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))  and dcodebcre = 2 AND (ACUNUMCUE) IN 
                        (" . $cuenta . ")
                        GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
             WHERE (CCUNUMCUE) IN (" . $cuenta . ") ')";
    if (isset($sucursal) && $sucursal != null) {
        $query = $query . " WHERE SUCURSAL = " . $sucursal;
        if ($nombre && $nombre) {
            $query = $query . " AND NOMBRE LIKE '%" . $nombre . "%'";
        }
    } else {
        if ($nombre && $nombre) {
            $query = $query . " WHERE NOMBRE LIKE '%" . $nombre . "%'";
        }
    }
} else {
    $clientes = "select * from [3cuentasConstanciaSaldo]";
    $cuits = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $clientes);
    while ($row = sqlsrv_fetch_array($cuits, SQLSRV_FETCH_ASSOC)) {
        $cuis = $cuis . "{$row['sucursal']}{$row['cuenta']}{$row['digito']},";
    }
    $cuis = trim($cuis, ',');
    $query = $query . "select *, convert(varchar,cast((SALDO_AYER-CREDITO + DEBITO) as money),1) AS CALCULO
	from openquery(M4000SF,'SELECT MOL.CCU_OFICI SUCURSAL,
											   MOL.CCUNUMCUE CUENTA, 
											   MOL.CCUDIGVER DIGITO, 
											   MOL.CNO_CUENT NOMBRE,
                                               MOL.CSATOTAYE SALDO_AYER, 
                                               MOL.CSATOTHOY SALDO_HOY, 
                                               (CASE WHEN DEB.DEBITO IS NULL THEN 0 ELSE DEB.DEBITO END) DEBITO,
                                               (CASE WHEN CRE.CREDITO IS NULL THEN 0 ELSE CRE.CREDITO END) CREDITO
                                        FROM SFB_ACMOL MOL
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) debito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) and dcodebcre = 1 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (" . $cuis . ")
                                                     GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) DEB ON DEB.cuenta = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        LEFT JOIN (SELECT ACU_OFICI||ACUNUMCUE||ACUDIGVER cuenta, sum(tva_movim) credito
                                                      FROM SFB_ACAHI 
                                                      WHERE ARE_VALOR > (to_date(lpad(''" . $fecha2 . "'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))  and dcodebcre = 2 AND (ACU_OFICI||ACUNUMCUE||ACUDIGVER) IN 
                                                      (" . $cuis . ")
                                                      GROUP BY (ACU_OFICI||ACUNUMCUE||ACUDIGVER)) CRE ON CRE.CUENTA = (CCU_OFICI||CCUNUMCUE||CCUDIGVER)
                                        WHERE (CCU_OFICI||CCUNUMCUE||CCUDIGVER) IN 
                                        (" . $cuis . ") ')";
    if (isset($sucursal) && $sucursal != null) {
        $query = $query . " WHERE SUCURSAL = " . $sucursal;
        if ($nombre && $nombre) {
            $query = $query . " AND NOMBRE LIKE '%" . $nombre . "%'";
        }
    } else {
        if ($nombre && $nombre) {
            $query = $query . " WHERE NOMBRE LIKE '%" . $nombre . "%'";
        }
    }
}

echo $query;

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);

if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<form method='POST' action='procesarGenerarConstanciaSaldos.php'> 
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
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['NOMBRE']);
            $print = $print . "
            <tr>
				<td><input type='checkbox' value='{$row['SUCURSAL']}{$row['CUENTA']}{$row['DIGITO']}' id='cbCorreos' name='cbCorreos[]'></td>
                <td>{$row['SUCURSAL']}</td>
				<td>{$row['CUENTA']}</td>
                <td>{$row['DIGITO']}</td>
				<td>{$nombre}</td>
				<td>{$row['CALCULO']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table></div>
                    </form>
        ";
    } else {
// SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
} else {
// OCURRIO UN ERROR 
    Log::escribirError("[$query]");
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la búsqueda </div>';
}

echo $print;
