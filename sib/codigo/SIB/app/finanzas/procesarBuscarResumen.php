<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select TRANSACCION, CAUSAL, NOMBRETRANSACCION, COUNT(NOMBRETRANSACCION) CANTIDAD, convert(varchar,cast(SUM(MONTO) as money),1) AS MONTO, DEBCRE from openquery(M4000SF,'select AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										MTM.DNO_TRANS NOMBRETRANSACCION,
										AHI.DCO_TRANS TRANSACCION, 
										(CASE WHEN 
										AHI.DCODEBCRE = 2 THEN ''CREDITO''
										ELSE ''DEBITO''
										END) DEBCRE
										,
										TO_CHAR (TO_DATE(LPAD(AHI.TFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
										AHI.TNUDOCTRA DOCUMENTO,
										AHI.TVA_MOVIM MONTO
								from SFB_AHAHI AHI
								left join
								SFB_AHMOL MOL ON AHI.ACUNUMCUE = MOL.HCUNUMCUE
								left join
								SFB_AAMTM MTM ON AHI.ACO_CAUSA = MTM.ACO_CAUSA AND MTM.DCO_TRANS = AHI.DCO_TRANS
								left join
								SFB_DXMUS MUS ON AHI.DCO_USUAR = MUS.DCO_USUAR
								where AHI.ACU_MONED = 2 AND AHI.TFETRAREL >= (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
								AND AHI.TFETRAREL <= (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
') group by NOMBRETRANSACCION, CAUSAL, TRANSACCION, DEBCRE
union all
select TRANSACCION, CAUSAL, NOMBRETRANSACCION, COUNT(NOMBRETRANSACCION) CANTIDAD, convert(varchar,cast(SUM(MONTO) as money),1) AS MONTO, DEBCRE from openquery(M4000SF,'select AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										MTM.DNO_TRANS NOMBRETRANSACCION,
										AHI.DCO_TRANS TRANSACCION, 
										(CASE WHEN 
										AHI.DCODEBCRE = 2 THEN ''CREDITO''
										ELSE ''DEBITO''
										END) DEBCRE
										,
										AHI.TVA_MOVIM MONTO
								from SFB_ACAHI AHI
								left join
								SFB_ACMOL MOL ON AHI.ACUNUMCUE = MOL.CCUNUMCUE
								left join
								SFB_AAMTM MTM ON AHI.ACO_CAUSA = MTM.ACO_CAUSA AND MTM.DCO_TRANS = AHI.DCO_TRANS
								left join
								SFB_DXMUS MUS ON AHI.DCO_USUAR = MUS.DCO_USUAR
								where AHI.ACU_MONED = 2 AND AHI.TFETRAREL >= (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
								AND AHI.TFETRAREL <= (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
') group by NOMBRETRANSACCION, CAUSAL, TRANSACCION, DEBCRE
 ";


// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);



if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
											<th>Transaccion</th>
                                            <th>Causal</th>
											<th>Nombre Transaccion</th>
                                            <th>Cantidad</th>
											<th>Monto</th>
                                            <th>Tipo</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombreTransaccion = utf8_encode($row['NOMBRETRANSACCION']);
            $print = $print . "
            <tr>
				<td>{$row['TRANSACCION']}</td>
                <td>{$row['CAUSAL']}</td>
                <td>{$nombreTransaccion}</td>
                <td>{$row['CANTIDAD']}</td>
                <td>{$row['MONTO']}</td>
                <td>{$row['DEBCRE']}</td>
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


