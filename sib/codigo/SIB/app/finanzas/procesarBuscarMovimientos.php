<?php

include_once '../conf/BDConexion.php';
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$cuenta = $_POST['cuenta'];
$sucursal = $_POST['sucursal'];
$causal = $_POST['causal'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);


// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *,convert(varchar,cast(MONTO as money),1) AS monto2 from openquery(M4000SF,'select AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										AHI.ACUDIGVER DIGITO,
										AHI.ACUNUMCUE CUENTA,
										MOL.SCO_IDENT CLIENTESFB,
										MOL.HNO_CUENT NOMBRE,
										MTM.DNO_TRANS NOMBRETRANSACCION,
										AHI.DCO_TRANS TRANSACCION, 
										AHI.DCO_USUAR NROUSUARIO,
										MUS.DNO_USUAR USUARIO,
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
')
union all
select *,convert(varchar,cast(MONTO as money),1) AS monto2 from openquery(M4000SF,'select AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										AHI.ACUDIGVER DIGITO,
										AHI.ACUNUMCUE CUENTA,
										MOL.SCO_IDENT CLIENTESFB,
										MOL.CNO_CUENT NOMBRE,
										MTM.DNO_TRANS NOMBRETRANSACCION,
										AHI.DCO_TRANS TRANSACCION, 
										AHI.DCO_USUAR NROUSUARIO,
										MUS.DNO_USUAR USUARIO,
										(CASE WHEN 
										AHI.DCODEBCRE = 2 THEN ''CREDITO''
										ELSE ''DEBITO''
										END) DEBCRE
										,
										TO_CHAR (TO_DATE(LPAD(AHI.TFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
										AHI.TNUDOCTRA DOCUMENTO,
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
')
union all
select *,convert(varchar,cast(MONTO as money),1) AS monto2 from openquery(M4000SF,'select AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										AHI.ACUDIGVER DIGITO,
										AHI.ACUNUMCUE CUENTA,
										MOL.SCO_IDENT CLIENTESFB,
										MOL.CNO_CUENT NOMBRE,
										MTM.DNO_TRANS NOMBRETRANSACCION,
										AHI.DCO_TRANS TRANSACCION, 
										AHI.DCO_USUAR NROUSUARIO,
										MUS.DNO_USUAR USUARIO,
										(CASE WHEN 
										AHI.DCODEBCRE = 2 THEN ''CREDITO''
										ELSE ''DEBITO''
										END) DEBCRE
										,
										TO_CHAR (TO_DATE(LPAD(AHI.TFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
										AHI.TNUDOCTRA DOCUMENTO,
										AHI.TVA_MOVIM MONTO
								from SFB_ACATR AHI
								left join
								SFB_ACMOL MOL ON AHI.ACUNUMCUE = MOL.CCUNUMCUE
								left join
								SFB_AAMTM MTM ON AHI.ACO_CAUSA = MTM.ACO_CAUSA AND MTM.DCO_TRANS = AHI.DCO_TRANS
								left join
								SFB_DXMUS MUS ON AHI.DCO_USUAR = MUS.DCO_USUAR
								where AHI.ACU_MONED = 2 AND AHI.TFETRAREL >= (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
								AND AHI.TFETRAREL <= (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
')
union all
select *,convert(varchar,cast(MONTO as money),1) AS monto2 from openquery(M4000SF,'select AHI.ACO_CAUSA CAUSAL,
										AHI.ACU_OFICI SUCURSAL,
										AHI.ACU_PRODU PRODUCTO,
										AHI.ACUDIGVER DIGITO,
										AHI.ACUNUMCUE CUENTA,
										MOL.SCO_IDENT CLIENTESFB,
										MOL.HNO_CUENT NOMBRE,
										MTM.DNO_TRANS NOMBRETRANSACCION,
										AHI.DCO_TRANS TRANSACCION, 
										AHI.DCO_USUAR NROUSUARIO,
										MUS.DNO_USUAR USUARIO,
										(CASE WHEN 
										AHI.DCODEBCRE = 2 THEN ''CREDITO''
										ELSE ''DEBITO''
										END) DEBCRE
										,
										TO_CHAR (TO_DATE(LPAD(AHI.TFE_TRANS, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') FECHA,
										AHI.TNUDOCTRA DOCUMENTO,
										AHI.TVA_MOVIM MONTO
								from SFB_AHATR AHI
								left join
								SFB_AHMOL MOL ON AHI.ACUNUMCUE = MOL.HCUNUMCUE
								left join
								SFB_AAMTM MTM ON AHI.ACO_CAUSA = MTM.ACO_CAUSA AND MTM.DCO_TRANS = AHI.DCO_TRANS
								left join
								SFB_DXMUS MUS ON AHI.DCO_USUAR = MUS.DCO_USUAR
								where AHI.ACU_MONED = 2 AND AHI.TFETRAREL >= (to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
								AND AHI.TFETRAREL <= (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr''))
')
 ";

if (isset($cuenta) && $cuenta != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE CUENTA = " . $cuenta;
        if (isset($sucursal) && $sucursal != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND SUCURSAL = " . $sucursal;
			if (isset($causal) && $causal != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND CAUSAL = " . $causal;
            }
        } else {
			if (isset($causal) && $causal != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND CAUSAL = " . $causal;
            }
		}
}else{
	if (isset($sucursal) && $sucursal != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE SUCURSAL = " . $sucursal;
			if (isset($causal) && $causal != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND CAUSAL = " . $causal;
            }
        } else {
			if (isset($causal) && $causal != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE CAUSAL = " . $causal;
            }
		}
}

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
                                            <th style='display:none;'>Digito</th>
                                            <th style='display:none;'>Clientes SFB</th>
                                            <th>Nombre</th>
                                            <th>Transaccion</th>
                                            <th style='display:none;'>Nro Transaccion</th>
                                            <th style='display:none;'>Nro Usuario</th>
                                            <th style='display:none;'>Usuario</th>
                                            <th>DebCre</th>
											<th style='display:none;'>Documento</th>
											<th>Monto</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombre = utf8_encode($row['NOMBRE']);
			$nombreTransaccion = utf8_encode($row['NOMBRETRANSACCION']);
			$usuario = utf8_encode($row['USUARIO']);
            $print = $print . "
            <tr>
				<td>{$row['FECHA']}</td>
                <td>{$row['CAUSAL']}</td>
				<td>{$row['PRODUCTO']}</td>
                <td>{$row['SUCURSAL']}</td>
                <td>{$row['CUENTA']}</td>
                <td style='display:none;'>{$row['DIGITO']}</td>
                <td style='display:none;'>{$row['CLIENTESFB']}</td>
                <td>{$nombre}</td>
                <td>{$nombreTransaccion}</td>
                <td style='display:none;'>{$row['TRANSACCION']}</td>
                <td style='display:none;'>{$row['NROUSUARIO']}</td>
                <td style='display:none;'>{$usuario}</td>
                <td>{$row['DEBCRE']}</td>
                <td style='display:none;'>{$row['DOCUMENTO']}</td>
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


