<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$cheque = $_POST['cheque'];
$sucursal = $_POST['sucursal'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select * from openquery(M4000SF, 'SELECT TO_CHAR (TO_DATE(LPAD(ARE.CFE_RECHA, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHARECHAZO,
                                                                   ARE.CNU_CHEQU NROCHEQUE,
                                                                   ARE.CNU_RECHA NRORECHAZO,
                                                                   ARE.TVA_MOVIM MONTO,
                                                                   LPAD(ARE.CCO_RECHA, 2, ''0'') NROMOTIVO,
                                                                   MTG.ANO_LARGA DESMOTIVO,
                                                                   ARE.CCU_OFICI SUCURSAL,
                                                                   ARE.CCUNUMCUE CUENTA,
                                                                   ARE.CCUDIGVER DIGITO,
                                                                   MOL.SCO_IDENT NROCLIENTE,
                                                                   MOL.CNO_CUENT NOMCUENTA,
                                                                   MOL.CCOESTCUE CODESTADO,
                                                                   EST.ANO_CORTA NOMESTADO,
                                                                   MDI.SNO_CIUDA LOCALIDAD,
                                                                   (MDI.SNO_CALLE ||'' N∞ ''|| MDI.SNU_CALLE) DIRECCION,
                                                                   MDI.SCO_POSTA CODPOSTAL
                                                        FROM SFB_ACARE ARE
                                                        INNER JOIN SFB_ACMOL MOL ON MOL.CCU_OFICI = ARE.CCU_OFICI 
                                                                                                AND MOL.CCUNUMCUE = ARE.CCUNUMCUE 
                                                                                                AND MOL.CCUDIGVER = ARE.CCUDIGVER
                                                        INNER JOIN SFB_BSMDI MDI ON MDI.SCO_IDENT = MOL.SCO_IDENT
                                                                                                AND MDI.SNU_DIREC = 1
                                                        INNER JOIN SFB_BSMTG MTG ON MTG.ACO_TABLA = ''CODIRECHA'' 
                                                                                                AND MTG.ACO_CODIG <> '' ''
                                                                                                AND MTG.ACO_CODIG = ARE.CCO_RECHA
                                                                                                AND MTG.ACO_CODIG IN (''06'', ''08'', ''10'', ''02'')
                                                        INNER JOIN SFB_BSMTG EST ON EST.ACO_TABLA = ''CODESTCUE'' 
                                                                                                AND EST.ACO_CODIG <> '' ''
                                                                                                AND EST.ACO_CODIG = MOL.CCOESTCUE
														WHERE ARE.CRE_RECHA BETWEEN (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
                                   and (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))')
";

if (isset($cheque) && $cheque != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE NROCHEQUE = " . $cheque;
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " AND SUCURSAL = " . $sucursal;
    }
} else {				
    //no tiene cuenta
    if (isset($sucursal) && $sucursal != null) {
        //si tiene sucursal agrega en and
        $query = $query . " WHERE SUCURSAL = " . $sucursal;
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
                                            <th>Fecha de Rechazo</th>
                                            <th>Numero de Cheque</th>
                                            <th style='display:none;'>Numero de Rechazo</th>
                                            <th>Monto</th>
                                            <th style='display:none;'>Numero de Motivo</th>
                                            <th>Motivo</th>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th style='display:none;'>Numero de Cliente</th>
                                            <th>Nombre de Cliente</th>
                                            <th style='display:none;'>Codigo de Estado</th>
											<th>Estado</th>
                                            <th style='display:none;'>Localidad</th>
											<th style='display:none;'>Direccion</th>
											<th style='display:none;'>Codigo Postal</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $motivo = utf8_encode($row['DESMOTIVO']);
			$nombre = utf8_encode($row['NOMCUENTA']);
			$localidad = utf8_encode($row['LOCALIDAD']);
			$direccion = utf8_encode($row['DIRECCION']);
            $print = $print . "
            <tr>
                <td>{$row['FECHARECHAZO']}</td>
                <td>{$row['NROCHEQUE']}</td>
                <td style='display:none;'>{$row['NRORECHAZO']}</td>
                <td>{$row['MONTO']}</td>
                <td style='display:none;'>{$row['NROMOTIVO']}</td>
                <td>{$motivo}</td>
                <td>{$row['SUCURSAL']}</td>
                <td style='display:none;'>{$row['CUENTA']}</td>
                <td style='display:none;'>{$row['DIGITO']}</td>
                <td style='display:none;'>{$row['NROCLIENTE']}</td>
                <td>{$nombre}</td>
                <td style='display:none;'>{$row['CODESTADO']}</td>
				<td>{$row['NOMESTADO']}</td>
                <td style='display:none;'>{$localidad}</td>
                <td style='display:none;'>{$direccion}</td>
				<td style='display:none;'>{$row['CODPOSTAL']}</td>
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
    $print = '<br><div class="alert alert-danger text-center" role="alert"> No se pudo realizar la b√∫squeda </div>';
    echo $query;
}

echo $print;


