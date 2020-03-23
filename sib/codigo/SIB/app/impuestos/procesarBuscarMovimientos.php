<?php

include_once '../conf/BDConexion.php';
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$cuenta = $_POST['cuenta'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *,convert(varchar,cast(MONTO as money),1) AS monto2 from openquery(M4000SF,'select TO_CHAR (TO_DATE(LPAD(AHI.TFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
										AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										AHI.ACUDIGVER DIGITO,
										AHI.ACUNUMCUE CUENTA,
										(CASE WHEN 
										AHI.DCODEBCRE = 2 THEN ''CREDITO''
										ELSE ''DEBITO''
										END) DEBCRE
										,
										AHI.TVA_MOVIM MONTO
								from SFB_AHAHI AHI
								left join
								SFB_AHMOL MOL ON AHI.ACUNUMCUE = MOL.HCUNUMCUE
								left join
								SFB_AAMTM MTM ON AHI.ACO_CAUSA = MTM.ACO_CAUSA AND MTM.DCO_TRANS = AHI.DCO_TRANS
								left join
								SFB_DXMUS MUS ON AHI.DCO_USUAR = MUS.DCO_USUAR
								where AHI.ACU_MONED = 2 AND AHI.TFETRAREL >= (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
								AND AHI.TFETRAREL <= (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) AND AHI.ACO_CAUSA IN (667,677)
')
union all
select *,convert(varchar,cast(MONTO as money),1) AS monto2 from openquery(M4000SF,'select TO_CHAR (TO_DATE(LPAD(AHI.TFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
										AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										AHI.ACUDIGVER DIGITO,
										AHI.ACUNUMCUE CUENTA,
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
								AND AHI.TFETRAREL <= (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) AND AHI.ACO_CAUSA IN (667,677)
')
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
											<th>Fecha</th>
                                            <th>Causal</th>
											<th>Producto</th>
                                            <th>Sucursal</th>
											<th>Cuenta</th>
                                            <th>Digito</th>
                                            <th>DebCre</th>
											<th>Monto</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr>
				<td>{$row['FECHA']}</td>
                <td>{$row['CAUSAL']}</td>
				<td>{$row['PRODUCTO']}</td>
                <td>{$row['SUCURSAL']}</td>
                <td>{$row['CUENTA']}</td>
                <td>{$row['DIGITO']}</td>
                <td>{$row['DEBCRE']}</td>
                <td>{$row['monto2']}</td>
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


