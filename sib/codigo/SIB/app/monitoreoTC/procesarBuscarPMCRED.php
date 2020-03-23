<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";
$cuis = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$archivo = $_POST['archivo'];
$sucursal = $_POST['sucursal'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select DISTINCT ERR.*, LIQ.NROCOMERCIO, LIQ.NOMBRECOMERCIO, LIQ.CUIT,convert(varchar,cast(MONTO as money),1) AS MONTO2
from openquery(M4000SF, 'SELECT AML.ANO_PROCE ARCHIVO,
                                                      TO_CHAR ( TO_DATE ( LPAD(AML.AFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
                                                      AML.ANU_LOTE LOTE,
                                                      AML.TNUDOCTRA NROLIQUIDACION,
                                                      AML.ACU_OFICI SUCURSAL,
                                                      AML.ACUNUMCUE CUENTA,
                                                      AML.ACUDIGVER DIGITO,
                                                      SUBSTR(AML.ATA_ERROR, 1, 4) ERROR,
                                                      MME.DNOMENSIS DESCRIPCION,
                                                      AML.TVA_MOVIM MONTO,
													  (CASE WHEN AV.ACO_CONCE = 1 THEN ''Cuenta Corriente''
														WHEN AV.ACO_CONCE = 2 THEN ''Caja de ahorro'' 
														ELSE ''Otro''
													END) CONCEPTO
                                        FROM SFB_AAAML AML
                                        INNER JOIN SFB_DAMME MME ON MME.DCOMENSIS = SUBSTR(AML.ATA_ERROR, 1, 4)
										INNER JOIN SFB_AVMCH AV ON AV.VCUNUMCUE = AML.ACUNUMCUE
                                        WHERE (AML.ANO_PROCE = ''PmcredM.txt'' OR AML.ANO_PROCE = ''pmcreda.txt'' OR AML.ANO_PROCE = ''pmcredv.txt'') AND 
                                               AML.TCO_ERROR = ''ERR'' AND 
                                               AML.ACOESTREG = 9 AND
											   AML.are_trans BETWEEN (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
                                   and (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
                                        ORDER BY ANO_PROCE') ERR
LEFT JOIN (select * from openquery([BSCBASES3], 'SELECT LIQ.ArgenLiquiNume NROLIQUIDACION,
                                                                                              LIQ.ArgenComerNume NROCOMERCIO,
                                                                                              COM.argencomerfantanombre NOMBRECOMERCIO,
                                                                                              COM.argencomercuitnume CUIT,
                                                                                              LIQ.AcreditaFecha FECHAACREDITACION
                                                                                 FROM [SmartOpen].[dbo].[ArgenLiqui] LIQ
                                                                                 INNER JOIN [SmartOpen].[dbo].[ArgenComer] COM ON COM.argencomernume = LIQ.ArgenComerNume
                                                                                 WHERE AcreditaFecha >= GETDATE()-30')) LIQ ON LIQ.NROLIQUIDACION = ERR.NROLIQUIDACION AND CAST(FECHAACREDITACION AS DATE) = CAST(FECHA AS DATE)
									";

if (isset($archivo) && $archivo != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE ARCHIVO LIKE '%" . $archivo . "%'";
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
                                    <thead style='background-color:#1d6091;color:white;'>
                                        <tr>
                                            <th>Archivo</th>
											<th>Fecha</th>
                                            <th style='display:none;'>Lote</th>
                                            <th style='display:none;'>Numero de Liquidacion</th>
											<th>Sucursal</th>
											<th>Cuenta</th>
											<th style='display:none;'>Digito</th>
											<th style='display:none;'>Error</th>
											<th>Descripcion</th>
											<th style='display:none;'>Monto</th>
											<th>Concepto</th>
											<th style='display:none;'>Numero de Comercio</th>
											<th style='display:none;'>Nombre de Comercio</th>
											<th style='display:none;'>CUIT</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$descripcion = utf8_encode($row['DESCRIPCION']);
			$nombreComercio = utf8_encode($row['NOMBRECOMERCIO']);
            $print = $print . "
            <tr'>
                <td>{$row['ARCHIVO']}</td>
                <td>{$row['FECHA']}</td>
                <td style='display:none;'>{$row['LOTE']}</td>
                <td style='display:none;'>{$row['NROLIQUIDACION']}</td>
                <td>{$row['SUCURSAL']}</td>
                <td>{$row['CUENTA']}</td>
                <td style='display:none;'>{$row['DIGITO']}</td>
                <td style='display:none;'>{$row['ERROR']}</td>
                <td>{$descripcion}</td>
                <td style='display:none;'>{$row['MONTO2']}</td>
				<td>{$row['CONCEPTO']}</td>
                <td style='display:none;'>{$row['NROCOMERCIO']}</td>
                <td style='display:none;'>{$nombreComercio}</td>
                <td style='display:none;'>{$row['CUIT']}</td>
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


