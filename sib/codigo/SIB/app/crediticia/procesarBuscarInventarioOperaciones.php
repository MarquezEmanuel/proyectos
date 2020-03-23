<?php

include_once '../conf/BDConexion.php';
session_start();
$print = "";

// RECIBE LOS DATOS ENVIADOS POR AJAX
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$estudio = $_POST['estudio'];
$sucursal = $_POST['sucursal'];
$producto = $_POST['producto'];

$desde = date("d/m/y", strtotime($desde));
$desde = str_replace("/","",$desde);
$hasta = date("d/m/y", strtotime($hasta));
$hasta = str_replace("/","",$hasta);

// ESTRUCTURA LA CONSULTA SQL A PARTIR DE LOS CAMPOS RECIBIDOS
$query = "select *,convert(varchar,cast(IMPORTE as money),1) AS IMPORTE2,convert(varchar,cast(IMPO_CUOTA as money),1) AS IMPO_CUOTA2 from openquery(M4000SF,'
SELECT SFB_PPAEE.PCU_OFICI AS SUC, 
       SFB_PPAEE.PCUNUMCUE AS CUENTA, 
       SFB_PPAEE.PCU_PRODU AS PROD, 
       SFB_PPAEE.PCU_MONED AS MON, 
       SFB_AAMPR.ANO_PRODU, 
       SFB_PPAEE.PCOENTEXT AS ESTUDIO, 
       SFB_PPAEE.PNUENTEXT AS FE_ALTA, 
       SFB_PPAHI.PNU_FACTU AS CUOTA, 
	   TO_CHAR ( TO_DATE ( LPAD(SFB_PPAHI.TFE_MCP, 8,''0'') , ''RRRRMMDD'') , ''DD/MM/YYYY'') AS FECHAMCP,
	   TO_CHAR ( TO_DATE ( LPAD(SFB_PPAHI.PFE_APLIC, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') AS FECHAAPLICACION,
       SFB_PPAHI.TVA_MOVIM AS IMPORTE, 
       SFB_PPAHI.DCO_TRANS AS CODIGOTRANSACCION, 
       SFB_PPAHI.ACO_CAUSA AS CAUSA, 
       SFB_AAMTM.DNO_TRANS, 
	   TO_CHAR ( TO_DATE ( LPAD(SFB_PPMFA.PFE_VENCI, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') AS FECHAVENCIMIENTO,
	   TO_CHAR ( TO_DATE ( LPAD(SFB_PPMFA.PFE_ESTAD, 6,''0'') , ''DDMMRRRR'') , ''DD/MM/YYYY'') AS FECHAULTIMOPAGO,
       SFB_PPMFA.PTO_CUOTA AS IMPO_CUOTA, 
       SFB_BSMCL.SNO_CLIEN, 
       SFB_BSADO.SNU_DOCUM,
       SFB_PPMAP.PCOCAMSIT AS ETAPA, 
       CASE SFB_PPMAP.PCOCAMSIT 
       WHEN 15 THEN ''DEMANDADO''
       WHEN 1  THEN ''DETENCION MANUAL DEVENGAMIENTO''
       WHEN 10 THEN ''GESTION EXTRAJUDICIAL''
       ELSE ''''
       END AS DETALLE
FROM ((((((SFB_PPAEE LEFT JOIN SFB_PPAHI ON (SFB_PPAEE.PCUNUMCUE = SFB_PPAHI.ACUNUMCUE) AND (SFB_PPAEE.PCU_OFICI = SFB_PPAHI.ACU_OFICI)) 
                     LEFT JOIN SFB_PPMFA ON (SFB_PPAHI.PNU_FACTU = SFB_PPMFA.PNU_FACTU) AND (SFB_PPAHI.ACUNUMCUE = SFB_PPMFA.PCUNUMCUE) AND (SFB_PPAHI.ACU_OFICI = SFB_PPMFA.PCU_OFICI)) 
                     LEFT JOIN SFB_PPMAP ON (SFB_PPAEE.PCUNUMCUE = SFB_PPMAP.PCUNUMCUE) AND (SFB_PPAEE.PCU_OFICI = SFB_PPMAP.PCU_OFICI)) 
                     LEFT JOIN SFB_BSADO ON SFB_PPMAP.SCO_IDENT = SFB_BSADO.SCO_IDENT) 
                     LEFT JOIN SFB_BSMCL ON SFB_PPMAP.SCO_IDENT = SFB_BSMCL.SCO_IDENT) 
                     LEFT JOIN SFB_AAMTM ON (SFB_PPAHI.DCO_TRANS = SFB_AAMTM.DCO_TRANS) AND (SFB_PPAHI.ACO_CAUSA = SFB_AAMTM.ACO_CAUSA)) 
                     LEFT JOIN SFB_AAMPR ON (SFB_PPAEE.PCU_PRODU = SFB_AAMPR.ACO_PRODU) AND (SFB_PPAEE.PCU_MONED = SFB_AAMPR.DCO_MONED)
WHERE 
SFB_PPAEE.PCOENTEXT IN (18,19,20,22,23,24,107,108,109,112,113,114,115,116,117)
AND SFB_PPAHI.DCO_TRANS in (601,604,607,610, 602, 606,613,605)  
AND SFB_AAMPR.ACO_CONCE=6 
AND SFB_BSADO.SCOTIPDOC IN (34,35) 
AND SFB_AAMTM.ACO_CONCE=6 
AND SFB_PPAHI.TFETRAREL BETWEEN(to_date(lpad(''".$desde."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
                                   and (to_date(lpad(''".$hasta."'', 6 ,''0''),''ddmmrr'')- TO_DATE(''010157'',''ddmmrr'')) 
')
 ";

if (isset($sucursal) && $sucursal != null) {
    //si tiene cuenta empieza el where
    $query = $query . " WHERE SUC = " . $sucursal;
        if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " AND PROD = " . $producto;
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND ESTUDIO = " . $estudio;
				} 
            } else{
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND ESTUDIO = " . $estudio;
				}
			}
}else{
	if (isset($producto) && $producto != null) {
            //si tiene sucursal y tipo debito y saldo y minimo agrega en and
            $query = $query . " WHERE PROD = " . $producto;
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " AND ESTUDIO = " . $estudio;
				} 
            } else{
				if (isset($estudio) && $estudio != null) {
				//si tiene sucursal y tipo debito y saldo y minimo agrega en and
				$query = $query . " WHERE ESTUDIO = " . $estudio;
				} 
			}
}

// SE EJECUTA LA CONSULTA
$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $query);


$_SESSION['buscar'] = $query;
$_SESSION['desde'] = $desde;
$_SESSION['hasta'] = $hasta;


if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th style='display:none;'>Nombre de Producto</th>
                                            <th>Estudio</th>
                                            <th style='display:none;'>Fecha alta</th>
                                            <th>Cuota</th>
                                            <th style='display:none;'>Fecha MCP</th>
                                            <th style='display:none;'>Fecha aplicacion</th>
                                            <th>Importe</th>
											<th style='display:none;'>Codigo de Transaccion</th>
											<th>Causa</th>
											<th style='display:none;'>Denominacion de Transaccion</th>
											<th style='display:none;'>Fecha de Vencimiento</th>
											<th style='display:none;'>Fecha Ultimo Pago</th>
											<th>Importe Cuota</th>
											<th style='display:none;'>Nombre de Cliente</th>
											<th style='display:none;'>Documento de Cliente</th>
											<th style='display:none;'>Etapa</th>
											<th style='display:none;'>Detalle Operacion</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
		$fila = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$nombreProducto = utf8_encode($row['ANO_PRODU']);
			$denominacion = utf8_encode($row['DNO_TRANS']);
			$nombreCliente = utf8_encode($row['SNO_CLIEN']);
            $print = $print . "
            <tr id='{$fila}'>
                <td style='display:none;'>{$row['SUC']}</td>
                <td style='display:none;'>{$row['CUENTA']}</td>
                <td>{$row['PROD']}</td>
                <td style='display:none;'>{$row['MON']}</td>
                <td style='display:none;'>{$nombreProducto}</td>
                <td>{$row['ESTUDIO']}</td>
                <td style='display:none;'>{$row['FE_ALTA']}</td>
                <td>{$row['CUOTA']}</td>
                <td style='display:none;'>{$row['FECHAMCP']}</td>
                <td style='display:none;'>{$row['FECHAAPLICACION']}</td>
                <td>{$row['IMPORTE2']}</td>
                <td style='display:none;'>{$row['CODIGOTRANSACCION']}</td>
				<td>{$row['CAUSA']}</td>
				<td style='display:none;'>{$denominacion}</td>
				<td style='display:none;'>{$row['FECHAVENCIMIENTO']}</td>
				<td style='display:none;'>{$row['FECHAULTIMOPAGO']}</td>
				<td>{$row['IMPO_CUOTA2']}</td>
				<td style='display:none;'>{$nombreCliente}</td>
				<td style='display:none;'>{$row['SNU_DOCUM']}</td>
				<td style='display:none;'>{$row['ETAPA']}</td>
				<td style='display:none;'>{$row['DETALLE']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info detalleChequePagado' name='{$fila}'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
			$fila++;
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


